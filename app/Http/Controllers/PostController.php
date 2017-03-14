<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\Upload;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller {

    /**
     * @api {get} /post/ Get list of Post
     * @apiName GetPost
     * @apiGroup Post
     *
     * @apiParam {Integer} singer_id    Filter posts by singer's id
     * @apiParam {String} with          Separate by "," character
     * - `singer`   : Return with singer info
     * - `meta`     : Return with meta info of post such as Like count, Comment count..
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
            $posts = Post::query();
            if ($request->has('singer_id')) {
                $posts->where('singer_id', $request->get('singer_id'));
            }

            if ($request->has('with')) {
                $with = explode(',', $request->get('with'));
                foreach ($with as $param) {
                    if ($param == 'meta') {
                        $posts->with('commentsCount');
                        $posts->with('likesCount');
                    }

                    if ($param == 'singer') {
                        $posts->with('singer');
                    }
                }
            }

            // Order by created field as default
            $posts->orderBy('created_at', 'DESC');

            $posts = $posts->get();

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
     *              "id": 1,
     *          }
     *      }
     */
    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Post::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
            
            $post = new Post();
            $post->fill($data);
            $post->save();

            if ($request->file('photo') && $request->file('photo')->isValid()) {
                $post->photo = $data['photo'];
                $nameThumb = "post_{$post->id}_" .  date('YmdHis');
                $uploadThumb = uploadImage($request, 'photo', post_path($post->singer_id), $nameThumb);
                if ($uploadThumb) {

                    $oldThumb = post_path($post->singer_id) . DS . $post->getAttributes()['photo'];
                    if (is_file($oldThumb)) unlink($oldThumb);

                    $oldImg = post_path($post->singer_id) . DS . 'thumb_' . $post->getAttributes()['photo'];
                    if (is_file($oldImg)) unlink($oldImg);

                    $post->photo = $uploadThumb;
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
     * @api {get} /post/:id Get detail of a Post
     * @apiName GetPostDetail
     * @apiGroup Post
     *
     * @apiParam {Integer} id Post unique ID.
     *
     * @apiParam {String} with Separate by "," character
     * - `singer`   : Return with singer info
     * - `meta`     : Return with meta info of post such as Like count, Comment count..
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

            if ($request->has('with')) {
                $with = explode(',', $request->get('with'));
                foreach ($with as $param) {
                    if ($param == 'meta') {
                        $post->commentsCount;
                        $post->likesCount;
                    }

                    if ($param == 'singer') {
                        $post->singer;
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
     * @apiParam {Integer} singerId Unique user ID of Singer.
     *
     * @apiParam {String} with Separate by "," character
     * - `singer`   : Return with singer info
     * - `meta`     : Return with meta info of post such as Like count, Comment count..
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
    public function latest(Request $request, $singerId) {
        //
        try {
            $post = Post::where(['singer_id' => $singerId])
                ->orderBy('created_at', 'DESC')
                ->firstOrFail();

            if ($request->has('with')) {
                $with = explode(',', $request->get('with'));
                foreach ($with as $param) {
                    if ($param == 'meta') {
                        $post->commentsCount;
                        $post->likesCount;
                    }

                    if ($param == 'singer') {
                        $post->singer;
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
                $nameThumb = "post_{$post->id}_" .  date('YmdHis');
                $uploadThumb = uploadImage($request, 'photo', post_path($post->singer_id), $nameThumb);
                if ($uploadThumb) {

                    // Remove old files
                    /*$oldThumb = post_path($post->singer_id) . DS . $post->getAttributes()['photo'];
                    if (is_file($oldThumb)) unlink($oldThumb);

                    $oldImg = post_path($post->singer_id) . DS . 'thumb_' . $post->getAttributes()['photo'];
                    if (is_file($oldImg)) unlink($oldImg);*/

                    $post->photo = $uploadThumb;
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
            $liked = PostLike::where([
                'post_id' => $post->id,
                'user_id' => Auth::user()->id
            ])->count();
            if ($liked)
                return $this->responseError(['You liked the post'], 409);

            $like = new PostLike([
                'post_id' => $post->id,
                'user_id' => Auth::user()->id
            ]);
            $like->save();

            $post->likesCount;

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
            $liked = PostLike::where([
                'post_id' => $post->id,
                'user_id' => Auth::user()->id
            ]);
            if (!$liked->count())
                return $this->responseError(['You did not like the post before'], 409);

            $liked->delete();

            $post->likesCount;

            return $this->responseSuccess($post);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    // Paused
    public function upload(Request $request) {
        //
        try {
            $data = $request->all();

            $validation = \Validator::make($data, Upload::rules('image'));
            if ($validation->fails()) {
                return $this->responseError($validation->errors()->all(), 422);
            }

            $name = hash('md5', date('YmdHis'));
            $upload = uploadMedia($request, 'file', post_path($data['singer_id']), $name );

            if (!$upload) {
                return $this->responseError('Could not do the upload', 200, $data);
            } else {
                return json_encode(['link' => url('resources/uploads/' . $data['singer_id'] . '/post/' . $upload)]);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}