<?php

namespace App\Models;

/**
 * App\Models\Comment
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $content
 * @property integer $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Comment extends VeoModel {

    protected $table = 'comments';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'content' => 'required'
        ];
        $rules = [
            'create' => array_merge($common, [
                'post_id' => 'required',
                'user_id' => 'required',
            ]),
            'update' => array_merge($common, [
            ])
        ];
        return array_get($rules, $key);
    }

    /**
     * Relationship
     */
    public function post() {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


}
