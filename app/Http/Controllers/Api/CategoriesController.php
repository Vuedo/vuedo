<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoriesController extends ApiController
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
        $this->middleware('authorized:manage-category,categories', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWith(Category::all(), new CategoryTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = hash('adler32', time());
        $category->save();
        return $this->respondWith($category, new CategoryTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Category $category)
    {
        return $this->respondWith($category, new CategoryTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->all());
        $category->slug = null;
        $category->save();

        return $this->respondWith($category, new CategoryTransformer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     *
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->respondWithArray([
            'success' => true,
            'message' => 'Successfully deleted category.'
        ]);
    }
}
