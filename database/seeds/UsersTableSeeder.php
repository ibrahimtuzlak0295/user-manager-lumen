<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::count() < 1) {
            User::create([
                'username' => 'ibrahim',
                'password' => 'password',
                'first_name' => 'Ibrahim',
                'last_name' => 'Tuzlak',
                'address' => 'Trg',
                'zip' => 71000,
                'city' => 'Sa',
            ]);
        }
    }
}
