<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoKonten extends Model
{
    protected $table = 'konten_video';
    public $konten_video = 'konten_video';
    protected $fillable = [
        'team_id',
        'media_dokumentasi_id',
        'link_youtube',
    ];
    public function album_photos()
    {
        return $this->hasMany(AlbumPhotos::class);
    }
}
