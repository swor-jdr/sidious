<?php
namespace Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fiche extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Fiche's owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo("owner");
    }

    /**
     * Fiche's economy lines
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines()
    {
        return $this->hasMany(EconomyLine::class);
    }

    /**
     * Add or withdraw amount from fiche balance
     *
     * @param int $amount
     * @param bool $isCredit
     */
    public function updateBalance(int $amount, bool $isCredit)
    {
        $this->balance += ($isCredit) ? $amount : -$amount;
        $this->save();
    }
}
