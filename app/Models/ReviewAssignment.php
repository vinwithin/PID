<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewAssignment extends Model
{
    protected $table = 'review_assignments';
    public $review_assignments = 'review_assignments';
    protected $fillable = [
        'reviewer_id',
        'registration_id',
        'status',
        'feedback',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
