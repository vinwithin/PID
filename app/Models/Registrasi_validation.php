<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi_validation extends Model
{
    protected $table = 'registration_validation';
    public $registration_validation = 'registration_validation';
    protected $fillable = [
        'status',
        'catatan',
        'validator_id',
    ];
}
