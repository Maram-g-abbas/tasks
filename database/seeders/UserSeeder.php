<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'=> 'admin',
            'email'=> 'admin@gmail.com',
            'password' => '123456'
        ]);
        $admin -> assignRole('admin');
        $editor = User::create([
            'name'=> 'editor',
            'email'=> 'editor@gmail.com',
            'password' => '123456'
        ]);
        $editor -> assignRole('editor');
        $user = User::create([
            'name'=> 'user',
            'email'=> 'user@gmail.com',
            'password' => '123456'
        ]);
        $user -> assignRole('user');
    }
}
