<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Post;
use App\Transformers\PostTransformer;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('authorized:manage-post,posts', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->respondWith(
            Post::withPostponed()->orderBy('created_at', 'DESC')->paginate(10)->appends([ 'include' => $request->input('include')]),
            new PostTransformer
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->title = hash('adler32', time());
        $post->created_by = \Auth::id() ?: User::admin()->first()->getKey();
        $post->save();

        return $this->respondWith($post, new PostTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Post $post)
    {
        return $this->respondWith($post, new PostTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Post $post)
    {
        $post->fill($request->all());
        //escape any html tags before saving
        //$post->content = strip_tags($post->content);
        $post->save();

        return $this->respondWith($post, new PostTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function updateImage(Request $request, Post $post)
    {
        if($request['file']->isValid()){
            if($post->hasMedia()){
                foreach ($post->getMedia('featured') as $media) {
                    $media->delete();
                }
            }
            //when we are working on local don't upload images to s3
            if( env('APP_ENV') == 'local'){
                $post->addMedia($request->file('file'))->preservingOriginal()->toCollectionOnDisk('featured', 'local-media');
            } else {
                $post->addMedia($request->file('file'))->preservingOriginal()->toMediaLibrary('featured');
            }

        }
        else {
            return $this->errorWrongArgs("No image submited.");
        }

        // fetch post again since media seems to be cached :(
        $post = Post::withPostponed()->findOrFail($post->id);
        return $this->respondWith($post, new PostTransformer);
    }

    /**
     * Publish specified post.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function publish(Request $request, Post $post)
    {
        //create new slug
        $post->update(['slug' => null]);
        
        if($request->user()->can('publish_post')){
            $post->markApproved();
        }
        else {
            $post->markPending();
        }
        return $this->respondWith($post, new PostTransformer);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     *
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->respondWithArray([
            'success' => true,
            'message' => 'Successfully deleted post.'
        ]);
    }
}
