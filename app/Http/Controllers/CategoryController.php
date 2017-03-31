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
            if ($request->has('type')) {
                $categories = Category::query();
                $categories->where('type', $request->get('type'));
                $categories->orderBy('is_feature', 'desc');
                
                $data = $categories->get();
                
                return $this->responseSuccess($data);
            }
        } catch (\Exception $e) {
            return $this->responseErrorByException($e);
        }
    }
}