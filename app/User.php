<?php

namespace App;

use App\Traits\IsJWTSubject;
use App\Traits\IsReacter;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Personnages\Traits\HasPersonnages;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, \Cog\Contracts\Love\Reacterable\Models\Reacterable
{
    use Notifiable, IsJWTSubject, SoftDeletes, HasRolesAndAbilities, HasPersonnages, Reacterable, IsReacter;

    protected $with = ['personnages'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
