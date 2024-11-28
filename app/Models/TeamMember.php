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
    public function fakultas_model()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas');
    }
    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi');
    }
    public function registration()
    {
        return $this->hasMany(Registration::class);
    }
    public function user()
    {
        return $this->hasMany(User::class, 'nim');
    }
   
}
