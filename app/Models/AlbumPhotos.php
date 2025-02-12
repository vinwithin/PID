<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumPhotos extends Model
{
    protected $table = 'album_photos';
    public $album_photos = 'album_photos';
    protected $fillable = [
        'album_id',
        'path_photos',
    ];
}
