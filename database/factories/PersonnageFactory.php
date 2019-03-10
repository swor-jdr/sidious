<?php

use Faker\Generator as Faker;

$factory->define(\Nicolasey\Personnage\Models\Personnage::class, function (Faker $faker) {
    static $name;
    static $owner;

    return [
        'name' => ($name) ? $name : $faker->name,
        'owner' => ($owner) ? $owner : 1,
    ];
});
