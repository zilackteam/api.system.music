<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Auth;
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

class AuthController extends Controller {
    /**
     * @api {post} /auth/login Login
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
     *              ...
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
}