<?php

use App\OrderLocationDetails;
use Faker\Generator as Faker;

$factory->define(OrderLocationDetails::class, function (Faker $faker) {
    return [
        'order_id' => $faker->unique->numberBetween($min = 1, $max = 6),
        'user_lat' => $faker->latitude($min = 6.5, $max = 6.6),
        'user_long' => $faker->longitude($min = 3.2, $max = 3.4),
        'vendor_lat' => $faker->latitude($min = 7.3, $max = 7.4),
        'vendor_long' => $faker->longitude($min = 3.9, $max = 4),
        'rider_lat' => $faker->latitude($min = 6.9, $max = 7),
        'rider_long' => $faker->longitude($min = 3.4, $max = 3.5)
    ];
});