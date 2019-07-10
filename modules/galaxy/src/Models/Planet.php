<?php

namespace Modules\Galaxy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planet extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }
}
