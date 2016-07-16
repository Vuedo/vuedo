<?php

use Illuminate\Database\Seeder;

class CategoriesProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        createCategory(['name' => 'News']);
        createCategory(['name' => 'Plugins']);
        createCategory(['name' => 'Tutorials']);
        createCategory(['name' => 'Meetups']);
        $featured = createCategory(['name' => 'Featured']);

        //add only one post to featured
        $featured->posts()->attach(\App\Post::latest()->first());

    }
}
