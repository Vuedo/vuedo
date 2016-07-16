<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_hashid_correctly(){
        $post = createPost();
        $this->assertEquals(Hashids::encode($post->id), $post->hashid);
    }

    /** @test */
    public function it_attaches_a_category_to_a_post(){
        $post = createPost();
        $category = createCategory();

        $post->categories()->attach($category);

        $this->assertTrue($post->hasCategory($category));
    }

    /** @test */
    public function it_deletes_a_post_with_categories(){
        $post = createPost();
        $category = createCategory();

        $post->categories()->attach($category);

        $this->assertTrue($post->hasCategory($category));

        $post->delete();
    }

    /** @test */
    public function it_attaches_categories_to_posts(){
        $post = createPost();
        $categories = createCategory([], 2);

        $post->categories()->attach($categories);

        $this->assertTrue($post->hasCategory($categories[0]));
        $this->assertTrue($post->hasCategory($categories[1]));
    }

    /** @test */
    public function it_removes_categories_from_posts(){
        $post = createPost();
        $categories = createCategory([], 2);

        $post->categories()->attach($categories);
        $post->categories()->detach($categories->first());

        $this->assertFalse($post->hasCategory($categories->first()));
        $this->assertTrue($post->hasCategory($categories[1]));
    }
}
