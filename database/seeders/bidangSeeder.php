<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class bidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bidang::create([
            'nama' => 'Desa/Kelurahan Wirausaha'
        ]);
        Bidang::create([
            'nama' => 'Smart Farming'
        ]);
        Bidang::create([
            'nama' => 'Sekolah Perempuan'
        ]);
        Bidang::create([
            'nama' => 'Sanggar Tani Muda'
        ]);
        Bidang::create([
            'nama' => 'Kampung Konservasi Toga'
        ]);
        Bidang::create([
            'nama' => 'Rumah Sampah Digital'
        ]);
        Bidang::create([
            'nama' => 'Desa/Kelurahan Sehat'
        ]);
        Bidang::create([
            'nama' => 'Desa/Kelurahan Cerdas'
        ]);
        Bidang::create([
            'nama' => 'Kampung Iklim'
        ]);
        Bidang::create([
            'nama' => 'Desa/Kelurahan Maritim'
        ]);
        Bidang::create([
            'nama' => 'Desa Hutan'
        ]);
        Bidang::create([
            'nama' => 'Desa/Kelurahan Budaya'
        ]);
        Bidang::create([
            'nama' => 'Desa/Kelurahan Wisata'
        ]);
        Bidang::create([
            'nama' => 'Topik Bebas'
        ]);
    }
}
