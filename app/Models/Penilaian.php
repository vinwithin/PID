<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';
    public $penilaian = 'penilaian';
    protected $fillable = [
        'user_id',
        'registration_id',
        'nilai',
    ];
}
