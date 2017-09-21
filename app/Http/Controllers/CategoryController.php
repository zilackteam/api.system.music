<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    
    public function index(Request $request) {
        try {
            $categories = Category::query();

            if ($request->has('type')) {
                $categories->where('type', $request->get('type'));
            }

            $categories->orderBy('is_feature', 'desc');
            $data = $categories->get();

            return $this->responseSuccess($data);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function store(Request $request) {
        //
        try {
            $data = $request->all();
            $validator = \Validator::make($data, Category::rules('create'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);

            $category = new Category();
            $category->fill($data);
            $category->save();

            return $this->responseSuccess($category);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }

    }

    public function show($id) {
        //
        try {
            $category = Category::findOrFail($id);

            return $this->responseSuccess($category);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function update(Request $request, $id) {
        //
        try {
            $category = Category::findOrFail($id);

            $data = $request->all();
            $validator = \Validator::make($data, Category::rules('update'));
            if ($validator->fails())
                return $this->responseError($validator->errors()->all(), 422);


            $category->fill($data);
            $category->save();

            return $this->responseSuccess($category);
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }

    public function destroy($id) {
        //
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return $this->responseSuccess('Category is deleted!');
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}