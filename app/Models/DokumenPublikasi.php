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
        'status_artikel',
        'link_artikel',
        'file_haki',
        'status_haki',
    ];
}
