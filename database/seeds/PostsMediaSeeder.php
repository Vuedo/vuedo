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
                $counter = 0;
                // max retries = 5 because sometimes faker return false
                while (!($fakeImage = $faker->image(null, 600, 400)) && ($counter < 5)) {
                    $counter++;
                }

                if ($fakeImage !== false) {
                    $post->addMedia($fakeImage)->preservingOriginal()->toCollectionOnDisk('featured', 'local-media');
                }
            }
        }
    }
}
