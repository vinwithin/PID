<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';
    public $registration = 'registration';
    protected $fillable = [
        'user_id',
        'nama_ketua',
        'nim_ketua',
        'prodi_ketua',
        'fakultas_ketua',
        'nohp_ketua',
        'nama_ormawa',
        'judul',
        'bidang_id',
        'sk_organisasi',
        'surat_kerjasama',
        'surat_rekomendasi_pembina',
        'proposal',
        'nama_dosen_pembimbing',
        'nidn_dosen_pembimbing',
        'nohp_dosen_pembimbing'
    ];
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }
    public function proposal_score()
    {
        return $this->hasMany(Proposal_score::class);
    }
    public function registration_validation()
    {
        return $this->hasOne(Registrasi_validation::class);
    }
    public function lokasi()
    {
        return $this->hasOne(Lokasi::class, 'registration_id');
    }
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_ketua');
    }
    public function program_studi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_ketua');
    }
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class, 'nama_ormawa');
    }
    public function reviewAssignments()
    {
        return $this->hasMany(ReviewAssignment::class, 'registration_id');
    }
    public function dokumenTeknis()
    {
        return $this->hasOne(DokumenTeknis::class, 'team_id');
    }
    public function dokumenPublikasi()
    {
        return $this->hasOne(DokumenPublikasi::class, 'team_id');
    }
    public function dokumentasiKegiatan()
    {
        return $this->hasOne(DokumentasiKegiatan::class, 'team_id');
    }
    public function score_monev()
    {
        return $this->hasMany(ScoreMonev::class, 'registration_id');
    }
    public function status_monev()
    {
        return $this->hasMany(StatusMonev::class, 'registration_id');
    }
    public function laporan_kemajuan()
    {
        return $this->hasOne(LaporanKemajuan::class, 'team_id');
    }
}
