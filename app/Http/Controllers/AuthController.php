<?php

namespace App\Http\Controllers;

use App\Models\Authentication;
use App\Models\Master;
use App\Models\User;
use App\Models\AuthType;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Request;
use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller {

    /**
     * @api {post} /auth/login Login
     * @apiName UserLogin
     * @apiGroup User
     *
     * @apiParamExample {json} PUT Request-Example:
     *     {
     *          "sec_name" : "fan1@examole.com",
     *          "sec_pass": "123456"
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "token" : "",
     *              "auth": {
     *                  "id": 9
     *                  "sec_name": "fan1@example.com",
     *                  ...
     *              }
     *
     *          }
     *      }
     */

    public function login(Request $request) {
        $credentials = $request->only('sec_name', 'sec_pass');

        $validator = \Validator::make($credentials, array(
            'sec_name' => 'required',
            'sec_pass' => 'required|min:6|max:30'
        ));

        if ($validator->fails()) {
            return $this->responseError($validator->errors()->all(), 422);
        }

        try {
            $token = JWTAuth::attempt(array('sec_name' => $request->sec_name, 'password' => $request->sec_pass));
            if (!$token) {
                return $this->responseError(['Invalid credentials'], 401);
            }

            $auth = Authentication::where('sec_name', $request->get('sec_name'))->firstOrFail();

            if ($auth->level == Authentication::AUTH_MASTER) {
                $info = $auth->master;
            } else {
                $info = $auth->user;
            }

            return $this->responseSuccess([
                'token' => $token,
                'auth' => $auth,
                'info' => $info
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
     *              "auth": {
     *                   "id": 9
     *                   "email": "fan1@example.com",
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
                'name' => isset($response->name) ? $response->name : '',
                'sec_name' => isset($response->email) ? $response->email : $response->id . '@fb.com',
                'sec_pass' => $response->id
            ];

            $authExisted = Authentication::where([
                'sec_name' => $data['sec_name'],
            ])->first();

            if ($authExisted) {
                // Return token and user data
                $auth = $authExisted;
            } else {
                // Then create user

                $validator = Validator::make($data, array());
                if ($validator->fails()) {
                    return $this->responseError($validator->errors()->all(), 422);
                }

                $authNew = new Authentication($data);
                $authNew->sec_pass = \Hash::make($data['sec_pass']);

                if ($authNew->save()) {
                    $auth = $authNew;
                } else {
                    return $this->responseError(['Unable to create new user from Facebook'], 500);
                }
            }

            $token = JWTAuth::fromUser($auth);
            if (!$token) {
                return $this->responseError(['Invalid credentials'], 401);
            }

            // Return token + user
            return $this->responseSuccess([
                'token' => $token,
                'auth' => $auth
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
     * @api {get} /auth/authenticated Get Auth from Token
     * @apiName UserAuthenticated
     * @apiGroup User
     *
     */
    public function authenticated() {
        $auth = $this->getAuthenticatedUser();

        return $this->responseSuccess($auth);
    }

    /**
     * @api {post} /auth/refresh-token Refresh Token
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
            $newToken = JWTAuth::parseToken()->refresh();

            return $this->responseSuccess(['token' => $newToken]);
        } catch (TokenExpiredException $e) {
            return $this->responseError('token_expired', $e->getStatusCode());
        } catch (JWTException $e) {
            return $this->responseError('token_invalid', $e->getStatusCode());
        }
    }


    public function manager(Request $request) {
        $credentials = $request->only('sec_name', 'sec_pass');

        $validator = \Validator::make($credentials, array(
            'sec_name' => 'required',
            'sec_pass' => 'required|min:6|max:30'
        ));

        if ($validator->fails()) {
            return $this->responseError($validator->errors()->all(), 422);
        }

        try {
            $token = JWTAuth::attempt(array('sec_name' => $request->sec_name, 'password' => $request->sec_pass));

            if (!$token) {
                return $this->responseError(['Invalid credentials'], 401);
            }

            $auth = Authentication::where('sec_name', $request->get('sec_name'))->where('level', '<=', Authentication::AUTH_MANAGER)->firstOrFail();

            return $this->responseSuccess([
                'token' => $token,
                'auth' => $auth
            ]);
        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return $this->responseErrorByException($e);
        }
    }

    public function type(Request $request) {

        try {
            $authType = AuthType::withTrashed()->get();
            if (!$authType) {
                return $this->responseError(['Invalid credentials'], 401);
            }

            return $this->responseSuccess($authType);
        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return $this->responseErrorByException($e);
        }

    }


    /**
     * @api {post} /auth/change-password Change Password
     * @apiName AuthChangePassword
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
            $currentAuth = $this->getAuthenticatedUser();

            $data = $request->all();
            $validator = \Validator::make($data, Authentication::rules('changePassword'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            if (!\Hash::check($data['current_password'], $currentAuth->sec_pass))
                return $this->responseError('Current password is incorrect', 422);

            $currentAuth->sec_pass = \Hash::make($data['new_password']);
            $currentAuth->save();

            return $this->responseSuccess(['password_changed']);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function changeInfo(Request $request) {
        //
        try {
            $currentAuth = $this->getAuthenticatedUser();

            $data = $request->all();
            $validator = \Validator::make($data, Authentication::rules('update', $currentAuth->id));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $auth = Authentication::findOrFail($currentAuth->id);
            $auth->update($data);

            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function avatar(Request $request) {
        try {
            $data = $request->all();

            $auth = Authentication::findOrFail($request->get('id'));

            $id = $auth->id;

            if ($auth->level == Authentication::AUTH_USER) {
                $user = User::where('auth_id', $id)->first();
            } elseif ($auth->level == Authentication::AUTH_MASTER) {
                $user = Master::where('auth_id', $id)->first();
            } else {
                throw new Exception('Cannot find data.');
            }

            $validator = Validator::make($data, User::rules('avatar'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            if ($request->file('avatar')) {
                $nameThumb = 'avatar_' . date('YmdHis');
                $uploadThumb = uploadImage($request, 'avatar', avatar_path($id), $nameThumb);

                if ($uploadThumb) {
                    if ($user->avatar) {
                        if (is_file(avatar_path($id) . DS . $user->avatar)) {
                            unlink(avatar_path($id) . DS . $user->avatar);
                        }

                        if (is_file(avatar_path($id) . DS . 'thumb_' . $user->avatar)) {
                            unlink(avatar_path($id) . DS . 'thumb_' . $user->avatar);
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
}