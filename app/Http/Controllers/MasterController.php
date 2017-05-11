<?php
/*
  * TODO
  * - Upload/Edit avatar image
  *
  * */
namespace App\Http\Controllers;

use App\Models\Authentication;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Mail;

class MasterController extends Controller {

    public function index(Request $request) {
        //
        try {
            $currentUser = $this->getAuthenticatedUser();

            $auths = Authentication::query();

            if ($currentUser->level == Authentication::AUTH_ADMIN) {
                $auths = $auths->with('application')->where('level', Authentication::AUTH_MASTER)->get();

                return $this->responseSuccess($auths);
            } else {
                return $this->responseError('Cannot find master', 200);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    /**
     * @api {post} /master/ Create new master
     * @apiName CreateMaster
     * @apiGroup Master
     *
     * @apiParamExample {json} POST Request-Example:
     *      {
     *          'sec_name' => 'required|max:255|unique,
     *          'sec_pass' => 'required|min:6|max:30',
     *          'name' => '',
     *      }
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "id": 9
     *              "sec_name": "fan1@example.com",
     *              "updated_at": "2016-01-11 10:58:23",
     *              "created_at": "2016-01-11 10:58:23",
     *          }
     *      }
     */
    public function store(Request $request) {
        // Create user
        try {
            $data = $request->all();
            $data['type'] = 0;

            $validator = Validator::make($data, Authentication::rules('create'));

            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $auth = new Authentication($data);
            $auth->sec_pass = \Hash::make($data['sec_pass']);
            $auth->level = Authentication::AUTH_MASTER;
            $auth->status = Authentication::AUTH_STATUS_ACTIVE;

            $auth->save();

            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /master/:id Get detail of a Master
     * @apiName GetMasterDetail
     * @apiGroup Master
     *
     * @apiParam {Integer} id Master unique ID.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     *      {
     *          "error": false,
     *          "data": {
     *              "id": 9
     *              "email": "fan1@example.com",
     *              "role": "fan",
     *              ...
     *          }
     *      }
     */
    public function show($id) {
        //
        try {
            $auth = Authentication::findOrFail($id);

            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {put} /master/:id Update existing Master
     * @apiName UpdateMaster
     * @apiGroup Master
     *
     * @apiParam {Integer} id Master unique ID.
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
            $auth = Authentication::findOrFail($id);

            $data = $request->all();
            $rules = Authentication::rules('update', $id);

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return $this->responseError($validator->errors()->all(), 422);
            }

            $auth->fill($data);

            if (isset($data['sec_pass']) && !empty($data['sec_pass'])) {
                $auth->sec_pass = \Hash::make($data['sec_pass']);
            }

            $auth->save();

            return $this->responseSuccess($auth);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    public function destroy($id) {
        //
        try {
            $auth = Authentication::findOrFail($id);

            // TODO Only Admin could delete user
            $auth->delete();

            return $this->responseSuccess(['Master is deleted']);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }
}