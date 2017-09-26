<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\UserStoreAlbum;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Http\Queries\AlbumQueryBuilder;
use DB;

class AlbumController extends Controller {

    /**
     * @api {get} /album/ Get list of Album
     * @apiName GetAlbum
     * @apiGroup Album
     *
     * @apiParam {Integer} content_id Filter albums by content id
     * @apiParam {String} includes
     * - songs - Return songs in album
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
        try {
            $queryBuilder = new AlbumQueryBuilder(new Album, $request);

            $albums = $queryBuilder->build()->get();

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
            if ($request->hasFile('thumb_url') && $request->file('thumb_url')->isValid()) {
                $image = $request->file('thumb_url');
                $imageType = $image->getClientOriginalExtension();

                $fileName = 'album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;

                $dir = album_path($album->content_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }

                $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
                $thumbSaved = Image::make($image->getRealPath())->fit(300, 300)->save($dir . DS . 'thumb_' .$fileName);

                if (!$imgSaved || !$thumbSaved || !$fileName) {
                    return $this->responseError('cant_save_image', 507);
                }

                $album->thumb_url = $fileName;
            }
            
            if ($request->hasFile('feature_url') && $request->file('feature_url')->isValid()) {
                $image = $request->file('feature_url');
                $imageType = $image->getClientOriginalExtension();
            
                $fileName = 'feature_album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;
            
                $dir = album_path($album->content_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }
            
                $featureSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
            
                if (!$featureSaved) {
                    return $this->responseError('cant_save_image', 507);
                }
            
                $album->feature_url = $fileName;
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
            if ($request->has('includes')) {
                if ($request->get('includes') == 'songs') {
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

            if (array_get($data, 'thumb_url') == $album->thumb_url) unset($data['thumb_url']);
            if (array_get($data, 'feature_url') == $album->feature_url) unset($data['feature_url']);

            $validator = \Validator::make($data, Album::rules('update'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $album->fill($data);

            //Upload image
            if ($request->hasFile('thumb_url') && $request->file('thumb_url')->isValid()) {
                $image = $request->file('thumb_url');
                $imageType = $image->getClientOriginalExtension();

                $fileName = 'album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;

                $dir = album_path($album->content_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }

                $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
                $thumbSaved = Image::make($image->getRealPath())->fit(300, 300)->save($dir . DS . 'thumb_' .$fileName);

                if (!$imgSaved || !$thumbSaved || !$fileName) {
                    return $this->responseError('cant_save_image', 507);
                }

                $album->thumb_url = $fileName;
            }

            if ($request->hasFile('feature_url') && $request->file('feature_url')->isValid()) {
                $image = $request->file('feature_url');
                $imageType = $image->getClientOriginalExtension();
            
                $fileName = 'feature_album_'.$album->id .'_'.date('YmdHis') . '.' . $imageType;
            
                $dir = album_path($album->content_id);
                if (! \File::isDirectory($dir)) {
                    \File::makeDirectory($dir, 0775, true);
                }
            
                $featureSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
            
                if (!$featureSaved) {
                    return $this->responseError('cant_save_image', 507);
                }
            
                $album->feature_url = $fileName;
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

    public function buy($id) {
        //
        try {
            $currentUser = $this->getAuthenticatedUser();
            $album = Album::findOrFail($id);
            $userStoreAlbum = UserStoreAlbum::where('album_id', $album->id)
                ->where('content_id', $album->content_id)
                ->where('user_id', $currentUser->id)
                ->first();

            if (($album->price > 0) && !empty($currentUser->userInfo)
                && ($currentUser->userInfo->balance > $album->price) && !$userStoreAlbum) {

                $userStoreAlbum = new UserStoreAlbum();
                $userStoreAlbum->album_id = $album->id;
                $userStoreAlbum->content_id = $album->content_id;
                $userStoreAlbum->user_id = $currentUser->id;
                $userStoreAlbum->pay = 1;

                $currentUser->userInfo->balance = $currentUser->userInfo->balance - $album->price;

                DB::transaction(function() use ($userStoreAlbum, $currentUser) {
                    $userStoreAlbum->save();

                    $currentUser->userInfo->save();
                });

                return $this->responseSuccess('Album bought success!');
            } else {
                return $this->responseError('Could not buy this album', 200);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}