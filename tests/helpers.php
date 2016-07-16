<?php

/**
 * @param array $overrides
 * @param int $limit
 *
 * @return \App\User | Illuminate\Database\Eloquent\Collection
 */
function createUser($overrides = [], $limit = 1)
{
    return factory(\App\User::class, $limit)->create($overrides);
}

/**
 * @param array $overrides
 * @param int $limit
 *
 * @return \App\Post | Illuminate\Database\Eloquent\Collection
 */
function createPost($overrides = [], $limit = 1)
{
    $faker = Faker\Factory::create();
    $post = factory(\App\Post::class, $limit)->create($overrides);
//    $post->hashid = Hashids::encode($post->id);
    return $post;
}

/**
 * @param array $overrides
 * @param int $limit
 *
 * @return \App\Category | Illuminate\Database\Eloquent\Collection
 */
function createCategory($overrides = [], $limit = 1)
{
    return factory(\App\Category::class, $limit)->create($overrides);
}

/**
 * Generate post's content in markdown format
 * including headings, quotes, and images.
 *
 * @param \Faker\Generator $faker
 *
 * @return string
 */
function markdownContent(Faker\Generator $faker){
    $content =
    "$faker->realText \n\r ".
    "## $faker->sentence \n\r ".
    "![$faker->word]($faker->imageUrl) {.img-responsive} \n\r ".
    "> $faker->sentence \n\r ".
    "### $faker->sentence \n\r ".
    "$faker->paragraph \n\r ".
    "[$faker->sentence](#)";
    return $content;
}