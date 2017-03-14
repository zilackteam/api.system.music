<?php 
/*
  * TODO
  * - Upload/Edit avatar image
  *
  * */
namespace App\Http\Controllers;

use App\Models\Album;
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

class UserController extends Controller {

    public function index(Request $request) {
        //
        try {
            $users = User::query();

            if ($request->has('singer')) {
                $users->where('role', 'singer');
            }
            
            if ($request->has('is_admin')) {
                if (!$request->get('is_admin')) {
                    $currentUser = $this->getAuthenticatedUser();
                    $singers = ManagerSinger::where('mod_id',  $currentUser->id)->get();
                    
                    if ($singers) {
                        $userId = $singers->pluck('singer_id');
                        $users->whereIn('id', $userId);
                    }
                }
            }

            //If role != admin, only list singer/role

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
     *          'name' => '',
     *          'email' => 'required|email|unique,
     *          'password' => 'required|min:6|max:30',
     *      }
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
     *              "updated_at": "2016-01-11 10:58:23",
     *              "created_at": "2016-01-11 10:58:23",
     *          }
     *      }
     */
    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            if (empty($data['role'])) {
                $data['role'] = 'fan';
            }

            $validator = Validator::make($data, User::rules('create'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }
            if (!User::roles($data['role'])) {
                return $this->responseError(['Invalid role'], 422);
            } else if ($data['role'] != 'fan') {

            }

            $user = new User($data);
            $user->password = \Hash::make($data['password']);
            $user->role = $data['role'];
            $user->save();

            return $this->responseSuccess($user);


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
            $user = User::findOrFail($id);
            
            if ($user->role == "mod") {
                $singers = ManagerSinger::where('mod_id',  $user->id)->get();
                if ($singers) {
                    $user->singer = $singers->pluck('singer_id');
                }
            }

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
            if (!array_get($data, 'password')) {
                unset($rules['password']);
            }
            if (!array_get($data, 'role')) {
                unset($rules['role']);
            } elseif (!User::roles($data['role'])) {
                return $this->responseError(['Invalid role'], 422);
            }
            
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $user->fill($data);
            if (array_get($rules, 'role')) {
                //TODO Only admin could change role
                $user->role = $data['role'];
            }
            
            if (array_get($rules, 'password')) $user->password = \Hash::make($data['password']);
            
            if (isset($user->singer)) {
                $affectedRows = ManagerSinger::where('mod_id',  $user->id)->delete();
                foreach ($user->singer as $singer) {
                    $manage = new ManagerSinger();
                    $manage->singer_id = $singer;
                    $manage->mod_id = $user->id;
                    $manage->save();
                }
                
                unset($user->singer);
            }

            $user->save();
            
            $user->singer = $data['singer'];

            return $this->responseSuccess($user);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    public function destroy($id) {
        //
        try {
            $user = User::findOrFail($id);

            // TODO Only Admin could delete user
            $user->delete();

            return $this->responseSuccess(['User is deleted']);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    /**
     * @api {post} /user/login Login
     * @apiName UserLogin
     * @apiGroup User
     *
     * @apiParamExample {json} PUT Request-Example:
     *     {
     *          "email" : "fan1@examole.com",
     *          "password": "123456"
     *      }
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
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        $validator = \Validator::make($credentials, array(
            'email' => 'required|email',
            'password' => 'required|min:6|max:30'
        ));

        if ($validator->fails()) {
            return $this->responseError($validator->errors()->all(), 422);
        }

        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return $this->responseError(['Invalid credentials'], 401);
            }

            $user = User::where('email', $request->get('email'))->firstOrFail();
            
            if ($request->has('singer_id')) {
                $singer_id = $request->get('singer_id');
                if ($user->id != $singer_id && $user->role == "singer") {
                    $user->role = "fan";
                }
            }

            return $this->responseSuccess([
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /user/login/facebook Use Facebook to Login
     * @apiName FacebookLogin
     * @apiGroup User
     *
     * @apiParamExample {json} POST Request-Example:
     *     {
     *          "token" : "5345rkf23f2332...",
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "token": "435345544...",
     *              "user": {
     *                   "id": 9
     *                   "email": "fan1@example.com",
     *                   "role": "fan",
     *                   ...
     *               }
     *          }
     *      }
     */
    public function loginFacebook(Request $request) {
        try {
            //Get info from token
            $client = new Client();
            $result = $client->get('https://graph.facebook.com/me', [
                'query' => [
                    'access_token' => $request->token,
                    'fields' => 'id,email,name'
                ]
            ]);
            $response = json_decode($result->getBody()->getContents());

            //Grab info
            $data = [
                'role' => 'fan',
                'name' => isset($response->name) ? $response->name : '',
                'email' => isset($response->email) ? $response->email : $response->id . '@fb.com',
                'password' => $response->id
            ];

            $userExisted = User::where([
                'email' => $data['email'],
                'role' => 'fan'
            ])->first();

            if ($userExisted) {
                // Return token and user data
                $user = $userExisted;
            } else {
                // Then create user

                $validator = Validator::make($data, User::rules('create'));
                if ($validator->fails()) {
                    return $this->responseError($validator->errors()->all(), 422);
                }

                $userNew = new User($data);
                $userNew->password = \Hash::make($data['password']);
                $userNew->role = $data['role'];

                if ($userNew->save()) {
                    $user = $userNew;
                } else {
                    return $this->responseError(['Unable to create new user from Facebook'], 500);
                }
            }

            $token = JWTAuth::fromUser($user);
            if (!$token) {
                return $this->responseError(['Invalid credentials'], 401);
            }

            // Return token + user
            return $this->responseSuccess([
                'token' => $token,
                'user' => $user
            ]);

        } catch (\Exception $e) {

            if ($e instanceof TransferException && $e->hasResponse()) {
                $body = $e->getResponse()->getBody();
                $response = json_decode($body->getContents());

                if (isset($response->error, $response->error->message)) {
                    return $this->responseError($response->error->message, $e->getCode());
                }
            }

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
     * @api {post} /user/refresh-token Refresh Token
     * @apiName UserRefreshToken
     * @apiGroup User
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "token": '1232322..."
     *          }
     *      }
     */
    public function refreshToken(Request $request) {
        //
        try {
            //$token = JWTAuth::getToken();
            $newToken = JWTAuth::parseToken()->refresh();

            return $this->responseSuccess(['token' => $newToken]);
        } catch (TokenExpiredException $e) {
            return $this->responseError('token_expired', $e->getStatusCode());
        } catch (JWTException $e) {
            return $this->responseError('token_invalid', $e->getStatusCode());
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

            $id = $user->id;

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
     * @api {get} /user/authenticated Get User from Token
     * @apiName UserAuthenticated
     * @apiGroup User
     *
     */
    public function authenticated() {
        $user = $this->getAuthenticatedUser();
        return $this->responseSuccess($user);
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
            $singer_id = $request->get('singer_id');

            $queryAlbums = Album::query();
            
            $queryAlbums->where(function ($queryAlbums) use ($keyword) {
                $queryAlbums->where('name', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%");
            });
            
            $queryAlbums->whereNull('deleted_at')
                ->where('is_public', true);
            
            if ($singer_id) {
                $queryAlbums->where('singer_id', $singer_id);
            }
                
            $albums = $queryAlbums->get();

            $querySongs = Song::query();
            
            $querySongs->where(function ($querySongs) use ($keyword) {
                $querySongs->where('name', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%");
            });
            
            $querySongs->whereNull('deleted_at')
                ->where('is_public', true);
            
            if ($singer_id) {
                $querySongs->where('singer_id', $singer_id);
            }
            
            $songs = $querySongs->get();

            $queryVideos = Video::query();
            
            $queryVideos->where(function ($queryVideos) use ($keyword) {
                $queryVideos->where('name', 'like', "%$keyword%")
                    ->orWhere('keywords', 'like', "%$keyword%");
            });
            
            $queryVideos->whereNull('deleted_at');
            
            if ($singer_id) {
                $queryVideos->where('singer_id', $singer_id);
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