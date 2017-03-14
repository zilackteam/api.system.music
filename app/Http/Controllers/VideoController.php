<?php 
namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller {

    /**
     * @api {get} /video/ Get list of Video
     * @apiName LístVideo
     * @apiGroup Video
     *
     * @apiParam {Integer} singer_id Filter videos by singer's id
     * @apiParam {Integer} song_id Filter videos by song's id
     * @apiParam {String} with Separate by "," character
     * - `singer`   : Return with singer info
     * - `song`     : Return with song info
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        //
        try {
            $videos = Video::query();
            if ($request->has('singer_id')) {
                $videos->where('singer_id', $request->get('singer_id'));
            }
            if ($request->has('song_id')) {
                $videos->where('song_id', $request->get('song_id'));
            }
            if ($request->has('with')) {
                $with = explode(',', $request->get('with'));
                foreach ($with as $param) {
                    if ($param == 'song') {
                        $videos->with('song');
                    }
                    if ($param == 'singer') {
                        $videos->with('singer');
                    }
                }
            }
            
            if ($request->has('category')) {
                $videos->where('category', $request->get('category'));
            }
            
            $videos->orderBy('is_feature', 'desc')
                ->orderBy('updated_at', 'desc');
            
            $videos = $videos->get();

            return $this->responseSuccess($videos);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Video::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $video = new Video();
            $video->fill($data);
            $video->save();

            return $this->responseSuccess($video);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /video/:id Get a Video
     * @apiName GetVideoDetail
     * @apiGroup Video
     *
     * @apiParam {Integer} id Video unique ID.
     * @apiParam {String} with Separate by "," character
     * - `singer`   : Return with singer info
     * - `song`     : Return with song info
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
            $video = Video::findOrFail($id);
            if ($request->has('with')) {
                $with = explode(',', $request->get('with'));
                foreach ($with as $param) {
                    if ($param == 'song') {
                        $video->song;
                    }
                    if ($param == 'singer') {
                        $video->singer;
                    }
                }
            }

            return $this->responseSuccess($video);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $video = Video::findOrFail($id);

            $data = $request->all();

            $validator = \Validator::make($data, Video::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $video->fill($data);
            $video->save();

            return $this->responseSuccess($video);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $video = Video::findOrFail($id);
            $video->delete();
            return $this->responseSuccess('record_deleted');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function upload(Request $request) {
        //
        try {
            $data = $request->all();

            $validation = \Validator::make($data, Upload::rules('image'));
            if ($validation->fails()) {
                return $this->responseError($validation->errors()->all(), 422);
            }

            $name = hash('md5', date('YmdHis'));
            $upload = uploadMedia($request, 'file', video_path($data['singer_id']), $name );

            if (!$upload) {
                return $this->responseError('Could not do the upload', 200, $data);
            } else {
                return json_encode(['link' => url('resources/uploads/' . $data['singer_id'] . '/video/' . $upload)]);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}