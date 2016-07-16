<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoriesPostsController extends ApiController
{
    /**
     * Display a listing of the category's posts.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        return $this->respondWith(
            $category->posts()->paginate(10)->appends([ 'include' => $request->input('include')]),
            new PostTransformer
        );
    }
}
