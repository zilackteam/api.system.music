<?php

namespace App\Models;

class ManagerSinger extends VeoModel {

    protected $table = 'manager_singers';

    protected $guarded = [];

    protected $hidden = [];

    public static function rules($key = 'create') {
        $common = [
            'mod_id' => 'required',
            'singer_id' => 'required',
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
    public function mod() {
        return $this->belongsTo('App\Models\User', 'mod_id');
    }
    public function singer() {
        return $this->belongsTo('App\Models\User', 'singer_id');
    }


}
