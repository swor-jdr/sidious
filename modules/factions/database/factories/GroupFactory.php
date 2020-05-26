<?php
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Modules\Factions\Models\Group::class, function (Faker $faker) {
    static $name;

    return [
        'name' => ($name) ? $name: $faker->name,
        'color' => $faker->hexColor,
    ];
});