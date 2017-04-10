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

    const AUTH_MANAGER = 1;
    const AUTH_MASTER = 2;
    const AUTH_USER = 3;

    const AUTH_TYPE_FACEBOOK = 1;
    const AUTH_TYPE_EMAIL = 2;
    const AUTH_TYPE_PHONE = 3;

    const AUTH_STATUS_ACTIVE = 1;

    protected $table = 'auths';

    protected $guarded = ['sec_pass', 'level'];

    protected $hidden = ['sec_pass', 'level'];

    protected $fillable = ['sec_name', 'type'];

    public static function rules($key = 'create', $id = '') {
        $common = [
            'sec_name' => 'required|max:255|unique:auths,sec_name' . ($id ? ",$id" : ''),
            'sec_pass' => 'required|min:6|max:30',
            'type' => 'required',
        ];

        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ]),
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
}
