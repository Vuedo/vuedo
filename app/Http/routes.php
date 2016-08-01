<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'web'], function () {
    //homepage
    Route::get('/', ['as' => 'web.home', 'uses' => 'PagesController@home']);
    Route::get('blog', ['as' => 'web.blog', 'uses' => 'PagesController@home']);
    Route::get('/blog/{posts}', ['as' => 'web.post', 'uses' => 'PagesController@post']);
    Route::get('/category/{categories}', ['as' => 'web.category', 'uses' => 'PagesController@category']);

});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'Api'], function () {
    //posts
    Route::post('posts/{posts}/publish', ['as' => 'api.posts.publish', 'uses' => 'PostsController@publish']);
    Route::post('posts/{posts}/image', ['as' => 'api.posts.updateImage', 'uses' => 'PostsController@updateImage']);
    Route::resource('posts', 'PostsController', ['except' => ['create', 'edit']]);

    //categories
    Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']]);

    //posts categories
    Route::patch('posts/{posts}/categories', ['as' => 'api.posts.categories.sync', 'uses' => 'PostsCategoriesController@sync']);
    Route::resource('posts.categories', 'PostsCategoriesController', ['only' => ['index', 'store', 'destroy']]);

    //categories posts
    Route::get('categories/{categories}/posts', [ 'as' => 'api.categories.posts.index', 'uses' => 'CategoriesPostsController@index']);

    //users
    Route::get('me', ['as' => 'api.me.show', 'uses' => 'MeController@show']);
    Route::patch('me', ['as' => 'api.me.update', 'uses' => 'MeController@update']);
    Route::put('me', ['as' => 'api.me.update', 'uses' => 'MeController@update']);
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'dashboard', 'middleware' => 'authorized:view-dashboard'], function () {
    Route::get('/{vue_capture?}', function () {
        return view('admin.index');
    })->where('vue_capture', '[\/\w\.-]*');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::auth();
