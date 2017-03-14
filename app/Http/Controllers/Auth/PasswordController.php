<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class PasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function __construct() {
        $this->middleware('guest');
    }


    /**
     * @api {post} /password/reset/ Reset password
     * @apiName ResetPassword
     * @apiGroup ForgotPassword
     *
     * @apiParam {String} token Reset password token
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          "token": "ewrrew23qqwe...",
     *          "password": "strong-password",
     *          "password_confirmation": "strong-password-too",
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *          }
     *      }
     */
    public function reset(Request $request) {
        try {

            $credentials = $request->all();

            $validator = \Validator::make($credentials, User::rules('resetPassword'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            //Get user
            $forgotRequest = \DB::table('password_resets')->where('token', $credentials['token'])->first();
            $user = User::where('email', $forgotRequest->email)->firstOrFail();

            //Update password
            $user->password = \Hash::make($credentials['password']);
            $user->save();
            \DB::table('password_resets')->where('token', $credentials['token'])->delete();

            //Return response
            return $this->responseSuccess(['Password changed successfully!']);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /password/email Request reset password
     * @apiName RequestResetPassword
     * @apiGroup ForgotPassword
     *
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          "email": "johndoe@example.com",
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *          }
     *      }
     */
    public function email(Request $request) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, User::rules('forgotPassword'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $user = User::where('email', $data['email'])->firstOrFail();

            $response = \Password::sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });

            switch ($response) {
                case \Password::RESET_LINK_SENT:
                    return $this->responseSuccess(trans($response));

                default;
                    return $this->responseError(trans($response), 400);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /password/verify-token/:token Verify token for resetting password
     * @apiName VerifyTokenResetPassword
     * @apiGroup ForgotPassword
     *
     * @apiParam {String} token Reset password token
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *          }
     *      }
     */
    public function verify($token) {
        try {
            $request = \DB::table('password_resets')->where('token', $token)->first();

            if (! ($request->created_at > Carbon::now()->subHours(1)) ) {
                return $this->responseError('Token is expired', 400);
            }

            return $this->responseSuccess('Token is valid and not expired');

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}
