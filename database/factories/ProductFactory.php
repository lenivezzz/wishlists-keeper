<?php

/* @var $factory Factory */

use App\Keeper\Product\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->unique()->word,
        'alias' => sprintf('%s-%s', $title, $faker->uuid)
    ];
});
