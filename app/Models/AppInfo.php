<?php

namespace App\Models;

class AppInfo extends VeoModel {
    protected $table = 'app_infos';

    protected $guarded = [];

    protected $hidden = [];

    protected $fillable = ['app_id', 'version', 'platform', 'store_url'];

    public static function rules($key = 'create', $id = '') {
        $common = [
            'version' => 'required',
            'platform' => 'required',
        ];

        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ]),
        ];

        return array_get($rules, $key);
    }

    public function getLatestAttribute($value) {
        return !empty($this->attributes['latest']) ? 1 : 0;
    }

    public static function removeLatestVersion($appId, $platform) {
        $affectedRows = AppInfo::where('app_id', $appId)->where('platform', $platform)->update(['latest' => null]);

        return $affectedRows;
    }
}