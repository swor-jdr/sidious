<?php
namespace Modules\Holonews\Models;

use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Wink\WinkPost;

class Article extends WinkPost implements \Cog\Contracts\Love\Reactable\Models\Reactable
{
    use Reactable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function boot()
    {
        static::created(function ($model) {
            $model->
        });
    }
}
