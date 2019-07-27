<?php
namespace Modules\Factions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model
{
    use SoftDeletes, HasSlug;

    protected $table = "groups";
    protected $guarded = [];

    /**
     * Filter secret groups
     *
     * @param bool $isSecret
     * @return mixed
     */
    public function scopeSecret($query, bool $isSecret)
    {
        return $query->where('isSecret', $isSecret);
    }

    /**
     * Keeps only factions, and no groups
     *
     * @param bool $isFaction
     * @return mixed
     */
    public function scopeFaction($query, bool $isFaction)
    {
        return $query->where('isFaction', $isFaction);
    }

    /**
     * Get the options for generating the slug.
     *
     * @return mixed
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}