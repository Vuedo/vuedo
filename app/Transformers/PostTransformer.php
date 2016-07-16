<?php

namespace App\Transformers;

use App\Post;
use Hashids;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = ['owner', 'categories'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = [];

    /**
     * Transform object into a generic array
     *
     * @var  object
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'hashid' => Hashids::encode($post->id),
            'title' => $post->title,
            'slug' => $post->slug,
            'description' => $post->description,
            'image' => $post->image_url,
            'content' => $post->content,
            'status' => $post->getHumanStatus()
        ];
    }

    public function includeOwner(Post $post){
        return $this->item($post->owner, new UserTransformer);
    }

    public function includeCategories(Post $post){
        return $this->collection($post->categories, new CategoryTransformer);
    }
}
