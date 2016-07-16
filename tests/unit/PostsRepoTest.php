<?php

use Acme\PostsRepo;
use App\Category;
use App\Post;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsRepoTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function it_returns_all_posts(){
        createPost([], 20);
        
        $posts = PostsRepo::getPosts();
        $expectedPosts = Post::orderBy('posts.created_at', 'DESC')->get();

        $this->assertEquals($expectedPosts, $posts);
    }

    /** @test */
    public function it_returns_posts_paginated_with_relations(){
        createPost([], 20);
        
        $posts = PostsRepo::getPosts(10, 'owner');
        $expectedPosts = Post::orderBy('posts.created_at', 'DESC')->with('owner')->paginate(10);

        $this->assertEquals($expectedPosts, $posts);
    }

    /** @test */
    public function it_returns_categorys_posts_paginated_with_relations(){
        $newPosts = createPost([], 20);
        $category = createCategory();
        $category->posts()->attach($newPosts);
        
        $posts = PostsRepo::getCategoryPosts($category, 10, 'owner');
        $expectedPosts = $category->posts()->orderBy('posts.created_at', 'DESC')->with('owner')->paginate(10);

        $this->assertEquals($expectedPosts, $posts);
    }

    /** @test */
    public function it_returns_the_featured_posts(){
        $posts = createPost([], 3);
        $featured = Category::whereSlug('featured')->firstOrFail();

        $featured->posts()->attach($posts);

        $this->assertEquals($featured->posts()->latest()->get(), PostsRepo::getFeaturedPosts());
    }

    /** @test */
    public function it_returns_the_latest_featured_post(){
        $post = createPost();
        $featured = Category::whereSlug('featured')->firstOrFail();

        $featured->posts()->attach($post);

        $this->assertEquals($featured->posts()->latest()->first(), PostsRepo::getFeaturedPost());
    }
}
