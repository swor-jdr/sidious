<?php

namespace Modules\Forum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Forum extends Model
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

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function topicPosts()
    {
        return $this->hasManyThrough(Post::class, Topic::class);
    }

    public function latestTopicsPost()
    {
        return $this->topicPosts()->latest("created_at");
    }

    public function evaluateLastPost()
    {
        $collection = $this->latestTopicsPost()->get()->only("created_at", "id")->last();
        $descendants = $this->descendants()->with("latestTopicsPost")->get()->only("id", "created_at");
        foreach ($descendants as $descendant) $collection->merge($descendant->latestTopicsPost);
        $last = $collection->sortBy("created_at")->last();

        $this->last_id = $last->id;
        $this->save();
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            // softDelete child elements
            $model->topics()->delete();
            $model->children()->delete();

            // make the parent check lastPost accuracy
            if($model->parent) $model->parent->evaluateLastPost();
        });
    }

    public function last()
    {
        return $this->belongsTo(Post::class, "last_id");
    }
}
