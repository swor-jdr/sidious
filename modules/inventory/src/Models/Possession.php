<?php

namespace Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Possession extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function object()
    {
        return $this->hasOne(Object::class);
    }

    public function owner()
    {
        return $this->morphTo("owner");
    }
}
