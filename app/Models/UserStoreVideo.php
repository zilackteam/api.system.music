<?php

namespace App\Models;

class UserStoreVideo extends VeoModel {

    protected $table = 'user_store_videos';

    protected $fillable = ['video_id', 'content_id', 'user_id', 'pay'];
}
