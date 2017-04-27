<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\App;
use App\Models\Authentication;
use Auth;
use Illuminate\Http\Request;

class AppController extends Controller {

    public function index(Request $request) {
        //
        try {
            $auth = Authentication::findOrFail($request->auth_id);

            if ($auth->level == Authentication::AUTH_ADMIN) {
                $apps = App::query();

                $apps = $apps->get();
            } else {
                $apps = App::join('app_managers', 'app_managers.app_id', '=', 'apps.id')
                    ->where('app_managers.manager_id', $auth->id)
                    ->get();
            }

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