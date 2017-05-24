<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

use App\Http\Requests;

class DeviceController extends Controller {

    public function store(Request $request) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Device::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $device = new Device();
            $device->fill($data);
            $device->save();

            return $this->responseSuccess($device);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}