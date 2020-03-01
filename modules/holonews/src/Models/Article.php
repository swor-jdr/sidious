<?php
namespace Modules\Holonews\Models;

use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;

class Article extends Model implements ReactableContract
{
    use SoftDeletes, Reactable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'publish_date',
    ];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
        'published' => 'boolean',
    ];

    /**
     * The tags the post belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'wink_posts_tags', 'post_id', 'tag_id');
    }

    /**
     * The post author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to only include drafts (unpublished posts).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('published', false);
    }

    /**
     * Scope a query to only include posts whose publish date is in the past (or now).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLive($query)
    {
        return $query->published()->where('publish_date', '<=', now());
    }

    /**
     * Scope a query to only include posts whose publish date is in the future.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query->where('publish_date', '>', now());
    }

    /**
     * Scope a query to only include posts whose publish date is before a given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBeforePublishDate($query, $date)
    {
        return $query->where('publish_date', '<=', $date);
    }

    /**
     * Scope a query to only include posts whose publish date is after a given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAfterPublishDate($query, $date)
    {
        return $query->where('publish_date', '>', $date);
    }
}
