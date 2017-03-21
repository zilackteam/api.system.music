<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Queries\ShowQueryBuilder;

class ShowController extends Controller {

    /**
     * @api {get} /show/ Get list of Show
     * @apiName GetShow
     * @apiGroup Show
     *
     * @apiParam {Integer} singer_id Filter shows by singer's id
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
            $queryBuilder = new ShowQueryBuilder(new Show, $request);

            $shows = $queryBuilder->build()->get();

            return $this->responseSuccess($shows);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            unset($data['is_ending']);
            
            $show = new Show();
            $show->fill($data);

            $validator = \Validator::make($show->getAttributes(), Show::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $show->save();

            return $this->responseSuccess($show);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /show/:id Get detail of a Show
     * @apiName GetShowDetail
     * @apiGroup Show
     *
     * @apiParam {Integer} id Show unique ID.
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
            $show = Show::findOrFail($id);

            return $this->responseSuccess($show);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $show = Show::findOrFail($id);

            $data = $request->all();
            unset($data['is_ending']);
            
            $show->fill($data);

            $validator = \Validator::make($show->getAttributes(), Show::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $show->save();

            return $this->responseSuccess($show);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $show = Show::findOrFail($id);
            $show->delete();

            return $this->responseSuccess('Show is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}