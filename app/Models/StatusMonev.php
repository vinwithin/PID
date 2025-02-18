<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusMonev extends Model
{
    protected $table = 'status_monev';
    public $status_monev = 'status_monev';
    protected $fillable = [
        'user_id',
        'registration_id',
        'status',
        'catatan',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
