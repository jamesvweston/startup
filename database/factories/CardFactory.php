<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Card::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'number'    => '4242424242424242',
        'cvc'       => '333',
        'exp_month' => '11',
        'exp_year' => 2020,
        'address_zip' => 31401,
        'country_id' => 233
    ];
});
