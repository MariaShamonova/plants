<?php

$factory->define(App\Plants::class, function (Faker\Generator $faker) {
    return [
        'articul' => $faker->randomNumber($nbDigits = 6),
        'title' => $faker->name,
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000), // 48.8932
        'size_id' => $faker->numberBetween($min = 1, $max = 3),
        'color_id' => $faker->numberBetween($min = 1, $max = 5),
        'category_id' => $faker->numberBetween($min = 1, $max = 10),
        'description' =>  $faker->text(50),
        'image' => $faker->imageUrl(),
    ];
});