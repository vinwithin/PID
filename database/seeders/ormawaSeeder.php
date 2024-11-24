<?php

namespace Database\Seeders;

use App\Models\Ormawa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ormawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ormawa::create([
            'nama' => 'UKM Pecinta Alam'
        ]);
        Ormawa::create([
            'nama' => 'UKM PMI'
        ]);
        Ormawa::create([
            'nama' => 'UKM Paduan Suara'
        ]);
        Ormawa::create([
            'nama' => 'UKM Tari'
        ]);
        Ormawa::create([
            'nama' => 'UKM Rohis'
        ]);
        Ormawa::create([
            'nama' => 'BEM'
        ]);
        Ormawa::create([
            'nama' => 'HIMASI'
        ]);
    }
}
