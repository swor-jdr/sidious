<?php
namespace Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function to()
    {
        return $this->belongsTo(Account::class, "to");
    }

    public function from()
    {
        return $this->belongsTo(Account::class, "from");
    }

    /**
     * Handles account balance when created or deleted
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->to->updateBalance($model->amount, $model->isCredit);
            $model->from->updateBalance($model->amount, !$model->isCredit);
        });

        static::deleted(function ($model) {
            $model->to->updateBalance($model->amount, !$model->isCredit);
            $model->from->updateBalance($model->amount, $model->isCredit);
        });
    }
}
