<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenTeknis extends Model
{
    protected $table = 'dokumen_teknis';
    public $dokumen_teknis = 'dokumen_teknis';
    protected $fillable = [
        'team_id',
        'file_manual',
        'status_manual',
        'file_proposal',
        'file_laporan_keuangan',
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
