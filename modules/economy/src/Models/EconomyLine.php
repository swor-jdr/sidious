<?php
namespace Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EconomyLine extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Line's economy fiche
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fiche()
    {
        return $this->belongsTo(Fiche::class);
    }

    /**
     * Handles economy fiche balance
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->fiche->updateBalance($model->amount, $model->isCredit);
        });

        static::deleting(function ($model) {
            $model->fiche->updateBalance($model->amount, !$model->isCredit);
        });
    }
}
