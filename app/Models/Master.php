<?php

namespace App\Models;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $dob
 * @property string $avatar
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */

class Master extends VeoModel {
    protected $table = 'masters';

    protected $guarded = [];

    protected $hidden = [];

    protected $fillable = ['name', 'phone', 'avatar', 'dob', 'short_info', 'detail_info', 'content_id'];

    public static function rules($key = 'create', $id = '') {
        $common = [
            'dob' => 'date'
        ];

        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ]),
            'avatar' => [
                'avatar' => 'required|mimes:jpeg,jpg,png'
            ]
        ];
        return array_get($rules, $key);
    }

    public function setDobAttribute($value) {
        if ($value) {
            $this->attributes['dob'] = date('Y-m-d', strtotime($value));
        }
    }

    public function getAvatarAttribute($value) {
        return ($this->attributes['avatar']) ?
            url('resources' . DS . 'uploads' . DS . 'users' . DS . $this->attributes['auth_id'] . DS . 'avatar' . DS . 'thumb_' . $this->attributes['avatar']) :
            url('resources' . DS . 'assets' . DS . 'images' . DS . 'no_avatar.jpg');
    }

    public function authentication() {
        return $this->belongsTo('App\Models\Authentication', 'auth_id');
    }
}
