<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    public $bidang = 'bidang';
    protected $fillable = [
        'nama'
    ];
}
