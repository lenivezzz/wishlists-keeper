<?php

use App\Keeper\Category\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->word,
        'alias' => sprintf('%s-%s', strtolower($title), $faker->uuid),
    ];
});
