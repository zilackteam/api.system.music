<?php

namespace App\Models;

/**
 * App\Models\AuthType
 *
 * @property integer $id
 * @property integer $auth_id
 * @property string $sec_pass
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class AuthType extends VeoModel {
    protected $table = 'auth_types';

    protected $guarded = [];

    protected $hidden = [];

}
