<?php
namespace App\Traits;


trait IsJWTSubject
{
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * You can change that by changing the getKey method in your model
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
