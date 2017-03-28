<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\Models\AuthToken
 *
 * @property integer $id
 * @property integer $auth_id
 * @property string $sec_pass
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class AuthToken extends VeoModel {

    protected $table = 'auth_tokens';

    protected $guarded = [];

    protected $hidden = [];

    protected $fillable = ['auth_id', 'token'];
}
