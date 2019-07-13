<?php
namespace Modules\Economy\Traits;


use Modules\Economy\Models\Company;

trait HasCompanies
{
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public static function bootHasCompanies()
    {
        static::deleting(function ($model) {
            $model->companies()->delete();
        });
    }
}