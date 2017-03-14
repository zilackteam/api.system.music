<?php

namespace App\Models;

/**
 * App\Models\Version
 *
 * @property integer $id
 * @property integer $singer_id
 * @property integer $type
 * @property string $version
 * @property integer $option
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 */
class Version extends VeoModel {

    protected $table = 'versions';

    protected $guarded = [];

    protected $hidden = [];
    
    const TYPE_IOS = 1;
    const TYPE_ANDROID = 2;
    
    const OPTION_OPTIONAL = 0;
    const OPTION_REQUIRE = 1;
    
    public static function rules($key = 'create') {
        $common = [
            'version' => 'required',
            'type' => 'required'
        ];
        $rules = [
            'create' => array_merge($common, [
                'singer_id' => 'required',
            ]),
            'update' => array_merge($common, [
            ])
        ];
        
        return array_get($rules, $key);
    }
}
