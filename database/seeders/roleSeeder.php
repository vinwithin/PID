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
        $user1 = User::Create(
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make("user123"),
            ]
        );
        $user2 = User::Create(
            [
                'name' => 'reviewer',
                'email' => 'reviewer@gmail.com',
                'password' => Hash::make("reviewer123"),
            ],
        );
        $user3 = User::Create(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make("admin123"),
            ]
        );


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
        $role4 = Role::updateOrCreate(
            ['name' => 'dosen'], // Kondisi untuk mencari data
            ['name' => 'dosen']  // Data yang ingin dibuat atau diperbarui
        );

        $permission1 = Permission::updateOrCreate(
            ['name' => 'register program'],
            ['name' => 'register program'],
        );
        $permission2 = Permission::updateOrCreate(
            ['name' => 'create publication'],
            ['name' => 'create publication'],
        );
        $permission3 = Permission::updateOrCreate(
            ['name' => 'delete publication'],
            ['name' => 'delete publication'],
        );
        $permission4 = Permission::updateOrCreate(
            ['name' => 'edit publication'],
            ['name' => 'edit publication'],
        );
        $permission5 = Permission::updateOrCreate(
            ['name' => 'agree publication'],
            ['name' => 'agree publication'],
        );
        $permission6 = Permission::updateOrCreate(
            ['name' => 'assessing proposal'],
            ['name' => 'assessing proposal'],
        );
        $permission10 = Permission::updateOrCreate(
            ['name' => 'approve proposal'],
            ['name' => 'approve proposal'],
        );
        $permission7 = Permission::updateOrCreate(
            ['name' => 'monitoring dan evaluasi'],
            ['name' => 'monitoring dan evaluasi'],
        );
        $permission8 = Permission::updateOrCreate(
            ['name' => 'reviewer monev'],
            ['name' => 'reviewer monev'],
        );
        $permission9 = Permission::updateOrCreate(
            ['name' => 'show final report'],
            ['name' => 'show final report'],
        );
        $permission11 = Permission::updateOrCreate(
            ['name' => 'manage monev'],
            ['name' => 'manage monev'],
        );
        $permission12 = Permission::updateOrCreate(
            ['name' => 'show monev'],
            ['name' => 'show monev'],
        );
        $user1->assignRole('mahasiswa');
        $user2->assignRole('reviewer');
        $user3->assignRole('admin');
        $role1->givePermissionTo($permission1, $permission2, $permission4, $permission9);
        $role2->givePermissionTo($permission6, $permission9, $permission12);
        $role3->givePermissionTo($permission2, $permission3, $permission4, $permission5, $permission7, $permission9, $permission10, $permission11);
        $role4->givePermissionTo($permission8, $permission9);
        // $role1->givePermissionTo($permission2);
    }
}
