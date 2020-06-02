<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
            'name'=>"Ramesh",
            "email"=>"ramesh.paig@outlook.com",
            "password"=>Hash::make("Happy!@#")
        ]);


    }
}
