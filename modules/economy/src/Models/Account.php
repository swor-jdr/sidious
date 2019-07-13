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
     * Account transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
