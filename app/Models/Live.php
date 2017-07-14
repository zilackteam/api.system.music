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
class Live extends VeoModel {

    protected $table = 'live';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'app_id' => 'required',
        ];

        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ])
        ];

        return array_get($rules, $key);
    }
}