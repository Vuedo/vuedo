<?php
namespace Acme;


use App\Category;
use App\Post;

class PostsRepo
{
    /**
     * @param int $perPage
     * @param array|string $includes
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPosts($perPage = null, $includes = []){
        $builder = Post::orderBy('posts.moderated_at', 'DESC')->with($includes);

        return self::paginateOrGet($builder, $perPage);;
    }

    /**
     * @param Category $category
     * @param int $perPage
     * @param array|string $includes
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getCategoryPosts($category, $perPage = null, $includes = []){
        $builder = $category->posts()->orderBy('posts.moderated_at', 'DESC')->with($includes);

        return self::paginateOrGet($builder, $perPage);;

    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getFeaturedPosts(){
        $featured = Category::whereSlug('featured')->firstOrFail();
        $posts = self::getCategoryPosts($featured);

        return $posts;
    }

    /**
     * @return Post
     */
    public static function getFeaturedPost(){
        $post = self::getFeaturedPosts()->first();

        return $post;
    }

    /**
     * @param $builder
     * @param $perPage
     *
     * @return mixed
     */
    public static function paginateOrGet($builder, $perPage)
    {
        if ($perPage) {
            $posts = $builder->paginate($perPage);
        } else {
            $posts = $builder->get();
        }
        return $posts;
    }
}