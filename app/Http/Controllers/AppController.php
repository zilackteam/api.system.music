<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\App;
use App\Models\Authentication;
use Request;
use Auth;

class AppController extends Controller {
    public function index(Request $request) {
        //
        try {
            $apps = App::query();
//
//            if (Auth::user()->level == Authentication::AUTH_ADMIN) {
//
//            } else {
//
//            }

            $apps = $apps->get();

            return $this->responseSuccess($apps);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }
}