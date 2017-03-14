<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SongController extends Controller {

    /**
     * @api {get} /song/ Get list of Song
     * @apiName GetSong
     * @apiGroup Song
     *
     * @apiParam {Integer} singer_id Filter songs by singer's id
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
            $songs = Song::query();
            if ($request->has('singer_id')) {
                $songs->where('singer_id', $request->get('singer_id'));
            }
            
            if ($request->has('cms')) {
                
            } else {
                $songs->where('is_public', true);
            }
            
            $songs->orderBy('is_feature', 'desc')
                ->orderBy('updated_at', 'desc');
            
            $songs = $songs->get();

            return $this->responseSuccess($songs);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            $validator = \Validator::make($data, Song::rules('create'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $song = new Song();
            $song->fill($data);
            $song->save();

            /*$name128 = 'song_128_' . date('YmdHis');
            $uploadSong = uploadMedia($request, 'file128', song_path($song->singer_id, $song->id), $name128 );

            $nameThumb = 'image_' . date('YmdHis');
            $uploadThumb = uploadImage($request, 'thumb_img', song_path($song->singer_id, $song->id), $nameThumb);

            $msg = '';
            if (!$uploadSong && !$uploadThumb) {
                $msg = 'Song created but could not upload thumb or file';
            } elseif (!$uploadSong) {
                $msg = 'Song created but could not upload file';
            } elseif (!$uploadThumb) {
                $msg = 'Song created but could not upload thumb';
            }

            if ($msg)
                return $this->responseError($msg, 200, $song);

            if ($uploadSong) $song->file128 = $uploadSong; $song->save();
            if ($uploadThumb) $song->thumb_img = $uploadThumb; $song->save();*/

            return $this->responseSuccess($song);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /song/:id Get detail of a Song
     * @apiName GetSongDetail
     * @apiGroup Song
     *
     * @apiParam {Integer} id Song unique ID.
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
    public function show($id) {
        //
        try {
            $song = Song::findOrFail($id);

            return $this->responseSuccess($song);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $song = Song::findOrFail($id);

            $data = $request->all();

            //If media input does not change -> ignore it
            if (!empty($data['thumb_img']) && $data['thumb_img'] == $song->thumb_img) unset ($data['thumb_img']);
            if (array_get($data, 'file128') == $song->file128) unset ($data['file128']);
            if (array_get($data, 'file320') == $song->file320) unset ($data['file320']);
            if (array_get($data, 'file_lossless') == $song->file_lossless) unset ($data['file_lossless']);

            $validator = \Validator::make($data, Song::rules('update'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $song->fill($data);
            $song->save();


            if ($request->file('file128') && $request->file('file128')->isValid()) {
                $name128 = 'song_128_' . date('YmdHis');
                $uploadSong = uploadMedia($request, 'file128', song_path($song->singer_id, $song->id), $name128 );
                if ($uploadSong) {

                    //Delete if old file existed
                    $oldFile = song_path($song->singer_id, $song->id) . DS . $song->getAttributes()['file128'];
                    if (is_file($oldFile)) unlink($oldFile);

                    $song->file128 = $uploadSong;
                    $song->save();

                } else {
                    return $this->responseError('Could not update song file', 200, $song);
                }
            }

            if ($request->file('file320') && $request->file('file320')->isValid()) {
                $name320 = 'song_320_' . date('YmdHis');
                $uploadSong = uploadMedia($request, 'file320', song_path($song->singer_id, $song->id), $name320);
                if ($uploadSong) {

                    //Delete if old file existed
                    $oldFile = song_path($song->singer_id, $song->id) . DS . $song->getAttributes()['file320'];
                    if (is_file($oldFile)) unlink($oldFile);

                    $song->file320 = $uploadSong;
                    $song->save();

                } else {
                    return $this->responseError('Could not update song file', 200, $song);
                }
            }

            if ($request->file('file_lossless') && $request->file('file_lossless')->isValid()) {
                $nameLL = 'song_lossless_' . date('YmdHis');
                $uploadSong = uploadMedia($request, 'file_lossless', song_path($song->singer_id, $song->id), $nameLL );
                if ($uploadSong) {

                    //Delete if old file existed
                    $oldFile = song_path($song->singer_id, $song->id) . DS . $song->getAttributes()['file_lossless'];
                    if (is_file($oldFile)) unlink($oldFile);

                    $song->file_lossless = $uploadSong;
                    $song->save();

                } else {
                    return $this->responseError('Could not update song file', 200, $song);
                }
            }

            if ($request->file('thumb_img') && $request->file('thumb_img')->isValid()) {
                $nameThumb = 'image_' .  date('YmdHis');
                $uploadThumb = uploadImage($request, 'thumb_img', song_path($song->singer_id, $song->id), $nameThumb);
                if ($uploadThumb) {

                    $oldThumb = song_path($song->singer_id, $song->id) . DS . $song->getAttributes()['thumb_img'];
                    if (is_file($oldThumb)) unlink($oldThumb);

                    $oldImg = song_path($song->singer_id, $song->id) . DS . 'thumb_' . $song->getAttributes()['thumb_img'];
                    if (is_file($oldImg)) unlink($oldImg);

                    $song->thumb_img = $uploadThumb;
                    $song->save();

                } else {
                    return $this->responseError('Could not update song file', 200, $song);
                }
            }

            return $this->responseSuccess($song);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $song = Song::findOrFail($id);
            $song->delete();
            return $this->responseSuccess('Song is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}