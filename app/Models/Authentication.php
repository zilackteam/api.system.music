<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\Models\Authentication
 *
 * @property integer $id
 * @property string $sec_name
 * @property string $sec_pass
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Authentication extends VeoModel implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;

    const AUTH_ADMIN = 0;
    const AUTH_MANAGER = 1;
    const AUTH_MASTER = 2;
    const AUTH_USER = 3;

    const AUTH_TYPE_FACEBOOK = 1;
    const AUTH_TYPE_EMAIL = 2;
    const AUTH_TYPE_PHONE = 3;

    const AUTH_STATUS_ACTIVE = 1;

    protected $table = 'auths';

    protected $guarded = ['sec_pass'];

    protected $hidden = ['sec_pass'];

    protected $fillable = ['sec_name', 'type', 'name', 'phone', 'dob', 'avatar', 'short_info', 'detail_info', 'content_id'];

    public static function rules($key = 'create', $id = '') {
        $common = [
            'sec_name' => 'required|max:255|unique:auths,sec_name' . ($id ? ",$id" : ''),
            'dob' => 'date'
        ];

        $rules = [
            'create' => array_merge($common, [
                'sec_pass' => 'required|min:6|max:30',
                'type' => 'required'
            ]),
            'update' => array_merge($common, [

            ]),
            'changePassword' => [
                'current_password' => 'required',
                'new_password' => 'required|min:6|max:30|confirmed',
                'new_password_confirmation' => 'required|min:6|max:30',
            ],
            'avatar' => [
                'avatar' => 'required|mimes:jpeg,jpg,png'
            ]
        ];

        return array_get($rules, $key);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->sec_pass;
    }

    public function setDobAttribute($value) {
        if ($value) {
            $this->attributes['dob'] = date('Y-m-d', strtotime($value));
        }
    }

    public function getAvatarAttribute($value) {
        return ($this->attributes['avatar']) ?
            url('resources' . DS . 'uploads' . DS . 'users' . DS . $this->attributes['id'] . DS . 'avatar' . DS . 'thumb_' . $this->attributes['avatar']) :
            url('resources' . DS . 'assets' . DS . 'images' . DS . 'no_avatar.jpg');
    }

    public function application() {
        return $this->belongsTo('App\Models\App', 'content_id', 'content_id');
    }
}
