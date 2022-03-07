<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Admin',
            'email' => 'admin@naivecms.com',
            'password' => '$2y$10$LUwatq7MEzeE3V6esoLNd.Jp4QRhQwinGQx9X.Dl6TVpC2bLUFx.m', //password is password
            'role_id' => '1',
        ]);
    }
    //php artisan db:seed --class=UsersSeeder
}
