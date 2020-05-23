<?php

namespace Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];

    /**
     * Account owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo("owner");
    }

    /**
     * Account transactions From
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionsFrom()
    {
        return $this->hasMany(Transaction::class, "from");
    }

    /**
     * Account transactions To
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionsTo()
    {
        return $this->hasMany(Transaction::class, "to");
    }

    /**
     * All account transactions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function transactions()
    {
        return $this->transactionsFrom()->get()->merge($this->transactionsTo()->get());
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

    public function fiche()
    {
        return $this->belongsTo(Fiche::class);
    }

    /**
     * Checks if account can pay a given amount
     *
     * @param int $amount
     * @return bool
     */
    public function canPay(int $amount)
    {
        return ($this->balance >= $amount);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->owner_name = $model->owner->name;
            $model->save();
        });
    }
}
