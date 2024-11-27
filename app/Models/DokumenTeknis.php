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
        'file_bukti_publikasi',
        'status_publikasi',
        'file_proposal',
        'file_laporan_keuangan',
    ];
}
