<?php

namespace App\Models;

/**
 * App\Models\Beat
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $performer
 * @property string $author
 * @property string $name
 * @property string $description
 * @property string $thumb_url
 * @property string $file128
 * @property string $file320
 * @property string $file_lossless
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */

class Beat extends VeoModel {

    protected $table = 'beats';

    protected $guarded = ['file128', 'file320', 'file_lossless', 'thumb_url'];

    protected $hidden = ['deleted_at'];

    protected $fillable = ['performer', 'content_id', 'author', 'name', 'description', 'thumb_url', 'is_public', 'keywords', 'is_feature'];

    public static function rules($key = 'create') {
        $common = [
            'name' => 'required',
            'performer' => 'required',
            'thumb_url' => 'mimes:jpeg,jpg,png',
            'file128' => 'audio',
            'file320' => 'audio',
            'file_lossess' => 'audio'
        ];
        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ])
        ];
        return array_get($rules, $key);
    }

    public function getThumbUrlAttribute($value) {
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/beat/' . $this->attributes['id'] . '/thumb_' . $value) : '';
    }

    public function getFile128Attribute($value) {
        $value = $this->attributes['file128'];
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/beat/' . $this->attributes['id'] . '/' . $value) : '';
    }

    public function getFile320Attribute($value) {
        $value = $this->attributes['file320'];
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/beat/' . $this->attributes['id'] . '/' . $value) : '';
    }

    public function getFileLosslessAttribute($value) {
        $value = $this->attributes['file_lossless'];
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/beat/' . $this->attributes['id'] . '/' . $value) : '';
    }
}
