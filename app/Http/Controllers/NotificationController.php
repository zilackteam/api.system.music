<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Device;
use App\Models\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationController extends Controller {

    public function index(Request $request) {
        try {
            if ($request->has('content_id')) {
                $notification = Notification::where('content_id', $request->content_id)->get();

                return $this->responseSuccess($notification);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Notification::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $notification = Notification::sendPushNotification($data);

            if ($notification) {
                return $this->responseSuccess($notification);
            } else {
                return $this->responseError('Please add server key', 422);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}