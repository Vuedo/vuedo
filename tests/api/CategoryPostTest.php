<?php

use App\Transformers\PostTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryPostTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function it_shows_categorys_posts_paginated()
    {
        $category = createCategory();
        $posts = createPost([], 50);

        $category->posts()->attach($posts);

        $this->get(route('api.categories.posts.index', $category->hashid))
             ->seeJson()
             ->seeJsonContains(
                 Fractal::collection($category->posts()->paginate(10), new PostTransformer)->getArray()
             );
    }
}
