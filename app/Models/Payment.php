<?php

namespace App\Models;

class Payment extends VeoModel {

    //protected $table = 'news';

    //protected $guarded = [];

    //protected $hidden = [];

    public static function rules($key = 'create') {
        $codes = [
            'VNP' => 'Vinaphone',
            'VMS' => 'Mobifone',
            'VTT' => 'Viettel'
        ];

        $common = [
            'provider' => 'required|in:VNP,VMS,VTT,MGC',
            'pin'=> 'required|regex:/(^[0-9 ]+$)+/',
            'serial'=> 'required|regex:/(^[0-9 ]+$)+/',
        ];
        $rules = [
            'create' => array_merge($common, [
            ]),
            'update' => array_merge($common, [
            ])
        ];
        return array_get($rules, $key);
    }

    //SET up validate rule



    //SET up error code from epay

    //Config place for ePay API path

}
