<?php

namespace App\Models;

/**
 * App\Models\Photo
 *
 * @property integer $id
 * @property integer $singer_id
 * @property string $file_path
 * @property string $caption
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Photo extends VeoModel {

    protected $table = 'photos';

    protected $guarded = [];

    protected $hidden = [];
    
    public $thumb_data;

    public static function rules($key = 'create') {
        $common = [
            'singer_id' => 'required',
            'file_path' => 'required'
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
