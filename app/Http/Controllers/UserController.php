<?php 
/*
  * TODO
  * - Upload/Edit avatar image
  *
  * */
namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Auth;
use App\Models\Authentication;
use App\Models\AuthToken;
use App\Models\Song;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Mail;

class UserController extends Controller {

    public function index(Request $request) {
        //
        try {
            $currentUser = $this->getAuthenticatedUser();

            if ($currentUser->level == Authentication::AUTH_ADMIN) {
                $auths = Authentication::all();

                return $this->responseSuccess($auths);
            } else {
                return $this->responseError('Cannot find user', 200);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    /**
     * @api {post} /user/ Create new User
     * @apiName CreateUser
     * @apiGroup User
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          'sec_name' => 'required|max:255|unique,
     *          'sec_pass' => 'required|min:6|max:30',
     *          'name' => '',
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "id": 9
     *              "sec_name": "fan1@example.com",
     *              "updated_at": "2016-01-11 10:58:23",
     *              "created_at": "2016-01-11 10:58:23",
     *          }
     *      }
     */
    public function store(Request $request) {
        // Create user
        try {
            $data = $request->all();

            $validator = Validator::make($data, Authentication::rules('create'));

            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $auth = new Authentication($data);
            $auth->sec_pass = \Hash::make($data['sec_pass']);
            $auth->level = Authentication::AUTH_USER;

            if ($auth->save()) {
                if ($auth->type == Authentication::AUTH_TYPE_EMAIL) {
                    $token = new AuthToken();
                    $token->auth_id = $auth->id;
                    $token->token = md5($auth->sec_name . date('YmdHis'));

                    $token->save();

                    Mail::send('emails.active', ['token' => $token->token], function ($m) use ($auth) {
                        $m->from('support@zilack.com', 'Support Zilack');
                        $m->to($auth->sec_name, $auth->name)->subject('Active account Zilack');
                    });
                }
            }

            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function active($token) {
        try {
            $token = AuthToken::where('token', $token)->first();

            if ($token) {
                // Active user
                $auth = Authentication::where('id', $token->auth_id)->first();
                $auth->status = Authentication::AUTH_STATUS_ACTIVE;
                $auth->save();

                // Delete token
                $token->delete();

                return $this->responseSuccess(array('active' => true));
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /user/:id Get detail of a User
     * @apiName GetUserDetail
     * @apiGroup User
     *
     * @apiParam {Integer} id User unique ID.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "id": 9
     *              "email": "fan1@example.com",
     *              "role": "fan",
     *              ...
     *          }
     *      }
     */
    public function show($id) {
        //
        try {
            $auth = Authentication::findOrFail($id);
            
            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {put} /user/:id Update existing User
     * @apiName UpdateUser
     * @apiGroup User
     *
     * @apiParam {Integer} id User unique ID.
     *
     * @apiParamExample {json} PUT Request-Example:
     *     {
     *
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
            $auth = Authentication::findOrFail($id);

            $data = $request->all();
            $rules = Authentication::rules('update', $id);

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $auth->fill($data);
            if (isset($data['sec_pass']) && !empty($data['sec_pass'])) {
                $auth->sec_pass = \Hash::make($data['sec_pass']);
            }

            $auth->save();

            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    public function destroy($id) {
        //
        try {
            $auth = Authentication::findOrFail($id);

            // TODO Only Admin could delete user
            $auth->delete();

            return $this->responseSuccess(['User is deleted']);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    /**
     * @api {get} /search/  Search some pre-defined regions
     * @apiName Search
     * @apiGroup User
     *
     * @apiParam {String} keyword String as keyword
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
    public function search(Request $request) {
        try {
            $keyword = $request->get('keyword');
            $content_id = $request->get('content_id');

            $queryAlbums = Album::query();
            
            $queryAlbums->where(function ($queryAlbums) use ($keyword) {
                $queryAlbums->where('name', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%");
            });
            
            $queryAlbums->whereNull('deleted_at')
                ->where('is_public', true);
            
            if ($content_id) {
                $queryAlbums->where('content_id', $content_id);
            }
                
            $albums = $queryAlbums->get();

            $querySongs = Song::query();
            
            $querySongs->where(function ($querySongs) use ($keyword) {
                $querySongs->where('name', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%");
            });
            
            $querySongs->whereNull('deleted_at')
                ->where('is_public', true);
            
            if ($content_id) {
                $querySongs->where('content_id', $content_id);
            }
            
            $songs = $querySongs->get();

            $queryVideos = Video::query();
            
            $queryVideos->where(function ($queryVideos) use ($keyword) {
                $queryVideos->where('name', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%");
            });
            
            $queryVideos->whereNull('deleted_at')
                ->where('is_public', true);
            
            if ($content_id) {
                $queryVideos->where('content_id', $content_id);
            }
            
            $videos = $queryVideos->get();


            $result = [
                'albums' => $albums,
                'songs' => $songs,
                'videos' => $videos
            ];
            return $this->responseSuccess($result);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}