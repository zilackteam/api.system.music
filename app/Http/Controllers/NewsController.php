<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use App\Http\Queries\NewsQueryBuilder;

class NewsController extends Controller {

    public function index(Request $request) {
        try {
            $queryBuilder = new NewsQueryBuilder(new News, $request);

            $news = $queryBuilder->build()->get();

            return $this->responseSuccess($news);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            $validator = \Validator::make($data, News::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
            
            $name = 'thumb_' . hash('md5', date('YmdHis'));
            $upload = saveThumb($data['thumb_url'], news_path($data['content_id']), $name);
            
            if ($upload) {
                $data['thumb_url'] = url('resources/uploads/' . $data['content_id'] . '/news/' . $upload);
            } else {
                $data['thumb_url'] = '';
            }

            $news = new News();
            $news->fill($data);
            $news->save();

            return $this->responseSuccess($news);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    public function show($id) {
        //
        try {
            $news = News::findOrFail($id);

            return $this->responseSuccess($news);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $news = News::findOrFail($id);

            $data = $request->all();
            $validator = \Validator::make($data, News::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);
            
            if (!empty($data['thumb_url'])) {
                $name = 'thumb_' . hash('md5', date('YmdHis'));
                $upload = saveThumb($data['thumb_url'], news_path($data['content_id']), $name);
                
                if ($upload) {
                    $data['thumb_url'] = url('resources/uploads/' . $data['content_id'] . '/news/' . $upload);
                } else {
                    $data['thumb_url'] = '';
                }
            } else {
                unset($data['thumb_url']);
            }

            $news->fill($data);
            $news->save();

            return $this->responseSuccess($news);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $news = News::findOrFail($id);
            $news->delete();
            return $this->responseSuccess('News is deleted!');
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
            $upload = uploadPhoto($request, 'file', news_path($data['content_id']), $name );

            if (!$upload) {
                return $this->responseError('Could not do the upload', 200, $data);
            } else {
                return json_encode(['link' => url('resources/uploads/' . $data['content_id'] . '/news/' . $upload)]);
            }

        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }


    /**
     * @api {get} /news/listing/ Get list News
     * @apiName GetListNews
     * @apiGroup News
     *
     * @apiParam {Integer} content_id Get list news of content_id.
     *
     */
    public function listing(Request $request) {
        try {

            $page = Paginator::resolveCurrentPage('page');
            $perPage = 10;
            $news = News::query();

            if ($request->has('content_id')) {
                $news->where('content_id', $request->get('content_id'));
            } else {
                die('Invalid access');
            }

            $news->orderBy('created_at', 'DESC');

            $news = $news->skip(($page - 1) * $perPage)->take($perPage + 1)->get();

            $paginator = new Paginator(
                $news,
                $perPage,
                $page,
                [
                    'path' => Paginator::resolveCurrentPath(),
                    'query' => $request->all()
                ]
            );

            $news = $paginator->items();

            $topNews = $listNews = '';
            if (count($news)) {
                $topNews = $news[0];
                unset($news[0]);
                $listNews = $news;
            }

            return view('news.listing', compact(['listNews', 'topNews', 'paginator']));
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    /**
     * @api {get} /news/detail/:id Get detail of a News
     * @apiName GetDetailNews
     * @apiGroup News
     *
     * @apiParam {Integer} id Get ID of News
     *
     */
    public function detail(Request $request, $id) {
        try {
            $news = News::findOrFail($id);

            $totalRelate = 5;
            $relatedNews = News::where('id', '<>', $id)
                ->where('content_id', $news->content_id)
                ->orderBy('updated_at', 'DESC')
                ->take($totalRelate)
                ->get();

            return view('news.detail', compact(['news', 'relatedNews']));
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}