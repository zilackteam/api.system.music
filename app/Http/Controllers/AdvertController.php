<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdvertController extends Controller {

    /**
     * @api {get} /advert/ Get list of Advert
     * @apiName GetAdvert
     * @apiGroup Advert
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
            $adverts = Advert::query();

            //Query by query string

            $adverts = $adverts->get();

            return $this->responseSuccess($adverts);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();

            $validator = \Validator::make($data, Advert::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $advert = new Advert();
            $advert->fill($data);
            $advert->save();

            return $this->responseSuccess($advert);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /advert/:id Get detail of a Advert
     * @apiName GetAdvertDetail
     * @apiGroup Advert
     *
     * @apiParam {Integer} id Advert unique ID.
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
            $advert = Advert::findOrFail($id);

            return $this->responseSuccess($advert);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $advert = Advert::findOrFail($id);

            $data = $request->all();
            $validator = \Validator::make($data, Advert::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $advert->fill($data);
            $advert->save();

            return $this->responseSuccess($advert);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $advert = Advert::findOrFail($id);
            $advert->delete();
            return $this->responseSuccess('Advert is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}