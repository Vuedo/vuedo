<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        DB::table('category_post')->truncate();

        createCategory(['name' => 'News']);
        createCategory(['name' => 'Plugins']);
        createCategory(['name' => 'Tutorials']);
        createCategory(['name' => 'Meetups']);
        $featured = createCategory(['name' => 'Featured']);
        
        $categories = \App\Category::take(4)->get();
        foreach (\App\Post::all() as $post) {
            $toAttach = $categories->take(rand(1,5));
            $post->categories()->attach($toAttach);
        }

        //add only one post to featured
        $featured->posts()->attach(\App\Post::latest()->first());

    }
}
