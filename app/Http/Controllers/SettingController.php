<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;

class SettingController extends Controller {
    protected $setting;

    public function __construct(Setting $setting) {
        $this->setting = $setting;
    }

    public function get() {
        //
        try {
            $settings = $this->setting->firstOrCreate([]);

            return $this->responseSuccess($settings);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function manage(Request $request, Validator $validator) {
        //
        try {
            $validation = $validator->make($request->all(), $this->setting->validRules());
            if ($validation->fails())
                return $this->responseError($validation->errors()->all(), 400);

            $settings = $this->setting->firstOrCreate([]);
            $settings->filter = $request->get('filter');
            $settings->save();

            return $this->responseSuccess($settings);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}