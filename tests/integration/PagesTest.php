<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function it_shows_latest_posts_on_home(){
        $posts = createPost(['moderated_at' => time()], 10);
        $this->visit(route('web.home'));

        //see the 10 latest posts
        foreach ($posts as $post) {
            $this->see($post->title);
        }
    }
    /** @test */
    public function it_shows_a_post(){
        $post = createPost();
        $c = createCategory();
        $post->categories()->attach($c);

        $this->visit(route('web.post', $post->slug))
            ->see($post->title);
    }

    /** @test */
    public function it_navigates_to_post_from_home(){
        $post = createPost();
        $c = createCategory();
        $post->categories()->attach($c);

        $this->visit(route('web.home'))
            ->click($post->title)
            ->seePageIs(route('web.post', $post->slug));
    }

    /** @test */
    public function it_shows_categorys_posts(){
        $posts = createPost([], 10);
        $category = createCategory();

        $category->posts()->attach($posts->take(5));

        $this->visit(route('web.category', $category->slug));

        //see category's posts
        foreach ($posts->take(5) as $post) {
            $this->see($post->title);
        }

        // don't see irrelevant posts
        foreach ($posts->slice(5, 5) as $post) {
            $this->dontSee($post->title);
        }

    }
}
