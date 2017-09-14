<?php

namespace App\Models;

class UserStoreSong extends VeoModel {

    protected $table = 'user_store_songs';

    protected $fillable = ['song_id', 'content_id', 'user_id', 'pay'];
}
