<?php
namespace Modules\Forum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Personnages\Models\Personnage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Topic extends Model
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

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function author()
    {
        return $this->belongsTo(Personnage::class, "author");
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function lastPost()
    {
        return $this->posts()->latest("created_at");
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->posts()->delete();
        });
    }
}
