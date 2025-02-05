<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Test Admin',
            'email' => 'test@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => 1,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Test User 1',
            'email' => 'test@user1.com',
            'password' => Hash::make('password'),
            'is_admin' => 0,
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Test User 2',
            'email' => 'test@user2.com',
            'password' => Hash::make('password'),
            'is_admin' => 0,
            'remember_token' => Str::random(10),
        ]);
    }
}
