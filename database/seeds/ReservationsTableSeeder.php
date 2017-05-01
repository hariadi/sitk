<?php

use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 3 pending reservation
        factory(App\Reservation::class, 3)->create();
        factory(App\Reservation::class, 2)->create(['user_id' => 1]);

        // Create 5 approved reservation
        factory(\App\Reservation::class, 10)->states('approved')->create();
        factory(\App\Reservation::class, 5)->states('approved')->create(['user_id' => 1]);

        // Create 2 rejected reservation
        factory(\App\Reservation::class, 2)->states('rejected')->create();
        factory(\App\Reservation::class, 1)->states('rejected')->create(['user_id' => 1]);
    }
}
