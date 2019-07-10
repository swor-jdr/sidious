<?php

use Faker\Generator as Faker;

$factory->define(\Nicolasey\Personnage\Models\Personnage::class, function (Faker $faker) {
    static $name;
    static $owner_id;

    return [
        'name' => ($name) ? $name : $faker->name,
        'owner_id' => ($owner_id) ? $owner_id : factory(\App\User::class)->create()->id,
    ];
});
