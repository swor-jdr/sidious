<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Improvement extends Model
{
    use SoftDeletes;

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
