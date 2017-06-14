<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Live;
use App\Models\LiveConfiguration;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Requests;

class LiveController extends Controller {

    public function store(Request $request) {
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Live::rules('create'));

            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $live = new Live();
            $live->fill($data);
            $live->status = 0;
            $live->name = uniqid();

            $live->save();

            $config = LiveConfiguration::where('app_id', $data['app_id'])->first();

            $result = [
                'id' => $live->id,
                'protocol' => $config->protocol_str,
                'address' => $config->address,
                'port' => $config->port,
                'application' => $config->application,
                'name' => $live->name,
                'status' => $live->status,
            ];

            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->all();

            $live = Live::findOrFail($data['id']);
            $live->fill($data);
            $live->status = 1;

            $live->save();

            $config = LiveConfiguration::where('app_id', $live->app_id)->first();
            $app = App::where('id', $live->app_id)->first();

            $dataPush = array(
                'content_id' => $app->content_id,
                'title' => '',
                'content' => 'Live stream ' . $app->name,
            );

            $notification = Notification::sendPushNotification($dataPush);

            $result = [
                'protocol' => $config->protocol_str,
                'address' => $config->address,
                'port' => $config->port,
                'application' => $config->application,
                'name' => $live->name,
                'status' => $live->status
            ];

            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function getCurrentLive(Request $request) {
        try {
            $data = $request->all();

            $config = LiveConfiguration::where('app_id', $data['app_id'])->first();
            $live = Live::where('app_id', $data['app_id'])
                ->orderBy('updated_at', 'DESC')
                ->first();

            if ($live->status == 1) {
                $result = [
                    'id' => $live->id,
                    'protocol' => $config->protocol_str,
                    'address' => $config->address,
                    'port' => $config->port,
                    'application' => $config->application,
                    'name' => $live->name,
                    'title' => $live->title,
                    'status' => $live->status,
                ];
            } else {
                $result = [

                ];
            }

            return $this->responseSuccess($result);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function finish(Request $request) {
        try {
            $data = $request->all();

            $live = Live::findOrFail($data['id']);
            $live->fill($data);
            $live->status = 2;

            $live->save();

            return $this->responseSuccess($live);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}