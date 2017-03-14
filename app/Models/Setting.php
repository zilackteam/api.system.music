<?php

namespace App\Models;

/**
 * App\Models\Setting
 *
 * @property integer        $id
 * @property string         $filter
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $deleted_at
 */
class Setting extends VeoModel {

    protected $table = 'settings';

    protected $guarded = [];

    protected $hidden = [];

    public function validRules($key = 'create') {
        $common = [
            'filter' => 'required',
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
