<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tymon\JWTAuth\Facades\JWTAuth;
use Crypt;

abstract class Controller extends BaseController {
    use DispatchesJobs, ValidatesRequests;

    /**
     * Response internal server error
     *
     * @param $message String that will be appended to the Error Message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseInternalError($message = '') {
        // TODO Implement Logging here
        if (!empty($message))
            $message = ': ' . $message;

        return response()->json(array(
            'error' => 'Internal server error' . $message
        ), 500);
    }

    /**
     * Response error
     * @param $message
     * @param int $code error code
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message, $code = 200, $data = array()) {
        // TODO Implement Logging here
        if (is_array($message)) {
            $message = implode(',', $message);
        }
        $_json = response()->json($data)->getData();
        return response()->json(array(
            'error' => $message,
            'data' => cryptoJsAesEncrypt('llRYAcSucCE6ZWRNd0gNoKdGsMw8W6Gv', $_json)
        ), $code);
    }

    /**
     * Return success
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data) {
        $_json = response()->json($data)->getData();

        return response()->json(array(
            'error' => '',
            'data' => cryptoJsAesEncrypt('llRYAcSucCE6ZWRNd0gNoKdGsMw8W6Gv', $_json)
        ));
    }

    /**
     * Returns a Error message depending on the Exception provided
     *
     * @param \Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseErrorByException(\Exception $e) {
        if ($e instanceof ModelNotFoundException) {
            return $this->responseError($e->getModel() . " not found", 404, array());
        } elseif ($e instanceof \InvalidArgumentException) {
            return $this->responseError($e->getMessage());
        } elseif ($e->getCode() === 0) {
            return $this->responseError([$e->getMessage()], 400);
        } else {
            return $this->responseError($e->getMessage(), 500);
        }
    }

    public function getAuthenticatedUser() {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return $user;
    }

}
