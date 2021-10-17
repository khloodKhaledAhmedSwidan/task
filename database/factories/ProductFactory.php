<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $categories = Category::pluck('id')->toArray();
    return [
        //
        //
        'name' => $faker->word,
        'desc'  => $faker->sentence,
        'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 10),
        'quantity' => $faker->randomDigit,
        'category_id' => $categories != null ?  $faker->randomElement($categories) : function () {
            return factory(Category::class)->create()->id;
        },
        'image' => $faker->image('public/storage/products', 640, 480, null, false),

    ];
});
