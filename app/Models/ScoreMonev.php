<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreMonev extends Model
{
    protected $table = 'score_monev';
    public $score_monev = 'score_monev';
    protected $fillable = [
        'user_id',
        'registration_id',
        'kriteria_monev_id',
        'nilai',
    ];
    public function kriteria_monev(){
        return $this->belongsTo(KriteriaMonev::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
