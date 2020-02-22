<?php
namespace App\Traits;

trait IsReacter
{
    public static function bootIsReacter()
    {
        static::created(function ($model) {
            $model->registerAsLoveReacter();
        });
    }
}
