<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Page::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'text' => $faker->paragraph(3),
        'title' => $faker->sentence(2),
        'keywords' => implode(', ', $faker->words(4)),
        'description' => $faker->sentence(),
    ];
});

$factory->define(App\News::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(2),
        'text' => $faker->paragraph(3),
        'published_at' => $faker->dateTimeThisMonth(),
        'image' => $faker->image(storage_path('images').DIRECTORY_SEPARATOR.'news', 640, 480, null, false, false),
    ];
});

$factory->define(App\Card::class, function (Faker\Generator $faker) {
    return [
        'DiscountCardID' => $faker->randomNumber(),
        'Code' => implode('', $faker->randomElements([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 9, 9, 9], 13)),
        'TransactionID' => $faker->randomNumber(),
        'name' => $faker->name,
        'gender' => $faker->randomElement([0, 1, 2]),
        'phone' => $faker->phoneNumber,
        'birthday_at' => $faker->dateTimeBetween('-70 years', '-18 years'),
        'verified' => $faker->boolean(),
    ];
});

$factory->define(App\Discount::class, function (Faker\Generator $faker) {

    $categories = App\Card::all();

    $DiscountCardIDs = $categories->pluck('DiscountCardID')->all();

    $volume = $faker->randomFloat(2, 10, 100);
    $price = $faker->randomFloat(2, 18, 35);

    return [
        'DiscountID' => $faker->randomNumber(),
        'DiscountCardID' => $faker->randomElement($DiscountCardIDs),
        'Date' => $faker->dateTimeThisMonth(),
        'Volume' => $volume,
        'Price' => $price,
        'Amount' => number_format($volume * $price, 2, '.', ''),
        'FuelName' => $faker->randomElement(['Аи92', 'Аи95', 'Аи98', 'ДТ', 'ДТев', 'СУГ']),
        'AZSCode' => $faker->numberBetween(1, 30),
    ];
});

//factory(App\Card::class, 100)->create();
//factory(App\Discount::class, 1000)->create();