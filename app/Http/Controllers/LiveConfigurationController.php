<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\LiveConfiguration;
use Illuminate\Http\Request;
use App\Http\Requests;

class LiveConfigurationController extends Controller {

    public function show($content_id) {
        try {
            if ($content_id) {
                $app = App::where('content_id', $content_id)->first();
                $config = LiveConfiguration::where('app_id', $app->id)->first();

                return $this->responseSuccess($config);
            } else {
                return $this->responseError(['Content ID required'], 404);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->all();

            $validator = \Validator::make($data, LiveConfiguration::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $app = App::where('content_id', $data['content_id'])->first();

            $config = new LiveConfiguration();
            $config->fill($data);
            $config->app_id = $app->id;
            $config->save();

            return $this->responseSuccess($config);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update($id, Request $request) {
        try {
            $data = $request->all();

            $validator = \Validator::make($data, LiveConfiguration::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $config = LiveConfiguration::findOrFail($id);

            $config->fill($data);
            $config->save();

            return $this->responseSuccess($config);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}