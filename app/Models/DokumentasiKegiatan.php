<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiKegiatan extends Model
{
    protected $table = 'media_dokumentasi';
    public $media_dokumentasi = 'media_dokumentasi';
    protected $fillable = [
        'link_youtube',
        'link_social_media',
        'link_dokumentasi',
    ];
}
