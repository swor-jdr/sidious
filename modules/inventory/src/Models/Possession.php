<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Possession extends Model
{
    use SoftDeletes, HasSlug;

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

    public function object()
    {
        return $this->hasOne(Object::class);
    }

    public function owner()
    {
        return $this->morphTo("owner");
    }

    public function improvements()
    {
        return $this->belongsToMany(Improvement::class);
    }
}
