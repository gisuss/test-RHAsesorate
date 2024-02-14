<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
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
        $user = User::create([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'password'  =>  Hash::make('password'),
            'username' => 'admin',
            'email_verified_at' => Carbon::now(),
        ]);
        $user->assignRole('Admin');

        $user2 = User::create([
            'name' => 'User',
            'lastname' => 'Test',
            'email' => 'user@example.com',
            'password'  =>  Hash::make('password'),
            'username' => 'utest',
            'email_verified_at' => Carbon::now(),
        ]);
        $user2->assignRole('Client');
    }
}
