<?php

namespace App\Models;

/**
 * App\Models\Video
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $name
 * @property string $performer
 * @property string $video_url
 * @property string $thumb_url
 * @property string $publish_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Video extends VeoModel {

    protected $table = 'videos';

    protected $guarded = [];

    protected $fillable = ['content_id', 'name', 'performer', 'video_url',
                        'thumb_url', 'publish_time', 'is_feature', 'keywords', 'category'];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'name' => 'required',
            'video_url' => 'required|url'
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
