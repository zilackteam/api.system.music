<?php

namespace App\Models;

/**
 * App\Models\Show
 *
 * @property integer $id
 * @property integer $singer_id
 * @property string $on_datetime
 * @property string $name
 * @property string $address
 * @property string $contact
 * @property string $impression
 * @property string $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Show extends VeoModel {

    const SHOW_NOT_START = 1;
    const SHOW_PROCESS = 2;
    const SHOW_END = 3;

    protected $table = 'shows';

    protected $guarded = [];

    protected $hidden = [];
    
    protected $appends = array('status');

    public static function rules($key = 'create') {
        $common = [
            'on_datetime' => 'required|date_format:Y-m-d H:i:s',
            'name' => 'required',
            'address' => 'required'
        ];
        $rules = [
            'create' => array_merge($common, [
                'singer_id' => 'required',
            ]),
            'update' => array_merge($common, [
            ])
        ];
        return array_get($rules, $key);
    }

    public function setOnDatetimeAttribute($value) {
        if ($value) {
            $this->attributes['on_datetime'] = date('Y-m-d H:i:s', strtotime($value));
        }
    }
    
    public function getStatusAttribute() {
        if ($this->on_datetime > date('Y-m-d H:i:s')) {
            return self::SHOW_NOT_START;
        } elseif ($this->end_date > date('Y-m-d')) {
            return self::SHOW_PROCESS;
        } else {
            return self::SHOW_END;
        }
    }
}

