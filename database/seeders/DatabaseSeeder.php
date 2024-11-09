<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = User::Create(
            [
                'name' => 'kelvin adinata',
                'email' => 'kelvin@gmail.com',
                'password' => Hash::make("kelvin123"),
            ],
        );
        $user->assignRole('reviewer');
        
    }
}
