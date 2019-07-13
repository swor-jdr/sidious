<?php

namespace Modules\Galaxy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Secteur extends Model
{
    use SoftDeletes, NodeTrait, HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $guarded = [];

    /**
     * Secteur's planets
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planets()
    {
        return $this->hasMany(Planet::class);
    }

    public static function boot()
    {
        parent::boot();

        // Cascade delete
        static::deleted(function($model) {
            $model->planets()->delete();
            $model->children()->delete();
        });
    }
}
