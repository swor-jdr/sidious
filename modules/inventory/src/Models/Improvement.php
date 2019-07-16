<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Improvement extends Model
{
    use SoftDeletes, HasTags;

    protected $guarded = [];

    public function possession()
    {
        return $this->belongsToMany(Possession::class);
    }

    public function type()
    {
        return $this->hasOne(ObjectType::class);
    }
}
