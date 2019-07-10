<?php

namespace Modules\Forum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolasey\Personnages\Models\Personnage;

class Topic extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function author()
    {
        return $this->belongsTo(Personnage::class);
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
