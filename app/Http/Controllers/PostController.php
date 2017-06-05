<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Upload;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Queries\PostQueryBuilder;
use App\Models\Notification;

class PostController extends Controller {

    /**
     * @api {get} /post/ Get list of Post
     * @apiName GetPost
     * @apiGroup Post
     *
     * @apiParam {Integer} content_id    Filter posts by content id
     * @apiParam {String} includes       Separate by "," character
     * - `comments`      : Return with comments
     * - `commentCount` : Return with meta info comment count..
     * - `likeCount`    : Return with meta info like count..
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": [
     *              {
     *                  "id": 1,
     *                  ...
     *              },
     *              {..}
     *          ]
     *      }
     */
    public function index(Request $request) {
        //
        try {
            $queryBuilder = new PostQueryBuilder(new Post, $request);
            
            $posts = $queryBuilder->build()->get();

            return $this->responseSuccess($posts);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /post/ Create new Post
     * @apiName CreatePost
     * @apiGroup Post
     *
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          'content': 'Post content'
     *          'photo' : File
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "id": 1,
     *          }
     *      }
     */
    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            $auth = $this->getAuthenticatedUser();

            if ($auth) {
                $data['master_id'] = $auth->id;
                $data['content_id'] = $auth->content_id;
            }

            $validator = \Validator::make($data, Post::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
            
            $post = new Post();
            $post->fill($data);
            $post->save();

            if ($request->file('photo') && $request->file('photo')->isValid()) {
                $post->photo = $data['photo'];
                $namePhoto = "post_{$post->id}_" .  date('YmdHis');
                $uploadPhoto = uploadImage($request, 'photo', post_path($post->content_id), $namePhoto);
                if ($uploadPhoto) {
                    $oldImg = post_path($post->content_id) . DS . $post->getAttributes()['photo'];
                    if (is_file($oldImg)) unlink($oldImg);

                    $oldThumb = post_path($post->content_id) . DS . 'thumb_' . $post->getAttributes()['photo'];
                    if (is_file($oldThumb)) unlink($oldThumb);

                    $post->photo = $uploadPhoto;
                    $post->save();

                } else {
                    return $this->responseError('Could not update song file', 200, $post);
                }
            }

            $dataPush = array(
                'content_id' => $auth->content_id,
                'title' => '',
                'content' => substr($data['content'], 0, 50),
            );

            $notification = Notification::sendPushNotification($dataPush);

            if (!$notification) {
                return $this->responseError('Please add server key', 422);
            }

            return $this->responseSuccess($post);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /post/:id Get detail of a Post
     * @apiName GetPostDetail
     * @apiGroup Post
     *
     * @apiParam {Integer} id Post unique ID.
     *
     * @apiParam {String} includes Separate by "," character
     * - `comments`      : Return with comments
     * - `commentCount` : Return with meta info comment count..
     * - `likeCount`    : Return with meta info like count..
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *
     *          }
     *      }
     */
    public function show(Request $request, $id) {
        //
        try {
            $post = Post::findOrFail($id);

            if ($request->has('includes')) {
                $with = explode(',', $request->get('includes'));
                foreach ($with as $param) {
                    if ($param == 'commentCount') {
                        $post->commentCount;
                    }

                    if ($param == 'likeCount') {
                        $post->likeCount;
                    }

                    if ($param == 'comments') {
                        $post->comments;
                    }

                    if ($param == 'master') {
                        $post->master;
                    }
                }
            }

            return $this->responseSuccess($post);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /post/latest/:singerId Get latest Post of a singer
     * @apiName GetLatestPost
     * @apiGroup Post
     *
     * @apiParam {Integer} contentId .
     *
     * @apiParam {String} includes Separate by "," character
     * - `comments`      : Return with comments
     * - `commentCount` : Return with meta info comment count..
     * - `likeCount`    : Return with meta info like count..
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *
     *          }
     *      }
     */
    public function latest(Request $request, $contentId) {
        //
        try {
            $post = Post::where(['content_id' => $contentId])
                ->orderBy('created_at', 'DESC')
                ->first();

            if ($post) {
                if ($request->has('includes')) {
                    $with = explode(',', $request->get('includes'));
                    foreach ($with as $param) {
                        if ($param == 'commentCount') {
                            $post->commentCount;
                        }

                        if ($param == 'likeCount') {
                            $post->likeCount;
                        }

                        if ($param == 'comments') {
                            $post->comments;
                        }

                        if ($param == 'master') {
                            $post->master;
                        }
                    }
                }
            }

            return $this->responseSuccess($post);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /post/:id Update existing Post
     * @apiName UpdatePost
     * @apiGroup Post
     *
     * @apiParam {Integer} id Post unique ID.
     *
     * @apiParamExample {json} POST Request-Example:
     *     {
     *          'singer_id' : 2
     *          'content': 'Post content'
     *          'photo' : File
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *
     *          }
     *      }
     */
    public function update(Request $request, $id) {
        //
        try {
            $post = Post::findOrFail($id);

            $data = $request->all();
            $validator = \Validator::make($data, Post::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $post->fill($data);
            $post->save();

            if ($request->file('photo') && $request->file('photo')->isValid()) {
                $namePhoto = "post_{$post->id}_" .  date('YmdHis');
                $uploadPhoto = uploadImage($request, 'photo', post_path($post->content_id), $namePhoto);

                if ($uploadPhoto) {
                    $post->photo = $uploadPhoto;
                    $post->save();

                } else {
                    return $this->responseError('Could not update song file', 200, $post);
                }
            }

            return $this->responseSuccess($post);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {delete} /post/:id Soft-delete existing Post
     * @apiName DeletePost
     * @apiGroup Post
     *
     * @apiParam {Integer} id Post unique ID.
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *
     *          }
     *      }
     */
    public function destroy($id) {
        //
        try {
            $post = Post::findOrFail($id);
            $post->delete();

            return $this->responseSuccess('Post is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} post/:post_id/like/ Like a post
     * @apiName LikePost
     * @apiGroup Post
     *
     * @apiParam {Integer} post_id Post's ID
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              ...
     *              "likes_count": {
     *                  "post_id": 1,
     *                  "total": 1
     *              }
     *          }
     *      }
     */
    public function like($postId) {
        try {
            $post = Post::findOrFail($postId);

            $auth = $this->getAuthenticatedUser();

            $liked = PostLike::where([
                'post_id' => $post->id,
                'user_id' => $auth->id
            ])->count();

            if ($liked)
                return $this->responseError(['You liked the post'], 409);

            $like = new PostLike([
                'post_id' => $post->id,
                'user_id' => $auth->id
            ]);

            $like->save();

            $post = Post::findOrFail($postId);

            return $this->responseSuccess($post);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} post/:post_id/unlike/ Unlike a post
     * @apiName UnlikePost
     * @apiGroup Post
     *
     * @apiParam {Integer} post_id Post's ID
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              ...
     *              "likes_count": {
     *                  "post_id": 1,
     *                  "total": 0
     *              }
     *          }
     *      }
     */
    public function unlike($postId) {
        try {
            $post = Post::findOrFail($postId);

            $auth = $this->getAuthenticatedUser();

            $liked = PostLike::where([
                'post_id' => $post->id,
                'user_id' => $auth->id
            ]);
            if (!$liked->count())
                return $this->responseError(['You did not like the post before'], 409);

            $liked->delete();

            $post = Post::findOrFail($postId);

            return $this->responseSuccess($post);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}