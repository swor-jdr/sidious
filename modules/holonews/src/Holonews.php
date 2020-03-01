<?php
namespace Modules\Holonews;

class Holonews
{
    /**
     * Get the default JavaScript variables for Wink.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'unsplash_key' => config('services.unsplash.key'),
            'path' => config('holonews.path'),
            'author' => auth('holonews')->check() ? auth('holonews')->user()->only('name', 'avatar', 'id') : null,
        ];
    }
}
