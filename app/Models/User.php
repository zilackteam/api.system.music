<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use PhpSpec\Exception\Exception;

/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $role
 * @property integer $role_level
 * @property string $name
 * @property string $dob
 * @property string $bio
 * @property string $avatar
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class User extends VeoModel implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $guarded = ['password', 'role', 'avatar'];

    protected $hidden = ['password'];

    public static function roles($key = '') {
        $roles = [
            'admin'   => ['name' => 'Admin', 'level' => 100],
            'mod'     => ['name' => 'Moderator', 'level' => 80],
            'singer'  => ['name' => 'Singer', 'level' => 20],
            'fan'    => ['name' => 'Fan', 'level' => 0]
        ];
        return array_get($roles, $key);
    }

    public static function rules($key = 'create', $id = '') {
        $common = [
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'password' => 'required|min:6|max:30',
            'role' => 'required',
            'dob' => 'date'
        ];
        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [
            ]),
            'changePassword' => [
                'current_password' => 'required|min:6|max:30',
                'new_password' => 'required|min:6|max:30|confirmed',
            ],
            'forgotPassword' => [
                'email' => 'required|email'
            ],
            'resetPassword' => [
                'token' => 'required|tokenForgotPassword',
                'password' => 'required|min:6|max:30|confirmed',
            ],
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

    /*public function getDobAttribute($value) {
        return $this->attributes['dob'] = date('d-m-Y', strtotime($value));
    }*/

    public function getAvatarAttribute($value) {
        return ($this->attributes['avatar']) ?
            url('resources' . DS . 'uploads' . DS . $this->attributes['id'] . DS . 'avatar' . DS . 'thumb_' . $this->attributes['avatar']) :
            url('resources' . DS . 'assets' . DS . 'images' . DS . 'no_avatar.jpg');
    }

    // Extra functions
    public function checkSinger($id) {
        $singer = self::where([
            'id' => $id,
            'role' => 'singer'
        ])->first();

        if ($singer) {
            return $singer;
        } else {
            throw new \Exception('Is not singer');
        }
    }

}
