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
        // $user1 = User::updateOrCreate(
        //     [
        //         'email' => 'user@gmail.com',
        //     ],
        //     [
        //         'name' => 'user',
        //         'email' => 'user@gmail.com',
        //         'password' => Hash::make("user123"),
        //     ],
        // );
        // $user2 = User::updateOrCreate(
        //     [
        //         'email' => 'reviewer@gmail.com',
        //     ],
        //     [
        //         'email' => 'reviewer@gmail.com',
        //     ],
        // );
        // $user3 = User::updateOrCreate(
        //     [
        //         'name' => 'admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make("admin123"),
        //     ],
        //     [
        //         'name' => 'admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make("admin123"),
        //     ]
        // );


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
        // $user1->assignRole('mahasiswa');
        // $user2->assignRole('reviewer');
        // $user3->assignRole('admin');
        $role1->givePermissionTo($permission1, $permission2, $permission4);
        $role3->givePermissionTo($permission2, $permission3, $permission4);
        // $role1->givePermissionTo($permission2);
    }
}
