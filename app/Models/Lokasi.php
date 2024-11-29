<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    public $lokasi = 'lokasi';
    protected $fillable = [
        'regency',
        'district',
        'village',
    ];
}
