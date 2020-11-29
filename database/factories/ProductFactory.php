<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'name' => $faker->text(10),
        'description' => $faker->paragraph,
        'image' => $faker->text(15),
        'price' => 20.34,
        'rating' => 4
    ];
});
