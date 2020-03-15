<?php
namespace Modules\Transition\Models;

use Illuminate\Database\Eloquent\Model;

class TransitionPost extends Model
{
    protected $connection = 'v4';
    protected $table = "phpbb_posts";
    protected $guarded = [];
}
