<?php

namespace App\Models;

class App extends VeoModel {
    protected $table = 'apps';

    protected $guarded = [];

    protected $hidden = [];

    public function latestInfo()
    {
        return $this->hasOne('App\Models\AppInfo')->latest();
    }
}