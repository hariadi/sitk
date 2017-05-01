<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['Pemohon', 'Pelulus', 'Pentadbir'] as $role) {
            Role::create([
                'title' => $role
            ]);
        }
    }
}
