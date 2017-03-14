<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VersionController extends Controller {
    
    public function index(Request $request) {
        //
        try {
            
            if ($request->has('cms')) {
                $versions = Version::query();
                
                if ($request->has('singer_id')) {
                    $versions->where('singer_id', $request->get('singer_id'));
                }
                
                $versions->orderBy('updated_at', 'desc');
                
                $data = $versions->get();
            } else {
                $versionsIos = Version::query();
                $versionsAndroid = Version::query();
                
                if ($request->has('singer_id')) {
                    $versionsIos->where('singer_id', $request->get('singer_id'));
                    $versionsAndroid->where('singer_id', $request->get('singer_id'));
                }
                
                $versionsIos->orderBy('updated_at', 'desc');
                $versionsAndroid->orderBy('updated_at', 'desc');
                //Query by query string
                
                $versionsIos = $versionsIos->where('type', Version::TYPE_IOS)->first();
                $versionsAndroid = $versionsAndroid->where('type', Version::TYPE_ANDROID)->first();
                
                $data = array(
                    'ios' => $versionsIos,
                    'android' => $versionsAndroid
                );
            }
            
            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
    
    public function store(Request $request) {
        //
        try {
            $data = $request->all();
    
            $version = new Version();
            $version->fill($data);
    
            $validator = \Validator::make($version->getAttributes(), Version::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
    
            $version->save();
    
            return $this->responseSuccess($version);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
    
    public function update(Request $request, $id) {
        //
        try {
            $version = Version::findOrFail($id);
    
            $data = $request->all();
            $version->fill($data);
    
            $validator = \Validator::make($version->getAttributes(), Version::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
    
            $version->save();
    
            return $this->responseSuccess($version);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
    
    public function destroy($id) {
        //
        try {
            $version = Version::findOrFail($id);
            $version->delete();
    
            return $this->responseSuccess('Version is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}