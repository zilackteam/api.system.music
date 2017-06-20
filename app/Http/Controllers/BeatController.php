<?php

namespace App\Http\Controllers;

use App\Http\Queries\BeatQueryBuilder;
use App\Models\Beat;
use Illuminate\Http\Request;
use App\Http\Requests;

class BeatController extends Controller {

    /**
     * @api {get} /beat/ Get list of Beat
     * @apiName GetBeat
     * @apiGroup Beat
     *
     * @apiParam {Integer} content_id Filter beats by content id
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
            $queryBuilder = new BeatQueryBuilder(new Beat(), $request);

            $beats = $queryBuilder->build()->get();

            return $this->responseSuccess($beats);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            $validator = \Validator::make($data, Beat::rules('create'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $beat = new Beat();
            $beat->fill($data);
            $beat->save();

            return $this->responseSuccess($beat);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /beat/:id Get detail of a Beat
     * @apiName GetBeatDetail
     * @apiGroup Beat
     *
     * @apiParam {Integer} id Beat unique ID.
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
            $beat = Beat::findOrFail($id);

            return $this->responseSuccess($beat);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $beat = Beat::findOrFail($id);

            $data = $request->all();

            //If media input does not change -> ignore it
            if (!empty($data['thumb_url']) && $data['thumb_url'] == $beat->thumb_url) unset ($data['thumb_url']);
            if (array_get($data, 'file128') == $beat->file128) unset ($data['file128']);
            if (array_get($data, 'file320') == $beat->file320) unset ($data['file320']);
            if (array_get($data, 'file_lossless') == $beat->file_lossless) unset ($data['file_lossless']);

            $validator = \Validator::make($data, Beat::rules('update'));
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $beat->fill($data);
            $beat->save();

            if ($request->file('file128') && $request->file('file128')->isValid()) {
                $name128 = 'beat_128_' . date('YmdHis');
                $uploadSong = uploadMedia($request, 'file128', beat_path($beat->content_id, $beat->id), $name128 );
                if ($uploadSong) {
                    //Delete if old file existed
                    $oldFile = beat_path($beat->content_id, $beat->id) . DS . $beat->getAttributes()['file128'];
                    if (is_file($oldFile)) unlink($oldFile);

                    $beat->file128 = $uploadSong;
                    $beat->save();

                } else {
                    return $this->responseError('Could not update beat file', 200, $beat);
                }
            }

            if ($request->file('file320') && $request->file('file320')->isValid()) {
                $name320 = 'beat_320_' . date('YmdHis');
                $uploadSong = uploadMedia($request, 'file320', beat_path($beat->content_id, $beat->id), $name320);
                if ($uploadSong) {
                    //Delete if old file existed
                    $oldFile = beat_path($beat->content_id, $beat->id) . DS . $beat->getAttributes()['file320'];
                    if (is_file($oldFile)) unlink($oldFile);

                    $beat->file320 = $uploadSong;
                    $beat->save();

                } else {
                    return $this->responseError('Could not update beat file', 200, $beat);
                }
            }

            if ($request->file('file_lossless') && $request->file('file_lossless')->isValid()) {
                $nameLL = 'beat_lossless_' . date('YmdHis');
                $uploadSong = uploadMedia($request, 'file_lossless', beat_path($beat->content_id, $beat->id), $nameLL );
                if ($uploadSong) {

                    //Delete if old file existed
                    $oldFile = beat_path($beat->content_id, $beat->id) . DS . $beat->getAttributes()['file_lossless'];
                    if (is_file($oldFile)) unlink($oldFile);

                    $beat->file_lossless = $uploadSong;
                    $beat->save();

                } else {
                    return $this->responseError('Could not update beat file', 200, $beat);
                }
            }

            if ($request->file('thumb_url') && $request->file('thumb_url')->isValid()) {
                $nameThumb = 'image_' .  date('YmdHis');
                $uploadThumb = uploadImage($request, 'thumb_url', beat_path($beat->content_id, $beat->id), $nameThumb);
                if ($uploadThumb) {

                    $oldThumb = beat_path($beat->content_id, $beat->id) . DS . $beat->getAttributes()['thumb_url'];
                    if (is_file($oldThumb)) unlink($oldThumb);

                    $oldImg = beat_path($beat->content_id, $beat->id) . DS . 'thumb_' . $beat->getAttributes()['thumb_url'];
                    if (is_file($oldImg)) unlink($oldImg);

                    $beat->thumb_url = $uploadThumb;
                    $beat->save();

                } else {
                    return $this->responseError('Could not update beat file', 200, $beat);
                }
            }

            return $this->responseSuccess($beat);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $beat = Beat::findOrFail($id);
            $beat->delete();
            return $this->responseSuccess('Beat is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function delete(Request $request) {
        //
        try {
            $data = $request->all();

            $ids = explode(',', $data['id']);

            Beat::whereIn('id', $ids)->delete();

            return $this->responseSuccess('Beat is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function feature(Request $request) {
        //
        try {
            $data = $request->all();

            $ids = explode(',', $data['id']);

            Beat::whereIn('id', $ids)->update(['is_feature' => $data['is_feature']]);

            return $this->responseSuccess('Beat updated success!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function setPublic(Request $request) {
        //
        try {
            $data = $request->all();

            $ids = explode(',', $data['id']);

            Beat::whereIn('id', $ids)->update(['is_public' => $data['is_public']]);

            return $this->responseSuccess('Song updated success!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}