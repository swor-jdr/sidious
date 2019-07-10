<?php

namespace Modules\Galaxy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Secteur extends Model
{
    use SoftDeletes, NodeTrait;

    protected $guarded = [];

    public function planets()
    {
        return $this->hasMany(Planet::class);
    }
}
