<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'surname' => 'Admin',
            'name' => 'Admin',
            'patronymic' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('thmmrg1124'),
            'role' => 'admin',
        ]);

        User::create([
            'surname' => 'Student',
            'name' => 'Student',
            'patronymic' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('thmmrg1124'),
            'role' => 'student',
        ]);

        User::create([
            'surname' => 'Teacher',
            'name' => 'Teacher',
            'patronymic' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('thmmrg1124'),
            'role' => 'teacher',
        ]);

        User::create([
            'surname' => 'Organ',
            'name' => 'Organ',
            'patronymic' => 'Organ',
            'email' => 'organ@example.com',
            'password' => Hash::make('thmmrg1124'),
            'role' => 'organ',
        ]);

    }
}
