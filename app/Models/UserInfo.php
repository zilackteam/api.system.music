<?php

namespace App\Models;
use Carbon\Carbon;

/**
 * App\Models\UserInfo
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class UserInfo extends VeoModel {

    protected $table = 'user_info';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
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
