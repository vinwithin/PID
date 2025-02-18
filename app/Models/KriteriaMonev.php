<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaMonev extends Model
{
    protected $table = 'kriteria_monev';
    public $kriteria_penilaian = 'kriteria_monev';
    protected $fillable = [
        'nama',
        'deskripsi',
        'bobot',
    ];
    public function score_monev(){
        return $this->hasMany(ScoreMonev::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
