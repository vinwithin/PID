<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';
    public $team_members = 'team_members';
    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'fakultas',
        'jabatan'
    ];
}
