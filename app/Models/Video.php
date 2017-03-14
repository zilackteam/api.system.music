<?php

namespace App\Models;

/**
 * App\Models\Video
 *
 * @property integer $id
 * @property integer $singer_id
 * @property integer $song_id
 * @property integer $album_id
 * @property string $name
 * @property string $performer
 * @property string $video_url
 * @property string $thumb_img
 * @property string $publish_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Video extends VeoModel {

    protected $table = 'videos';

    protected $guarded = [];

    protected $fillable = ['singer_id', 'song_id', 'album_id', 'name', 'performer', 'video_url', 
                        'thumb_img', 'publish_time', 'is_feature', 'keywords', 'category'];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'name' => 'required',
            'video_url' => 'required|url'
        ];
        $rules = [
            'create' => array_merge($common, [
                'singer_id' => 'required',
            ]),
            'update' => array_merge($common, [
                'singer_id' => 'sometimes|required',
            ])
        ];
        return array_get($rules, $key);
    }

    /**
     * Relationship
     */
    public function singer() {
        return $this->belongsTo('App\Models\User');
    }
    public function song() {
        return $this->belongsTo('App\Models\Song');
    }

}
