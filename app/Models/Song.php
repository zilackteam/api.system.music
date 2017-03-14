<?php

namespace App\Models;

/**
 * App\Models\Song
 *
 * @property integer $id
 * @property integer $singer_id
 * @property integer $album_id
 * @property string $performer
 * @property string $author
 * @property string $name
 * @property string $description
 * @property string $lyrics
 * @property string $thumb_img
 * @property string $file128
 * @property string $file320
 * @property string $file_lossless
 * @property integer $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Song extends VeoModel {

    protected $table = 'songs';

    protected $guarded = ['file128', 'file320', 'file_lossless', 'thumb_img'];

    protected $hidden = ['deleted_at'];

    public static function rules($key = 'create') {
        $common = [
            'name' => 'required',
            'performer' => 'required',
            'thumb_img' => 'mimes:jpeg,jpg,png',
            'file128' => 'audio',
            'file320' => 'audio',
            'file_lossess' => 'audio'
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

    public function getThumbImgAttribute($value) {
        return $value ? url('resources/uploads/' . $this->attributes['singer_id'] . '/song/' . $this->attributes['id'] . '/thumb_' . $value) : '';
    }

    public function getFile128Attribute($value) {
        $value = $this->attributes['file128'];
        return $value ? url('resources/uploads/' . $this->attributes['singer_id'] . '/song/' . $this->attributes['id'] . '/' . $value) : '';
    }
    public function getFile320Attribute($value) {
        $value = $this->attributes['file320'];
        return $value ? url('resources/uploads/' . $this->attributes['singer_id'] . '/song/' . $this->attributes['id'] . '/' . $value) : '';
    }
    public function getFileLosslessAttribute($value) {
        $value = $this->attributes['file_lossless'];
        return $value ? url('resources/uploads/' . $this->attributes['singer_id'] . '/song/' . $this->attributes['id'] . '/' . $value) : '';
    }

    /**
     * Relationship
     */
    public function album() {
        return $this->belongsTo('App\Models\Post');
    }
    public function videos() {
        return $this->hasMany('App\Models\Video');
    }
    
}
