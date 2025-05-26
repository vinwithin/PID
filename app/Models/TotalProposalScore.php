<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalProposalScore extends Model
{
    protected $table = 'total_proposal_scores';
    public $total_proposal_scores = 'total_proposal_scores';
    protected $fillable = [
        'registration_id',
        'user_id',
        'total',
    ];
    public function sub_kriteria_penilaian()
    {
        return $this->belongsTo(Sub_kriteria_penilaian::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
