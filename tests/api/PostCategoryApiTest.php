<?php

use App\Transformers\CategoryTransformer;
use App\Transformers\PostTransformer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostCategoryApiTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_a_post_with_its_categories()
    {
        $post = createPost();
        $categories = createCategory([], 2);

        $post->categories()->attach($categories);


        $this->actingAsAdmin()
            ->get(route('api.posts.categories.index', $post->hashid))
            ->seeJsonContains(
                Fractal::includes(['categories'])->item($post, new PostTransformer)->getArray()
            );
    }

    /** @test */
    public function it_adds_categories_to_posts()
    {
        $post = createPost();
        $categories = createCategory([], 2);
        $payload = ['categories' => $categories->pluck('id')->all()];


        $this->actingAsAdmin()
             ->post(route('api.posts.categories.store', $post->hashid), $payload)
             ->seeJsonContains(
                 Fractal::collection($categories, new CategoryTransformer)->getArray()
             );
    }

    /** @test */
    public function it_syncs_categories_to_posts()
    {
        $post = createPost();
        $categories = createCategory([], 4);
        $post->categories()->attach($categories);

        //keep 2 categories, remove 2 and add 2 more
        $newCategories = createCategory([], 2);

        $payload = ['categories' => $newCategories->merge($categories->slice(2))];

//        $payload['categories']->transform(function ($item) {
//            $item->hashid = $item->hashid;
//            unset($item->id);
//            return $item;
//        });

        $this->actingAsAdmin()
             ->patch(route('api.posts.categories.sync', $post->hashid), $payload)
             ->seeJsonContains(
                 Fractal::collection($payload['categories'], new CategoryTransformer)->getArray()
             );
    }

    /** @test */
    public function it_removes_categories_from_posts()
    {
        $post = createPost();
        $categories = createCategory([], 2);

        $post->categories()->attach($categories);

        $this->actingAsAdmin()
             ->delete(route('api.posts.categories.destroy', [$post->hashid, $categories[0]->hashid]))
             ->seeJsonContains(
                 Fractal::item($categories[1], new CategoryTransformer)->getArray()
             )
            ->dontSeeJson(
                Fractal::item($categories[0], new CategoryTransformer)->getArray()
            );
    }

    /** @test */
    public function it_throws_unauthorized_exception_if_action_needs_further_permissions()
    {
        $post = createPost();
        $categories = createCategory([], 2);

        $post->categories()->attach($categories);

        $this->actingAs(\App\User::notAdmin()->first())
            ->delete(route('api.posts.categories.destroy', [$post->hashid, $categories[0]->hashid]))
             ->seeStatusCode(403)
             ->seeJsonContains(['message' => 'You need permission to perform this action.']);
    }
}
