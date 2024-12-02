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
        //admin
        User::create([
            'name'=>'Administrator',
            'email'=>'admin@gmail.com',
            'role'=>'admin',
            'password'=>Hash::make('admin123')
        ]);
        //kasir
        User::create([
            'name'=>'kasir1',
            'email'=>'kasirapotek@gmail.com',
            'role'=>'kasir',
            'password'=>Hash::make('kasir123')
        ]);
    }
}
