<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppInfo;
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
                ->orderBy('app_infos.created_at', 'desc')
                ->first();

            if ($app) {
                $data = array(
                    'content_id' => $app->content_id,
                    'version' => $app->version,
                    'app_id' => $app->id
                );

                return $this->responseSuccess($data);
            } else {
                return $this->responseError('Cannot find app info', 200);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function listing(Request $request) {
        try {
            $appInfo = AppInfo::select(array('app_infos.*', 'apps.content_id'))
                ->join('apps', 'apps.id', '=', 'app_infos.app_id')
                ->where('apps.content_id', $request->content_id)
                ->get();

            if ($appInfo) {
                return $this->responseSuccess($appInfo);
            } else {
                return $this->responseError('Cannot find app info', 200);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function show(Request $request) {

    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            if($request->content_id) {
                $app = App::where('content_id', $request->content_id)->first();

                $validator = \Validator::make($data, AppInfo::rules('create'));

                if ($validator->fails())
                    return $this->responseError($validator->errors()->all(), 422);

                $appInfo = new AppInfo();
                $appInfo->fill($data);
                $appInfo->app_id = $app->id;
                $appInfo->save();

                return $this->responseSuccess($appInfo);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $appInfo = AppInfo::findOrFail($id);

            $data = $request->all();
            $validator = \Validator::make($data, AppInfo::rules('update'));

            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $appInfo->fill($data);
            $appInfo->save();

            return $this->responseSuccess($appInfo);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $appInfo = AppInfo::findOrFail($id);
            $appInfo->delete();
            return $this->responseSuccess('record_deleted');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}