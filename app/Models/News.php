<?php

namespace App\Models;

/**
 * App\Models\News
 *
 * @property integer $id
 * @property integer $singer_id
 * @property string $title
 * @property string $content
 * @property string $feature_img
 * @property boolean $status
 * @property integer $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class News extends VeoModel {

    protected $table = 'news';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'title' => 'required',
            'content' => 'required',
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
