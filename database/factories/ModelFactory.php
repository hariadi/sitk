<?php

use Carbon\Carbon;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Role::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->randomElement(['Pemohon','Pengurus','Pentadbir']),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'ic' => $faker->randomNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => function () {
            return factory(App\Role::class)->create()->id;
        },
    ];
});

$factory->define(App\Vehicle::class, function (Faker\Generator $faker) {

    return [
        'registration_no' => $faker->randomNumber,
        'types' => $faker->randomElement([
            'Car',
            'Bus',
            'Van',
            'Coaster'
        ]),
        'model' => $faker->randomElement([
            'Proton Inspira',
            'Proton Waja',
            'Proton Wira',
            'Hilux'
        ]),
        'image' => $faker->md5 . '.jpg',
        'capacity' => $faker->numberBetween(1, 100),
    ];
});

$factory->define(App\Driver::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'phone' => $faker->PhoneNumber,
        'email' => $faker->unique()->safeEmail,
        'image' => $faker->md5 . '.jpg',
    ];
});

$factory->define(App\Reservation::class, function (Faker\Generator $faker) {

    $start_at = Carbon::now()->startOfDay()->addHours(8);

    return [
        'reason' => $faker->sentence,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'start_at' => $start_at,
        'end_at' => $start_at->copy()->addHours(8),
        'destination' => $faker->address
    ];
});

$factory->state(App\Reservation::class, 'rejected', function ($faker) {
    return [
        'approver_id' => function () {
            return factory(App\User::class)->create(['role_id' => 2])->id;
        },
        'approved_at' => Carbon::now(),
        'status' => 'Ditolak',
        'notes' => 'Ketiadaan Pemandu',
    ];
});

$factory->state(App\Reservation::class, 'approved', function ($faker) {
    return [
        'approver_id' => function () {
            return factory(App\User::class)->create(['role_id' => 2])->id;
        },
        'approved_at' => Carbon::now(),
        'driver_id' => function () {
            return factory(App\Driver::class)->create()->id;
        },
        'vehicle_id' => function () {
            return factory(App\Vehicle::class)->create()->id;
        },
        'status' => 'Lulus',
    ];
});
