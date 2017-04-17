<?php

namespace App\Models;

/**
 * App\Models\Song
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $performer
 * @property string $author
 * @property string $name
 * @property string $description
 * @property string $lyrics
 * @property string $thumb_img
 * @property string $file128
 * @property string $file320
 * @property string $file_lossless
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */

class Song extends VeoModel {

    protected $table = 'songs';

    protected $guarded = ['file128', 'file320', 'file_lossless', 'thumb_url'];

    protected $hidden = ['deleted_at'];

    protected $fillable = ['performer', 'content_id', 'author', 'name', 'lyrics', 'description', 'thumb_url'];

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

            ]),
            'update' => array_merge($common, [

            ])
        ];
        return array_get($rules, $key);
    }

    public function getThumbUrlAttribute($value) {
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/song/' . $this->attributes['id'] . '/thumb_' . $value) : '';
    }

    public function getFile128Attribute($value) {
        $value = $this->attributes['file128'];
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/song/' . $this->attributes['id'] . '/' . $value) : '';
    }

    public function getFile320Attribute($value) {
        $value = $this->attributes['file320'];
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/song/' . $this->attributes['id'] . '/' . $value) : '';
    }

    public function getFileLosslessAttribute($value) {
        $value = $this->attributes['file_lossless'];
        return $value ? url('resources/uploads/' . $this->attributes['content_id'] . '/song/' . $this->attributes['id'] . '/' . $value) : '';
    }

    /**
     * Relationship
     */

    public function albums() {
        return $this->belongsToMany('App\Models\Album', 'album_songs', 'song_id', 'album_id');
    }

}
