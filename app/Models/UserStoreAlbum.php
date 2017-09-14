<?php

namespace App\Models;

class UserStoreAlbum extends VeoModel {

    protected $table = 'user_store_albums';

    protected $fillable = ['album_id', 'content_id', 'user_id', 'pay'];
}
