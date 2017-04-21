<?php 
namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Queries\VideoQueryBuilder;

class VideoController extends Controller {

    /**
     * @api {get} /video/ Get list of Video
     * @apiName LístVideo
     * @apiGroup Video
     *
     * @apiParam {Integer} content_id Filter videos by content id
     * @apiParam {Integer} category  Filter videos by content id
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
            $queryBuilder = new VideoQueryBuilder(new Video, $request);

            $videos = $queryBuilder->build()->get();

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
            $upload = uploadMedia($request, 'file', video_path($data['content_id']), $name );

            if (!$upload) {
                return $this->responseError('Could not do the upload', 200, $data);
            } else {
                return json_encode(['link' => url('resources/uploads/' . $data['content_id'] . '/video/' . $upload)]);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}