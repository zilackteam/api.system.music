<?php 
namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller {
    protected $singer;

    function __construct(User $singer) {
        $this->singer = $singer;
    }

    /**
     * @api {post} /website/:singer_id/setup Init singer websites
     * @apiName InitWebsite
     * @apiGroup Website
     *
     * @apiParam {Integer} id Singer unique ID.
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
    public function setup($singerId) {
        try {
            //Verify singer
            $singer = $this->singer->checkSinger($singerId);

            //Verify website
            $website = Website::where('singer_id', $singerId)->first();
            if ($website) return $this->responseError(['Website is already existed'], 400);

            $website = Website::create(['singer_id' => $singerId]);

            return $this->responseSuccess($website);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /website/:singer_id/content/:type Get content
     * @apiName WebsiteBio
     * @apiGroup Website
     *
     * @apiParam {Integer} id Singer unique ID.
     * @apiParam {String}  type Website content type. Could be either "app" | "bio" | "contact" | "dev" | "guide"
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
    public function content($singerId, $type = null) {
        //
        try {
            //Verify singer
            $singer = $this->singer->checkSinger($singerId);

            //Verify website
            $websites = Website::where('singer_id', $singerId)->get();
            if ($websites->count() == 0) return $this->responseError(['No Website found. Please 
            setup a new one.'], 404);
            if ($websites->count() > 1) return $this->responseError(['There is more than one Website, 
            Contact CMS Admin'], 500);

            $website = $websites[0];
            $result = $website->getAttributes();

            if ($type == 'app' || $type == 'bio' || $type == 'contact' || $type == 'dev' || $type == 'guide') {
                $result = [
                    'id' => $website->id,
                    'singer_id' => $website->singer_id,
                    'avatar' => $singer->avatar,
                    "{$type}_title" => $website->{"{$type}_title"},
                    "{$type}_content" => $website->{"{$type}_content"},
                    'singer_info' => $website->singer_info,
                    'facebook' => $website->facebook,
                    'twitter' => $website->twitter,
                    'instagram' => $website->instagram,
                    'created_at' => $result['created_at'],
                    'updated_at' => $result['updated_at'],
                    'deleted_at' => $result['deleted_at']
                ];
            }

            return $this->responseSuccess($result);

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {put} /website/:singer_id/update Update Website Content
     * @apiName UpdateWebsite
     * @apiGroup Website
     *
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          "bio_title" : "Bio Title",
     *          "bio_content" : "Bio Content",
     *          "contact_title" : "Contact Title",
     *          "contact_content" : "Contact Content",
     *          "app_title" : "App Title",
     *          "app_content" : "App Content",
     *          "dev_title" : "Dev Title",
     *          "dev_content" : "Dev Content",
     *          "guide_title" : "Guide Title",
     *          "guide_content" : "Guide Content",
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
    public function update(Request $request, $singerId) {
        //
        try {
            //Verify singer
            $singer = $this->singer->checkSinger($singerId);

            //Verify website
            $websites = Website::where('singer_id', $singerId)->get();
            if (count($websites) > 1) return $this->responseError(['There is more than one Website, 
            Contact CMS Admin'], 500);
            $website = $websites[0];
            $websiteData = $website->getAttributes();

            $data = $request->all();
            $validator = \Validator::make($data, Website::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            foreach ($data as $field => $value) {
                if (array_key_exists($field, $websiteData)) {
                    $website->{$field} = $value;
                }
            }
            $website->save();

            return $this->responseSuccess($website);



        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function upload(Request $request) {
        try {
            $data = $request->all();

            $data['upload_type'] = 'image';

            $validation = \Validator::make($data, Upload::rules($data['upload_type']));
            if ($validation->fails()) {
                return $this->responseError($validation->errors()->all(), 422);
            }
            $name = hash('md5', date('YmdHis'));
            $upload = uploadMedia($request, 'file', website_path($data['singer_id']), $name );

            if (!$upload) {
                return $this->responseError('Could not do the upload', 200, $data);
            } else {
                return json_encode(['link' => url('resources/uploads/' . $data['singer_id'] . '/website/' . $upload)]);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

}
