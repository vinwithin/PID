<?php

namespace Database\Seeders;

use App\Models\KriteriaMonev;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaMonevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KriteriaMonev::create([
            'nama' => "Identifikasi Masalah",
            'deskripsi' => "Kesesuaian identifikasi permasalahan masyarakat dengan tujuan, metode dan luaran.",
            'bobot' => 20,
        ]);
        KriteriaMonev::create([
            'nama' => "Metode",
            'deskripsi' => "Keberhasilan metode.",
            'bobot' => 15,
        ]);
        KriteriaMonev::create([
            'nama' => "Ketercapaian Indikator Keberhasilan dan Target Luaran",
            'bobot' => 20,
        ]);
        KriteriaMonev::create([
            'nama' => "Kesesuaian Pelaksanaan",
            'deskripsi' => "Waktu, bahan, alat, metode yang digunakan, personalia, dan biaya",
            'bobot' => 10,
        ]);
        KriteriaMonev::create([
            'nama' => "Kekompakan",
            'deskripsi' => "Secara internal dan eksternal",
            'bobot' => 10,
        ]);
        KriteriaMonev::create([
            'nama' => "Peranan Dosen Pendamping",
            'deskripsi' => "Mengoreksi usulan, memantau pelaksanaan, melayani konsultasi",
            'bobot' => 5,
        ]);
        KriteriaMonev::create([
            'nama' => "Potensi Khusus",
            'deskripsi' => "Keberlanjutan program",
            'bobot' => 20,
        ]);
    }
}
