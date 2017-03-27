<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VersionController extends Controller {

    public function index(Request $request) {
        try {
            $app = App::join('app_infos', 'apps.id', '=', 'app_infos.app_id')
                ->with('latestInfo')
                ->where('bundle_id', $request->bundle_id)
                ->where('app_infos.platform', $request->platform)
                ->first();

            $data = array(
                'content_id' => $app->content_id,
                'version' => $app->latestInfo->version
            );

            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}