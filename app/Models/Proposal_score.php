<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal_score extends Model
{
    protected $table = 'proposal_score';
    public $proposal_score = 'proposal_score';
    protected $fillable = [
        'user_id',
        'registration_id',
        'sub_kriteria_penilaian_id',
        'nilai',
    ];
    public function sub_kriteria_penilaian(){
        return $this->belongsTo(Sub_kriteria_penilaian::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
