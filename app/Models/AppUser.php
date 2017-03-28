<?php

namespace App\Models;

/**
 * App\Models\AppUser
 *
 * @property integer $id
 * @property integer $app_id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */

class AppUser extends VeoModel {
    protected $table = 'app_users';

    protected $guarded = [];

    protected $hidden = [];

}
