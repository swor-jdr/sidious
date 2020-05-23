<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Forum\Models\Topic::class, function (Faker $faker) {
    static $author_id;
    static $forum_id;

    return [
        "author_id" => ($author_id) ? $author_id : factory(\Modules\Personnages\Models\Personnage::class)->create()->id,
        "forum_id" => ($forum_id) ? $forum_id : factory(\Modules\Forum\Models\Forum::class)->create()->id,
        "name" => $faker->sentence,
        "content" => null
    ];
});
