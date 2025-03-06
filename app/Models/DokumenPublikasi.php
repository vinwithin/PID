<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPublikasi extends Model
{
    protected $table = 'dokumen_publikasi';
    public $dokumen_publikasi = 'dokumen_publikasi';
    protected $fillable = [
        'team_id',
        'file_artikel',
        'judul_artikel',
        'visibilitas',
        'status_artikel',
        'link_artikel',
        'file_haki',
        'status_haki',
        'status',
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
