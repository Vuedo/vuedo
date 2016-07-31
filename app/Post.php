<?php

namespace App;

use Acme\Traits\HashOrSlugScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Hootlex\Moderation\Moderatable;
use Hootlex\Moderation\Status;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Vinkla\Hashids\Facades\Hashids;

/**
 * App\Post
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property string $description
 * @property string $content
 * @property integer $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $owner
 * @property-read mixed $hashid
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @method static \Illuminate\Database\Query\Builder|\App\Post findSimilarSlugs($model, $attribute, $config, $slug)
 * @property integer $status
 * @property \Carbon\Carbon $moderated_at
 * @property integer $moderated_by
 * @property-read mixed $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereModeratedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereModeratedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Post listing($relations = 'owner', $perPage = 10)
 * @method static \Illuminate\Database\Query\Builder|\App\Post whereHashOrSlug($value)
 */
class Post extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait, Moderatable, HashOrSlugScope;

    protected $fillable = ['title', 'slug', 'description', 'content'];

    /**
     * The user that belong to the post.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * The categories that belong to the post.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    /**
     * Check if the post has specific category.
     * @param $category
     *
     * @return bool
     */
    public function hasCategory($category)
    {
        $category_id = (is_int($category)) ? $category: $category->id;
        foreach ($this->categories as $cat) {
            if ($category_id === $cat->id){
                return true;
            }
        }
        return false;
    }

    /**
     * Get post status as human readable string.
     * @return string
     */
    public function getHumanStatus()
    {
        switch ($this->status) {
            case Status::APPROVED:
                $status = 'approved';
                break;
            case Status::REJECTED:
                $status = 'rejected';
                break;
            case Status::PENDING:
                $status = 'pending';
                break;
            case Status::POSTPONED:
                $status = 'postponed';
                break;
        }
        return $status;
    }
    /**
     * MUTATORS
     */
    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    /**
     * Get the original Url to an image
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->hasMedia() ? $this->getFirstMedia('featured')->getUrl() : null;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
