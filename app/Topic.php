<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function lastPost()
    {
        return $this->posts()->latest("created_at");
    }
}
