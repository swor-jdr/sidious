<?php
namespace Modules\Forum\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolasey\Personnages\Models\Personnage;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(Personnage::class, "author");
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
