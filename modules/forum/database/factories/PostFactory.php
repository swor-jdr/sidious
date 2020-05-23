<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Forum\Models\Post::class, function (Faker $faker) {
    static $author_id;
    static $topic_id;

    return [
        "author_id" => ($author_id) ? $author_id : factory(\Modules\Personnages\Models\Personnage::class)->create()->id,
        "topic_id" => ($topic_id) ? $topic_id : factory(\Modules\Forum\Models\Topic::class)->create()->id,
        "content" => $faker->paragraph
    ];
});
