<?php

namespace App\Models;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 */
class LiveConfiguration extends VeoModel {

    const PROTOCOL_RMTP = 1;
    const PROTOCOL_RTSP = 2;
    const PROTOCOL_HTTP = 3;

    protected $table = 'live_configuration';

    protected $guarded = [];

    protected $hidden = [];

    protected $appends = ['protocol_str'];

    public static function rules($key = 'create') {
        $common = [
            'app_id' => 'required',
            'protocol' => 'required',
            'address' => 'required',
            'port' => 'required',
            'application' => 'required',
        ];
        $rules = [
            'create' => array_merge($common, [

            ]),
            'update' => array_merge($common, [

            ])
        ];

        return array_get($rules, $key);
    }

    public function getProtocolStrAttribute()
    {
        if ($this->attributes['protocol'] == self::PROTOCOL_RMTP) {
            return 'rmtp';
        } elseif ($this->attributes['protocol'] == self::PROTOCOL_RMTP) {
            return 'rtsp';
        } elseif ($this->attributes['protocol'] == self::PROTOCOL_RMTP) {
            return 'http';
        }

        return null;
    }
}
