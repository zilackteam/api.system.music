<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\App;
use App\Models\Authentication;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AppController extends Controller {

    public function index(Request $request) {
        //
        try {
            $auth = Authentication::findOrFail($request->auth_id);

            if ($auth->level == Authentication::AUTH_ADMIN) {
                $apps = App::query();

                $apps = $apps->get();
            } else {
                $apps = App::join('app_managers', 'app_managers.app_id', '=', 'apps.id')
                    ->where('app_managers.manager_id', $auth->id)
                    ->get();
            }

            return $this->responseSuccess($apps);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            $validator = \Validator::make($data, App::rules('create'));

            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $app = new App();
            $app->fill($data);
            $app->save();

            return $this->responseSuccess($app);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function show(Request $request, $id) {
        //
        try {
            $app = App::where('content_id', $id)->first();

            return $this->responseSuccess($app);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $app = App::where('content_id', $id)->first();

            $data = $request->all();

            if (array_get($data, 'thumb_url') == $app->thumb_url) unset($data['thumb_url']);

            $validator = \Validator::make($data, App::rules('update'));

            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $app->fill($data);

            //Upload image
            if ($request->hasFile('thumb_url') && $request->file('thumb_url')->isValid()) {
                $image = $request->file('thumb_url');
                $imageType = $image->getClientOriginalExtension();

                $fileName = 'app_'.$app->id .'_'.date('YmdHis') . '.' . $imageType;

                $dir = application_path($app->content_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }

                $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
                $thumbSaved = Image::make($image->getRealPath())->fit(300, 300)->save($dir . DS . 'thumb_' .$fileName);

                if (!$imgSaved || !$thumbSaved || !$fileName) {
                    return $this->responseError('cant_save_image', 507);
                }

                $app->thumb_url = $fileName;
            }

            $app->save();

            return $this->responseSuccess($app);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}