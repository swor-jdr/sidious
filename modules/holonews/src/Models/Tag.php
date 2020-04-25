<?php
namespace Modules\Holonews\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tag extends Model
{
    use SoftDeletes, HasSlug;

    protected $table = "news_tags";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The posts that has the tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Article::class, 'articles_tags', 'tag_id', 'article_id');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            $item->posts()->detach();
        });
    }
}
