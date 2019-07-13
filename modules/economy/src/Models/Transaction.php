<?php
namespace Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
