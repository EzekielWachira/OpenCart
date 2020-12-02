<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => $faker->randomDigit(),
        'name' => $faker->text(10),
        'description' => $faker->paragraph(),
        'image' => $faker->text(15),
        'price' => $faker->randomFloat(2, 1, 20),
        'rating' => $faker->randomDigit()
    ];
});
