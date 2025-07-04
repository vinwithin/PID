<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKemajuan extends Model
{
     protected $table = 'laporan_kemajuan';
    public $laporan_kemajuan = 'laporan_kemajuan';
    protected $fillable = [
        'team_id',
        'file_path',
        'status',
        'komentar',
    ];
    public function teamMembers()
    {
        return $this->belongsTo(TeamMember::class, 'team_id');
    }
     public function registration()
    {
        return $this->belongsTo(Registration::class, 'team_id');
    }
}
