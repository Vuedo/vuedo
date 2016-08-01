<?php

use App\Post;
use App\Transformers\PostTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_all_posts_paginated()
    {
        $this->get(route('api.posts.index'))
             ->seeJson()
             ->seeJsonContains(
                 Post::withPostponed()->orderBy('created_at', 'DESC')->paginate(10)->items(),
                 new PostTransformer
             );
    }

    /** @test */
    public function it_paginates_posts_and_keeps_request_param_when_changing_pages()
    {
        createPost([], 20);
        $this->get(route('api.posts.index').'?include=categories&page=1')
             ->seeJson()
             ->seeJsonContains(
                 ["next" => 'http://'.Request::server("SERVER_NAME")."/api/posts?include=categories&page=2"]
             );
    }

    /** @test */
    public function it_shows_a_post_by_hashid()
    {
        $post = createPost();
        $this->get(route('api.posts.show', Hashids::encode($post->id)))
             ->seeJsonContains(
                 Fractal::item($post, new PostTransformer)->getArray()
             );
    }

    /** @test */
    public function it_shows_a_post_along_with_its_owner()
    {
        $post = createPost();
        $this->get(route('api.posts.show', $post->hashid) . '?include=owner')
             ->seeJsonContains([
                 "owner" => Fractal::item($post->owner, new UserTransformer)->getArray()
             ]);
    }

    /** @test */
    public function it_creates_a_post()
    {
        $post_count = \App\Post::count();
        $this->actingAsAdmin()
             ->post(route('api.posts.store'))
             ->seeJson();

        $this->assertGreaterThan($post_count, \App\Post::withPostponed()->count());
    }

    /** @test */
    public function it_updates_a_post()
    {
        $post = createPost();
        $this->actingAsAdmin()
             ->patch(route('api.posts.update', $post->hashid),
                 ['title' => 'New Title', 'description' => 'no'])
             ->seeJson()
             ->seeJsonContains(
                 ['title' => 'New Title', 'description' => 'no']
             )
             ->seeInDatabase('posts', ['id' => $post->id, 'title' => 'New Title', 'description' => 'no']);
    }

    /** @test */
    public function it_publishes_a_post()
    {
        $post = createPost();
        $this->actingAsAdmin()
             ->post(route('api.posts.publish', $post->hashid))
             ->seeJson()
             ->seeJsonContains(
                 ['status' => 'approved']
             )
             ->seeInDatabase('posts', ['id' => $post->id, 'status' => \Hootlex\Moderation\Status::APPROVED]);
    }

    /** @test */
    public function it_deletes_a_post()
    {
        $post = createPost();
        $this->actingAsAdmin()
             ->delete(route('api.posts.destroy', $post->hashid))
             ->seeJsonContains(
                 [
                     'success' => true,
                     'message' => 'Successfully deleted post.'
                 ]
             )
             ->dontSeeInDatabase('posts',
                 ['id' => $post->id, 'title' => $post->title, 'description' => $post->description]);
    }

    /** @test */
    public function it_throws_exception_if_post_not_exists()
    {
        $this->get(route('api.posts.show', Hashids::encode(1000000)))
             ->seeJson()
             ->seeStatusCode(404);
    }

    /** @test */
    public function it_throws_exception_if_hashid_is_invalid()
    {
        $this->get(route('api.posts.show', 1))
             ->seeJson()
             ->seeStatusCode(404);
    }

    /** @test */
    public function it_throws_forbidden_exception_when_action_needs_logged_user()
    {
        $post = createPost();
        $this->delete(route('api.posts.destroy', $post->hashid))
             ->seeStatusCode(401)
             ->seeJsonContains(['message' => 'You are not logged in.']);
    }

    /** @test */
    public function it_throws_unauthorized_exception_if_action_needs_further_permissions()
    {
        $post = createPost();
        $this->actingAs(\App\User::notAdmin()->first())
             ->delete(route('api.posts.destroy', $post->hashid))
             ->seeStatusCode(403)
             ->seeJsonContains(['message' => 'You need permission to perform this action.']);
    }
}
