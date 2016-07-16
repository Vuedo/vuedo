<?php

namespace App\Transformers;

use App\Category;
use Hashids;
use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var  array
     */
    protected $availableIncludes = ['posts'];

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
    public function transform(Category $category)
    {
        return [
            'hashid' => Hashids::encode($category->id),
            'name' => $category->name,
            'slug' => $category->slug,
            'icon' => $category->icon
        ];
    }

    public function includePosts(Category $category){
        return $this->collection($category->posts, new PostTransformer);
    }

}
