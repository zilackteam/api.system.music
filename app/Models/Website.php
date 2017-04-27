<?php

namespace App\Models;

/**
 * App\Models\Website
 *
 * @property integer $id
 * @property integer $singer_id
 * @property string $bio_title
 * @property string $bio_content
 * @property string $contact_title
 * @property string $contact_content
 * @property string $app_title
 * @property string $app_content
 * @property string $dev_title
 * @property string $dev_content
 * @property string $guide_title
 * @property string $guide_content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Website extends VeoModel {

    protected $table = 'websites';

    protected $guarded = [];

    public static function rules($key = 'create') {
        $common = [
            'bio_title' => 'sometimes|required',
            'bio_content' => 'sometimes|required',
            'contact_title' => 'sometimes|required',
            'contact_content' => 'sometimes|required',
            'app_title' => 'sometimes|required',
            'app_content' => 'sometimes|required',
            'dev_title' => 'sometimes|required',
            'dev_content' => 'sometimes|required',
            'guide_title' => 'sometimes|required',
            'guide_content' => 'sometimes|required',
        ];
        $rules = [
            'create' => array_merge($common, [
                'content_id' => 'required',
            ]),
            'update' => array_merge($common, [
                'content_id' => 'sometimes|required',
            ])
        ];
        return array_get($rules, $key);
    }


    /**
     * Relationship
     */
    public function singer() {
        return $this->belongsTo('App\Models\User');
    }

}