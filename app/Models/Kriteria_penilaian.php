<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria_penilaian extends Model
{
    protected $table = 'kriteria_penilaian';
    public $kriteria_penilaian = 'kriteria_penilaian';
    protected $fillable = [
        'nama',
        'bobot',
    ];
    public function sub_kriteria_penilaian()
    {
        return $this->hasMany(Sub_kriteria_penilaian::class);
    }
}
