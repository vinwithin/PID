<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_kriteria_penilaian extends Model
{
    protected $table = 'sub_kriteria_penilaian';
    public $sub_kriteria_penilaian = 'sub_kriteria_penilaian';
    protected $fillable = [
        'kriteria_penilaian_id',
        'nama',
    ];
    public function kriteria_penilaian()
    {
        return $this->belongsTo(Kriteria_penilaian::class);
    }
}
