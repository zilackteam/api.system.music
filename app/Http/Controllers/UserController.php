<?php 
/*
  * TODO
  * - Upload/Edit avatar image
  *
  * */
namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AppUser;
use App\Models\Auth;
use App\Models\Authentication;
use App\Models\AuthToken;
use App\Models\Song;
use App\Models\User;
use App\Models\Video;
use App\Models\ManagerSinger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Mail;

class UserController extends Controller {

    public function index(Request $request) {
        //
        try {
            $auth = Authentication::findOrFail($request->auth_id);

            $users = User::query();

            if ($auth->level == Authentication::AUTH_MANAGER) {
                $currentUser = $this->getAuthenticatedUser();
            }

            $users->with('authentication');
            $users = $users->get();

            return $this->responseSuccess($users);
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
                $user = new User($data);
                $user->auth_id = $auth->id;

                $user->save();

                if ($auth->type == Authentication::AUTH_TYPE_EMAIL) {
                    $token = new AuthToken();
                    $token->auth_id = $auth->id;
                    $token->token = md5($auth->sec_name . date('YmdHis'));

                    $token->save();

                    Mail::send('emails.active', ['token' => $token->token], function ($m) use ($auth, $user) {
                        $m->from('support@zilack.com', 'Support Zilack');
                        $m->to($auth->sec_name, $user->name)->subject('Active account Zilack');
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
            $user = User::with('authentication')->findOrFail($id);
            
            return $this->responseSuccess($user);
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
            $user = User::findOrFail($id);

            $data = $request->all();
            $rules = User::rules('update', $id);

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $user->fill($data);
            $user->save();

            $auth = Authentication::findOrFail($user->auth_id);

            $rules = Authentication::rules('update', $auth->id);
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $auth->fill($data);

            if (isset($data['sec_pass']) && !empty($data['sec_pass'])) {
                $auth->sec_pass = \Hash::make($data['sec_pass']);
            }

            $auth->save();

            $user->authentication;

            return $this->responseSuccess($user);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    public function destroy($id) {
        //
        try {
            $user = User::findOrFail($id);

            $auth = Authentication::findOrFail($user->auth_id);

            // TODO Only Admin could delete user
            $auth->delete();
            $user->delete();

            return $this->responseSuccess(['User is deleted']);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    /**
     * @api {post} /user/change-password Change Password
     * @apiName UserChangePassword
     * @apiGroup User
     *
     *
     * @apiParamExample {json} POST Request-Example:
     *     {
     *          "current_password": "Current Password",
     *          "new_password" : "New Password",
     *          "new_password_confirmation" : "New Password Repeat"
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
    public function changePassword(Request $request) {
        //
        try {
            $currentUser = $this->getAuthenticatedUser();

            $data = $request->all();
            $validator = \Validator::make($data, User::rules('changePassword'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            if (!\Hash::check($data['current_password'], $currentUser->password))
                return $this->responseError('Current password is incorrect', 422);

            $currentUser->password = \Hash::make($data['new_password']);
            $currentUser->save();

            return $this->responseSuccess(['password_changed']);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /user/avatar Upload user avatar
     * @apiName UserAvatarUpload
     * @apiGroup User
     *
     * @apiParamExample {json} POST Request-Example:
     *     {
     *          'id' => 1
     *          'avatar' => 'required|mimes:jpeg,jpg,png',
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "avatar": "http://..."
     *          }
     *      }
     *
     *
     */
    public function avatar(Request $request) {
        try {
            $data = $request->all();

            $user = User::findOrFail($request->get('id'));

            $id = $user->auth_id;

            $validator = Validator::make($data, User::rules('avatar'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            if ($request->file('avatar')) {
                $nameThumb = 'avatar_' . date('YmdHis');
                $uploadThumb = uploadImage($request, 'avatar', avatar_path($id), $nameThumb);

                if ($uploadThumb) {
                    if ($user->getAttributes()['avatar']) {
                        if (is_file(avatar_path($id) . DS . $user->getAttributes()['avatar'])) {
                            unlink(avatar_path($id) . DS . $user->getAttributes()['avatar']);    
                        }

                        if (is_file(avatar_path($id) . DS . 'thumb_' . $user->getAttributes()['avatar'])) {
                            unlink(avatar_path($id) . DS . 'thumb_' . $user->getAttributes()['avatar']);
                        }
                    }

                    $user->avatar = $uploadThumb;
                    $user->save();

                    return $this->responseSuccess(['avatar' => $user->avatar]);
                } else {
                    return $this->responseError(['Could not upload avatar'], 200, $user);
                }
            }

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