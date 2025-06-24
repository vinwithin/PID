<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewAccessProposal extends Model
{
    protected $table = 'reviewer_access_proposal';
    public $reviewer_access_proposal = 'reviewer_access_proposal';
    protected $fillable = [
        'reviewer_id',
        'pendaftaran_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
