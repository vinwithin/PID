<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make("user123"),
        ]);
        $user2 = User::factory()->create([
            'name' => 'reviewer',
            'email' => 'reviewer@gmail.com',
            'password' => Hash::make("reviewer123"),
        ]);
        $user3 = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("admin123"),
        ]);
       
        
        $role1 = Role::updateOrCreate(
            ['name' => 'mahasiswa'], // Kondisi untuk mencari data
            ['name' => 'mahasiswa']  // Data yang ingin dibuat atau diperbarui
        );
        $role2 = Role::updateOrCreate(
            ['name' => 'reviewer'], // Kondisi untuk mencari data
            ['name' => 'reviewer']  // Data yang ingin dibuat atau diperbarui
        );
        $role3 = Role::updateOrCreate(
            ['name' => 'admin'], // Kondisi untuk mencari data
            ['name' => 'admin']  // Data yang ingin dibuat atau diperbarui
        );

        $permission1 = Permission::updateOrCreate(
            ['name' => 'register program'],
            ['name' => 'register program'],
        );
        $user1->assignRole('mahasiswa');
        $user2->assignRole('reviewer');
        $user3->assignRole('admin');
        $role1->givePermissionTo($permission1);
    }
}
