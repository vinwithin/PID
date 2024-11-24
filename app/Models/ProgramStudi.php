<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';
    public $program_studi = 'program_studi';
    protected $fillable = [
        'nama'
    ];
}
