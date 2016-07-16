<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Post;
use App\Transformers\PostTransformer;
use Hashids;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostsCategoriesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('authorized:manage-post-categories,posts', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return $this->respondWith($post, new PostTransformer, ['categories']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $post->categories()->attach($request->get('categories'));
        return $this->respondWith($post, new PostTransformer, ['categories']);
    }

    /**
     * Sync post categories.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request, Post $post)
    {
        $categories = $request->get('categories');

        //get ids from hashids
        foreach ($categories as $category) {
            $ids[] = \Hashids::decode($category['hashid'])[0];
        }
        
        $post->categories()->sync($ids);
        return $this->respondWith($post, new PostTransformer, ['categories']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Category $category)
    {
        $post->categories()->detach($category);
        return $this->respondWith($post, new PostTransformer, ['categories']);
    }
}
