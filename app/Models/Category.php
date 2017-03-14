<?php

namespace App\Models;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 */
class Category extends VeoModel {

    protected $table = 'categories';

    protected $guarded = [];

    protected $hidden = [];
    
    const TYPE_PHOTO = 1;
    const TYPE_VIDEO = 2;
    
    public static function rules($key = 'create') {
        $common = [
            'name' => 'required',
            'type' => 'required'
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
