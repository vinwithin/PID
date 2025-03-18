<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenRegistrasi extends Model
{
    protected $table = 'document_registration';
    public $document_registration = 'document_registration';
    protected $fillable = [
        'registration_id',
        'sk_organisasi',
        'surat_kerjasama',
        'surat_rekomendasi_pembina',
        'proposal',
    ];
    
}
