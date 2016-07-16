<?php

use Illuminate\Database\Seeder;

class PostsProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = factory(App\Post::class)->create(['title' => 'The first blog post.']);

        $faker = Faker\Factory::create();
        $post->addMedia($faker->image(null, 600, 400))->preservingOriginal()->toCollectionOnDisk('featured', 'local-media');
    }
}
