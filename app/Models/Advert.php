<?php

namespace App\Models;

/**
 * App\Models\Advert
 *
 * @property integer $id
 * @property string $customer
 * @property string $url
 * @property integer $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 * @property \Carbon\Carbon $deleted_at
 */
class Advert extends VeoModel {

    protected $table = 'adverts';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'customer' => 'required',
            'url' => 'required|url'
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
