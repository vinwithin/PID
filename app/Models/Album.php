<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'album';
    public $album = 'album';
    protected $fillable = [
        'nama',
        'status'
    ];
    public function album_photos()
    {
        return $this->hasMany(AlbumPhotos::class);
    }
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'team_id');
    }
}
