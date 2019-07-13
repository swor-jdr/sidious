<?php

namespace Modules\Galaxy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolasey\Personnages\Models\Personnage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Planet extends Model
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

    /**
     * Planet's secteur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    /**
     * Planet's managers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function managers()
    {
        return $this->belongsToMany(Personnage::class);
    }
}
