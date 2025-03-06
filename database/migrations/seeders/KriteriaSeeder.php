<?php

namespace Database\Seeders;

use App\Models\Kriteria_penilaian;
use App\Models\Sub_kriteria_penilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kriteria_penilaian::create([
            'nama' => "Perumusan Masalah dan Tujuan",
            'bobot' => 30,
        ]);
        Kriteria_penilaian::create([
            'nama' => "Potensi Keberhasilan Program",
            'bobot' => 45,
        ]);
        Kriteria_penilaian::create([
            'nama' => "Potensi Keberlanjutan Program",
            'bobot' => 20,
        ]);
        Kriteria_penilaian::create([
            'nama' => "Hal-hal lain yang dinilai unggul",
            'bobot' => 5,
        ]);

        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 1,
            'nama' => "Ketepatan identifikasi masalah (dari data sekunder, informasi, hasil observasi lapangan)",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 1,
            'nama' => "Kecermatan dalam merumuskan masalah",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 1,
            'nama' => "Kemudahan pengukuran pencapaian tujuan",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 2,
            'nama' => "Ketepatan dalam merencanakan khalayak sasaran (jumlah, keragaman dan keterwakilan jangkauan wilayah)",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 2,
            'nama' => "Ketepatan dalam memilih bentuk intervensi pembinaan yang efektif, termasuk tingkat kesesuaian dan kelayakan inovasi",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 2,
            'nama' => "Ketepatan dalam memilih metode pengembangan masyarakat yang partisipatif.",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 2,
            'nama' => "Ketepatan perumusan indikator keberhasilan dan pengukurannya",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 2,
            'nama' => "Dukungan kelembagaan desa dan perguruan tinggi",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 2,
            'nama' => "Kekuatan kompetensi dan jejaring kelembagaan mahasiswa yang relevan dengan program.",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 3,
            'nama' => "Adanya rencana kegiatan pembinaan pasca program yang terukur dan kolaboratif.",
        ]);
        Sub_kriteria_penilaian::create([
            'kriteria_penilaian_id' => 3,
            'nama' => "Kekuatan kompetensi dan jejaring kelembagaan mahasiswa yang relevan dengan program.",
        ]);
    }
}
