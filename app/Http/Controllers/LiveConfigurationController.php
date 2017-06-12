<?php

namespace App\Http\Controllers;

use App\Models\LiveConfiguration;
use Illuminate\Http\Request;
use App\Http\Requests;

class LiveConfigurationController extends Controller {

    public function show(Request $request) {
        try {
            $data = $request->all();

            if ($request->has('app_id')) {
                $config = LiveConfiguration::where('app_id', $data['app_id'])->first();

                return $this->responseSuccess($config);
            } else {
                return $this->responseError(['App ID required'], 404);
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

            $config = new LiveConfiguration();
            $config->fill($data);
            $config->save();

            return $this->responseSuccess($config);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}