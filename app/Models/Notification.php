<?php

namespace App\Models;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 */
class Notification extends VeoModel {

    protected $table = 'notifications';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'content_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ];
        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ])
        ];

        return array_get($rules, $key);
    }

    public static function sendPushNotification($data) {
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
            return false;
        } else {
            return $notification;
        }
    }
}
