<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AlbumController extends Controller {

    /**
     * @api {get} /album/ Get list of Album
     * @apiName GetAlbum
     * @apiGroup Album
     *
     * @apiParam {Integer} singer_id Filter albums by singer's id
     * @apiParam {String} with
     * - song - Return songs in album
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": [
     *              {
     *                  "id": 1,
     *                  ...
     *              },
     *              {..}
     *          ]
     *      }
     */
    public function index(Request $request) {
        //
        try {
            $albums = Album::query();
            if ($request->has('singer_id')) {
                $albums->where('singer_id', $request->get('singer_id'));
            }
            
            if ($request->has('with')) {
                if ($request->get('with') == 'song') {
                    $albums->with('songs');
                }
            }
            
            if ($request->has('cms')) {
            
            } else {
                $albums->where('is_public', true);
            }
            
            if ($request->has('is_single')) {
                $albums->where('is_single', true);
            } else {
                $albums->where('is_single', false);
            }
            
            $albums->orderBy('is_feature', 'desc')
                ->orderBy('updated_at', 'desc');
            
            $albums = $albums->get();
            return $this->responseSuccess($albums);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Album::rules('create'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }
            $album = new Album($data);
            $album->save();

            //Upload image
            $imgSaved = false;
            $thumbSaved = false;
            $featureSaved = false;
            $fileName = '';
            
            if ($request->hasFile('thumb_img') && $request->file('thumb_img')->isValid()) {
                $image = $request->file('thumb_img');
                $imageType = $image->getClientOriginalExtension();

                $fileName = 'album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;

                $dir = album_path($album->singer_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }

                $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
                $thumbSaved = Image::make($image->getRealPath())->fit(300, 300)->save($dir . DS . 'thumb_' .$fileName);

                if (!$imgSaved || !$thumbSaved || !$fileName) {
                    return $this->responseError('cant_save_image', 507);
                }

                $album->thumb_img = $fileName;
            }
            
            if ($request->hasFile('feature_img') && $request->file('feature_img')->isValid()) {
                $image = $request->file('feature_img');
                $imageType = $image->getClientOriginalExtension();
            
                $fileName = 'feature_album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;
            
                $dir = album_path($album->singer_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }
            
                $featureSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
            
                if (!$featureSaved) {
                    return $this->responseError('cant_save_image', 507);
                }
            
                $album->feature_img = $fileName;
            }

            $album->save();

            return $this->responseSuccess($album);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /album/:id Get detail of a Album
     * @apiName GetAlbumDetail
     * @apiGroup Album
     *
     * @apiParam {Integer} id Album unique ID.
     * @apiParam {String} with
     * - song - Return songs in album
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *
     *          }
     *      }
     */
    public function show(Request $request, $id) {
        //
        try {
            $album = Album::findOrFail($id);
            if ($request->has('with')) {
                if ($request->get('with') == 'song') {
                    $album->songs;
                }
            }
            return $this->responseSuccess($album);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $album = Album::findOrFail($id);
            $data = $request->all();

            if (array_get($data, 'thumb_img') == $album->thumb_img) unset($data['thumb_img']);

            $validator = \Validator::make($data, Album::rules('update'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $album->fill($data);

            //Upload image
            if ($request->hasFile('thumb_img') && $request->file('thumb_img')->isValid()) {
                $image = $request->file('thumb_img');
                $imageType = $image->getClientOriginalExtension();

                $fileName = 'album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;

                $dir = album_path($album->singer_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }

                $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
                $thumbSaved = Image::make($image->getRealPath())->fit(300, 300)->save($dir . DS . 'thumb_' .$fileName);

                if (!$imgSaved || !$thumbSaved || !$fileName) {
                    return $this->responseError('cant_save_image', 507);
                }

                $album->thumb_img = $fileName;
            }

            if ($request->hasFile('feature_img') && $request->file('feature_img')->isValid()) {
                $image = $request->file('feature_img');
                $imageType = $image->getClientOriginalExtension();
            
                $fileName = 'feature_album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;
            
                $dir = album_path($album->singer_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }
            
                $featureSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
            
                if (!$featureSaved) {
                    return $this->responseError('cant_save_image', 507);
                }
            
                $album->feature_img = $fileName;
            }
            
            $album->save();

            return $this->responseSuccess($album);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $album = Album::findOrFail($id);
            $album->delete();
            return $this->responseSuccess('record_deleted');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function image(Request $request) {
        try {
            $data = $request->all();

            $validator = Validator::make($data, Album::rules('image'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $album = Album::findOrFail($data['id']);

            if ($request->file('thumb_img')) {
                $nameThumb = 'album_' . $album->id . date('YmdHis');
                $uploadThumb = uploadImage($request, 'thumb_img', album_path($album->singer_id), $nameThumb);

                if ($uploadThumb) {
                    if ($album->getAttributes()['thumb_img']) {
                        unlink(album_path($album->singer_id) . DS . $album->getAttributes()['thumb_img']);
                        unlink(album_path($album->singer_id) . DS . 'thumb_' . $album->getAttributes()['thumb_img']);
                    }

                    $album->thumb_img = $uploadThumb;
                    $album->save();
                    return $this->responseSuccess($album->thumb_img);
                } else {
                    return $this->responseError(['Could not upload image'], 200, $album);
                }
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }
}