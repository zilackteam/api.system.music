<?php

namespace App\Models;

/**
 * App\Models\Upload
 */
class Upload extends VeoModel {

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = '') {
        $common = [
            'content_id' => 'required'
        ];
        $rules = [
            'image' => array_merge($common, [
                'file' => 'required|mimes:jpeg,jpg,png',
            ]),
        ];
        return array_get($rules, $key);
    }

}
