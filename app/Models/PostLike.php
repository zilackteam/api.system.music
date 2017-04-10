<?php

namespace App\Models;

class PostLike extends VeoModel {

    protected $table = 'post_likes';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'post_id' => 'required',
            'user_id' => 'required',
        ];
        $rules = [
            'create' => array_merge($common, [
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
        return $this->belongsTo('App\Models\AppUser', 'user_id');
    }


}
