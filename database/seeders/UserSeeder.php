<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) { // Buat 10 user
            $user = User::create([
                'name' => $faker->name,
                'nim' => $faker->optional()->numerify('20########'), // NIM opsional
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'), // Default password
            ]);
            $user->assignRole('dosen');
        }
    }
}
