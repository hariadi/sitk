<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['pemohon', 'pelulus', 'pentadbir'] as $key => $user) {

            $role_id = $key+1;

            User::create([
                'name' => ucfirst($user),
                'email' => $user . '@jpnin.gov.my',
                'ic' => $this->generateIc(12),
                'role_id' => $role_id,
                'password' => bcrypt($user),
                'remember_token' => str_random(10),
            ]);
        }

    }

    protected function generateIc($length) {
        $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }
}

