<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'aliffnazrii',
            'email' => 'aliff.nazri9@gmail.com',
            'password' => Hash::make('aliffnazrii'), // Make sure to hash the password
            'phone' => '0189839423',
            'role' => 'owner',
            'address' => '123 Default St',
            'postcode' => '12345',
            'city' => 'Default City',
            'state' => 'Default State',
            'picture'=>'',
        ]);
    }
}
