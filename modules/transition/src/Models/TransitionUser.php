<?php
namespace Modules\Transition\Models;

use Illuminate\Database\Eloquent\Model;

class TransitionUser extends Model
{
    protected $primaryKey = 'user_id';
    protected $connection = 'v4';
    protected $table = "phpbb_users";
    protected $guarded = [];

    const TRANSITION = [
        "user_id" => "v4_id",
        "username" => "name",
        "user_email" => "v4_email",
    ];
}
