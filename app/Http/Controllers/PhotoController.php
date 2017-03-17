<?php 
namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhotoController extends Controller {

    /**
     * @api {get} /photo/ Get list of Photo
     * @apiName LístPhoto
     * @apiGroup Photo
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
            $photos = Photo::query();
            if ($request->has('content_id')) {
                $photos->where('content_id', $request->get('content_id'));
            }
            
            if ($request->has('category')) {
                $photos->where('category', $request->get('category'));
            }
            
            $photos->orderBy('updated_at', 'desc');
            
            $photos = $photos->get();

            return $this->responseSuccess($photos);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {post} /photo/ Create new Photo
     * @apiName CreatePhoto
     * @apiGroup Photo
     *
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "id": 1,
     *          }
     *      }
     */
    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Photo::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
            
            $name = 'thumb_' . hash('md5', date('YmdHis'));
            $upload = saveThumb($data['thumb_path'], photo_path($data['singer_id']), $name);
            
            if ($upload) {
                $data['thumb_path'] = url('resources/uploads/' . $data['singer_id'] . '/photo/' . $upload);
            } else {
                $data['thumb_path'] = '';
            }
            
            $photo = new Photo();
            $photo->fill($data);
            $photo->save();

            return $this->responseSuccess($photo);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /photo/:id Get a Photo
     * @apiName GetPhotoDetail
     * @apiGroup Photo
     *
     * @apiParam {Integer} id Photo unique ID.
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
            $photo = Photo::findOrFail($id);

            return $this->responseSuccess($photo);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {put} /photo/:id Update Photo
     * @apiName UpdatePhoto
     * @apiGroup Photo
     *
     * @apiParam {Integer} id Photo unique ID.
     *
     * @apiParamExample {json} PUT Request-Example:
     *     {
     *
     *      }
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
    public function update(Request $request, $id) {
        //
        try {
            $photo = Photo::findOrFail($id);

            $data = $request->all();
            $validator = \Validator::make($data, Photo::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
            
            if (!empty($data['thumb_path'])) {
                $name = 'thumb_' . hash('md5', date('YmdHis'));
                $upload = saveThumb($data['thumb_path'], photo_path($data['singer_id']), $name);
                
                if ($upload) {
                    $data['thumb_path'] = url('resources/uploads/' . $data['singer_id'] . '/photo/' . $upload);
                } else {
                    $data['thumb_path'] = '';
                }
            } else {
                unset($data['thumb_path']);
            }

            $photo->fill($data);
            $photo->save();

            return $this->responseSuccess($photo);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {delete} /photo/:id Delete Photo
     * @apiName DeletePhoto
     * @apiGroup Photo
     *
     * @apiParam {Integer} id Photo unique ID.
     *
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
    public function destroy($id) {
        //
        try {
            $photo = Photo::findOrFail($id);
            $photo->delete();
            return $this->responseSuccess('Photo is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function upload(Request $request) {
        //
        try {
            $data = $request->all();

//             $validation = \Validator::make($data, Upload::rules('image'));
//             if ($validation->fails()) {
//                 return $this->responseError($validation->errors()->all(), 422);
//             }

            $name = hash('md5', date('YmdHis'));
            $upload = uploadPhoto($request, 'file', photo_path($data['singer_id']), $name );

            if (!$upload) {
                return $this->responseError('Could not do the upload', 200, $data);
            } else {
                return json_encode([
                    'link' => url('resources/uploads/' . $data['singer_id'] . '/photo/' . $upload),
                    'thumb' => url('resources/uploads/' . $data['singer_id'] . '/photo/' . $upload),
                ]);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}