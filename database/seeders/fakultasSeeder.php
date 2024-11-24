<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class fakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fakultas::create([
            'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'
        ]);
        Fakultas::create([
            'nama' => 'Fakultas Hukum'
        ]);
        Fakultas::create([
            'nama' => 'Fakultas Ekonomi dna Bisnis'
        ]);
        Fakultas::create([
            'nama' => 'Fakultas Pertanian'
        ]);
        Fakultas::create([
            'nama' => 'Fakultas Peternakan'
        ]);
        Fakultas::create([
            'nama' => 'Fakultas Kedokteran dan Ilmu Kesehatan'
        ]);
        Fakultas::create([
            'nama' => 'Fakultas Sains dan Teknologi'
        ]);
    }
}
