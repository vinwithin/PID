<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';
    public $registration = 'registration';
    protected $fillable = [
        'nama'
    ];
}
