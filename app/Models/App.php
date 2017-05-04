<?php

namespace App\Models;

class App extends VeoModel {
    protected $table = 'apps';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create', $id = '') {
        $common = [
            'name' => 'required',
            'content_id' => 'required',
            'bundle_id' => 'required',
        ];

        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ]),
        ];

        return array_get($rules, $key);
    }

    public function latestInfo()
    {
        return $this->hasOne('App\Models\AppInfo')->latest();
    }
}