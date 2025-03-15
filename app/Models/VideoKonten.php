<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoKonten extends Model
{
    protected $table = 'konten_video';
    public $konten_video = 'konten_video';
    protected $fillable = [
        'created_by',
        'media_dokumentasi_id',
        'link_youtube',
        'visibilitas'
    ];
    public function album_photos()
    {
        return $this->hasMany(AlbumPhotos::class);
    }
    public function dokumentasi_kegiatan()
    {
        return $this->hasOne(DokumentasiKegiatan::class, 'id');
    }
}
