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
        $role5 = Role::updateOrCreate(
            ['name' => 'super admin'], // Kondisi untuk mencari data
            ['name' => 'super admin']  // Data yang ingin dibuat atau diperbarui
        );

        $permission1 = Permission::updateOrCreate(
            ['name' => 'register program'],
            ['name' => 'register program'],
        );
        
        //registration
        $permission2 = Permission::updateOrCreate(
            ['name' => 'read proposal'],
            ['name' => 'read proposal'],
        );
        $permission3 = Permission::updateOrCreate(
            ['name' => 'assessing proposal'],
            ['name' => 'assessing proposal'],
        );
        $permission4 = Permission::updateOrCreate(
            ['name' => 'approve proposal'],
            ['name' => 'approve proposal'],
        );
        //laporan kemajuan
        $permission5 = Permission::updateOrCreate(
            ['name' => 'read laporan kemajuan'],
            ['name' => 'read laporan kemajuan'],
        );
        $permission6 = Permission::updateOrCreate(
            ['name' => 'create laporan kemajuan'],
            ['name' => 'create laporan kemajuan'],
        );
        $permission7 = Permission::updateOrCreate(
            ['name' => 'update laporan kemajuan'],
            ['name' => 'update laporan kemajuan'],
        );
        $permission8 = Permission::updateOrCreate(
            ['name' => 'approve laporan kemajuan'],
            ['name' => 'approve laporan kemajuan'],
        );
        //monev
        $permission9 = Permission::updateOrCreate(
            ['name' => 'read monev'],
            ['name' => 'read monev'],
        );
        $permission10 = Permission::updateOrCreate(
            ['name' => 'assessing monev'],
            ['name' => 'assessing monev'],
        );
        $permission11 = Permission::updateOrCreate(
            ['name' => 'approve monev'],
            ['name' => 'approve monev'],
        );
        $permission12 = Permission::updateOrCreate(
            ['name' => 'assign-juri monev'],
            ['name' => 'assign-juri monev'],
        );
        //laporan akhir
        $permission13 = Permission::updateOrCreate(
            ['name' => 'read final report'],
            ['name' => 'read final report'],
        );
        $permission14 = Permission::updateOrCreate(
            ['name' => 'approve final report'],
            ['name' => 'approve final report'],
        );
        $permission15 = Permission::updateOrCreate(
            ['name' => 'create final report'],
            ['name' => 'create final report'],
        );
        $permission16 = Permission::updateOrCreate(
            ['name' => 'update final report'],
            ['name' => 'update final report'],
        );
        //publikasi
        $permission17 = Permission::updateOrCreate(
            ['name' => 'create publication'],
            ['name' => 'create publication'],
        );
        $permission18 = Permission::updateOrCreate(
            ['name' => 'read publication'],
            ['name' => 'read publication'],
        );
        $permission19 = Permission::updateOrCreate(
            ['name' => 'delete publication'],
            ['name' => 'delete publication'],
        );
        $permission20 = Permission::updateOrCreate(
            ['name' => 'edit publication'],
            ['name' => 'edit publication'],
        );
        $permission21 = Permission::updateOrCreate(
            ['name' => 'agree publication'],
            ['name' => 'agree publication'],
        );
       
       //superadmin
        $permission22 = Permission::updateOrCreate(
            ['name' => 'manage roles'],
            ['name' => 'manage roles'],
        );
        $permission23 = Permission::updateOrCreate(
            ['name' => 'create logbook'],
            ['name' => 'create logbook'],
        );
        $permission24 = Permission::updateOrCreate(
            ['name' => 'approve logbook'],
            ['name' => 'approve logbook'],
        );
       
        $user1->assignRole('mahasiswa');
        $user2->assignRole('reviewer');
        $user3->assignRole('admin');
        $role1->givePermissionTo($permission1, $permission5, $permission6, $permission7, $permission13, $permission15, $permission16, $permission17, $permission18, $permission20, $permission23);
        $role2->givePermissionTo($permission2, $permission3, $permission5, $permission9, $permission13, $permission18);
        $role3->givePermissionTo($permission2, $permission4, $permission5, $permission8, $permission9, $permission11, $permission12, $permission13, $permission14, $permission14, $permission17, $permission18, $permission19, $permission20, $permission21, $permission24);
        $role4->givePermissionTo($permission2, $permission5, $permission9, $permission10, $permission13, $permission18, $permission24);
        $role5->givePermissionTo($permission22);
        // $role1->givePermissionTo($permission2);
    }
}
