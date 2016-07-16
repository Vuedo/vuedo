<?php

use App\Transformers\CategoryTransformer;
use App\Transformers\PostTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_all_categories()
    {
        $this->get(route('api.categories.index'))
             ->seeJson()
             ->seeJsonContains(
                 Fractal::collection(\App\Category::all(), new CategoryTransformer)->getArray()
             );
    }
    /** @test */
    public function it_shows_a_category()
    {
        $category = createCategory();
        $this->get(route('api.categories.show', $category->hashid))
             ->seeJson()
             ->seeJsonContains(
                 Fractal::item($category, new CategoryTransformer)->getArray()
             );
    }

    /** @test */
    public function it_shows_a_category_along_with_its_posts()
    {
        $category = createCategory();
        $this->get(route('api.categories.show', $category->hashid) . '?include=posts')
             ->seeJson()
             ->seeJsonContains([
                 "posts" => Fractal::collection($category->posts, new PostTransformer)->getArray()
             ]);
    }

    /** @test */
    public function it_creates_a_category()
    {
        $categoriesCount = \App\Category::count();
        $category = factory(\App\Category::class)->make();
        $this->actingAsAdmin()->post(route('api.categories.store', $category->toArray()))
             ->seeStatusCode(200)
             ->seeJson();

        $this->assertGreaterThan($categoriesCount, \App\Category::count());

    }

    /** @test */
    public function it_updates_a_category()
    {
        $category = createCategory();
        $this->actingAsAdmin()->patch(route('api.categories.update', $category->hashid),
            ['name' => 'New Name', 'icon' => 'fa fa-bicycle'])
             ->seeJson()
             ->seeJsonContains(
                 ['name' => 'New Name', 'icon' => 'fa fa-bicycle']
             )
             ->seeInDatabase('categories', ['id' => $category->id, 'name' => 'New Name', 'icon' => 'fa fa-bicycle']);
    }

    /** @test */
    public function it_deletes_a_category()
    {
        $category = createCategory();
        $this->actingAsAdmin()->delete(route('api.categories.destroy', $category->hashid))
             ->seeJson()
             ->seeJsonContains(
                 [
                     'success' => true,
                     'message' => 'Successfully deleted category.'
                 ]
             )
             ->dontSeeInDatabase('categories',
                 ['id' => $category->id, 'name' => $category->name]);
    }

    /** @test */
    public function it_throws_exception_if_post_not_exists()
    {
        $this->get(route('api.categories.show', Hashids::encode(10000000)))
             ->seeJson()
             ->seeStatusCode(404);
    }

    /** @test */
    public function it_throws_exception_if_hashid_is_invalid()
    {
        $this->get(route('api.categories.show', 1))
             ->seeJson()
             ->seeStatusCode(404);
    }

    /** @test */
    public function it_throws_forbidden_exception_when_action_needs_logged_user()
    {
        $category = factory(\App\Category::class)->create();
        $this->delete(route('api.categories.destroy', $category->hashid))
             ->seeStatusCode(401)
             ->seeJsonContains(['message' => 'You are not logged in.']);
    }

    /** @test */
    public function it_throws_unauthorized_exception_if_action_needs_further_permissions()
    {
        $category = factory(\App\Category::class)->create();
        $this->actingAs(\App\User::notAdmin()->first())
             ->delete(route('api.categories.destroy', $category->hashid))
             ->seeStatusCode(403)
             ->seeJsonContains(['message' => 'You need permission to perform this action.']);
    }
}
