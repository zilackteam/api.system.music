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

            $apps = $apps->get();

            return $this->responseSuccess($apps);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function show(Request $request, $id) {
        //
        try {
            $app = App::where('content_id', $id)->first();

            return $this->responseSuccess($app);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}