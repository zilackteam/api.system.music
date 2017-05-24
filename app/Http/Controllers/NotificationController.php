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

            $notification = new Notification();
            $notification->fill($data);
            $notification->save();

            $app = App::where('content_id', $data['content_id'])->first();

            $ios_key = $app->ios_server_key;
            $ios_tokens = Device::where('platform', 'ios')->get()->pluck('device_token');

            if ($ios_key && $ios_tokens) {
                $result = send_notification($ios_key, $ios_tokens, array('title' => $data['title'], 'text' => $data['content']));
            }

            $android_key = $app->android_server_key;
            $android_tokens = Device::where('platform', 'android')->get()->pluck('device_token');

            if ($android_key && $android_tokens) {
                $result = send_notification($android_key, $android_tokens, array('title' => $data['title'], 'text' => $data['content']));
            }

            if (!isset($result)) {
                return $this->responseError('Please add server key', 422);
            }

            return $this->responseSuccess($notification);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}