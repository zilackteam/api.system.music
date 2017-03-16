<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
class Auth extends VeoModel implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;

    protected $table = 'auths';

    protected $guarded = ['sec_pass'];

    protected $hidden = ['sec_pass'];


    public static function rules() {

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
