<?php

namespace App\Models;

/**
 * App\Models\Album
 *
 * @property integer $id
 * @property integer $singer_id
 * @property string $name
 * @property string $description
 * @property string $thumb_img
 * @property integer $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * TODO Set unique rule for name
 */
class Album extends VeoModel {

    protected $table = 'albums';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $rules = [
            'create' => [
                'singer_id' => 'required',
                'name' => 'required',
                'thumb_img' => 'mimes:jpeg,jpg,png'
            ],
            'update' => [
                'name' => 'required',
                'thumb_img' => 'mimes:jpeg,jpg,png'
            ],
            'image' => [
                'id' => 'required',
                'thumb_img' => 'required|mimes:jpeg,jpg,png'
            ]
        ];
        return array_get($rules, $key);
    }

    public function getThumbImgAttribute($value) {
        return $value ?
            url('resources' . DS . 'uploads' . DS . $this->attributes['singer_id'] . DS . 'album' . DS . 'thumb_' . $value) :
            url('resources' . DS . 'assets' . DS . 'images' . DS . 'icon-music.jpg');
    }
    
    public function getFeatureImgAttribute($value) {
        return $value ?
            url('resources' . DS . 'uploads' . DS . $this->attributes['singer_id'] . DS . 'album' . DS . $value) :
            url('resources' . DS . 'assets' . DS . 'images' . DS . 'icon-music.jpg');
    }

    public function songs() {
        return $this->hasMany('App\Models\Song')->where('is_public', true);
    }

}
