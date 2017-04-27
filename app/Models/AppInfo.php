<?php

namespace App\Models;

class AppInfo extends VeoModel {
    protected $table = 'app_infos';

    protected $guarded = [];

    protected $hidden = [];

    protected $fillable = ['app_id', 'version', 'platform', 'store_url'];

    public static function rules($key = 'create', $id = '') {
        $common = [
            'version' => 'required',
            'platform' => 'required',
        ];

        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ]),
        ];

        return array_get($rules, $key);
    }
}