<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $table = 'deadlines';
    public $deadlines = 'deadlines';
    protected $fillable = [
        'nama_dokumen',
        'dibuka',
        'ditutup',
    ];
}
