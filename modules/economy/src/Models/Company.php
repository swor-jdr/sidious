<?php
namespace Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Economy\Traits\HasEconomy;
use Modules\Galaxy\Models\Planet;
use Nicolasey\Personnages\Models\Personnage;

class Company extends Model
{
    use SoftDeletes, HasEconomy;

    protected $guarded = [];

    /**
     * Company location
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planet()
    {
        return $this->belongsTo(Planet::class);
    }

    /**
     * Personnages allowed to manage this company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function managers()
    {
        return $this->belongsToMany(Personnage::class);
    }
}
