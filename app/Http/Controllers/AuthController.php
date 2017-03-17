<?php

namespace App\Http\Controllers;

use App\Models\Auth;
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
            'sec_name' => 'required|email',
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

            $auth = Auth::where('sec_name', $request->get('sec_name'))->firstOrFail();

            return $this->responseSuccess([
                'token' => $token,
                'auth' => $auth
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

            $authExisted = Auth::where([
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

                $authNew = new Auth($data);
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
            $newToken = JWTAuth::parseToken()->refresh();

            return $this->responseSuccess(['token' => $newToken]);
        } catch (TokenExpiredException $e) {
            return $this->responseError('token_expired', $e->getStatusCode());
        } catch (JWTException $e) {
            return $this->responseError('token_invalid', $e->getStatusCode());
        }
    }
}