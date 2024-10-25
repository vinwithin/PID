<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';
    public $registration = 'registration';
    protected $fillable = [
        'user_id', 'nama_ketua', 'nim_ketua', 'prodi_ketua', 
        'fakultas_ketua', 'nohp_ketua', 'nama_ormawa', 'judul', 
        'bidang_id', 'sk_organisasi', 'surat_kerjasama', 
        'surat_rekomendasi_pembina', 'proposal',
        'nama_dosen_pembimbing', 'nidn_dosen_pembimbing', 'nohp_dosen_pembimbing'
    ];    
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }
}
