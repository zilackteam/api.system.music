<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {

    /**
     * @api {get} post/:post_id/comment/ Get list of Comment
     * @apiName GetComment
     * @apiGroup Comment
     *
     * @apiParam {Integer} post_id Post that comments belong to
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
    public function index(Request $request, $postId) {
        //
        try {
            $comments = Comment::query();
            $comments->where('post_id', $postId);
            $comments->with('user');

            $comments = $comments->get();

            return $this->responseSuccess($comments);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} post/:post_id/comment/ Create new Comment
     * @apiName CreateComment
     * @apiGroup Comment
     *
     * @apiParam {Integer} post_id Post that comments belong to
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          'content' : 'Comment message'
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
    public function store(Request $request, $postId) {
        //
        try {
            $post = Post::findOrFail($postId);

            $auth = $this->getAuthenticatedUser();
            $authId = $auth->id;

            $user = User::where('auth_id', $authId)->first();

            $data = $request->all();
            $data['post_id'] = $post->id;
            $data['user_id'] = $user->id;

            $validator = \Validator::make($data, Comment::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $comment = new Comment();
            $comment->fill($data);
            $comment->save();

            return $this->responseSuccess($comment);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /comment/:id Get detail of a Comment
     * @apiName GetCommentDetail
     * @apiGroup Comment
     *
     * @apiParam {Integer} id Comment unique ID.
     *
     * @apiParam {String} with          Separate by "," character
     * - `post`     : Return with post info
     * - `user`     : Return with user info
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
            $comment = Comment::findOrFail($id);

            if ($request->has('includes')) {
                $with = explode(',', $request->get('with'));
                foreach ($with as $param) {
                    if ($param == 'post') {
                        $comment->post;
                    }

                    if ($param == 'user') {
                        $comment->user;
                    }
                }
            }

            return $this->responseSuccess($comment);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {put} /comment/:id Update existing Comment
     * @apiName UpdateComment
     * @apiGroup Comment
     *
     * @apiParam {Integer} id Comment unique ID.
     *
     * @apiParamExample {json} PUT Request-Example:
     *     {
     *          'post_id': 1
     *          'comment': 'Comment message'
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
            $comment = Comment::findOrFail($id);

            $auth = $this->getAuthenticatedUser();
            $authId = $auth->id;

            $user = User::where('auth_id', $authId)->first();

            $data = $request->all();
            $data['user_id'] = $user->id;
            $validator = \Validator::make($data, Comment::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $comment->fill($data);
            $comment->save();

            return $this->responseSuccess($comment);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {delete} /comment/:id Soft-delete existing Comment
     * @apiName DeleteComment
     * @apiGroup Comment
     *
     * @apiParam {Integer} id Comment unique ID.
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
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return $this->responseSuccess('Comment is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}
