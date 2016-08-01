<?php

use Illuminate\Database\Seeder;

class PostsMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media')->truncate();

        $faker = Faker\Factory::create();
        foreach (\App\Post::all() as $post) {
            if(rand(1, 10) > 4){
                $post->addMedia($faker->image(null, 600, 400))->preservingOriginal()->toCollectionOnDisk('featured', 'local-media');
            }
        }
    }
}
