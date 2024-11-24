<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    public $fakultas = 'fakultas';
    protected $fillable = [
        'nama'
    ];
}
