<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewAccessMonev extends Model
{
    protected $table = 'reviewer_access_monev';
    public $reviewer_access_monev= 'reviewer_access_monev';
    protected $fillable = [
        'reviewer_id',
        'pendaftaran_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
