<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiKegiatan extends Model
{
    protected $table = 'media_dokumentasi';
    public $media_dokumentasi = 'media_dokumentasi';
    protected $fillable = [
        'team_id',
        'link_youtube',
        'link_social_media',
        'link_dokumentasi',
    ];
    public function teamMembers()
    {
        return $this->belongsTo(TeamMember::class, 'team_id');
    }
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'team_id');
    }
    public function album()
    {
        return $this->hasOne(Album::class, 'media_dokumentasi_id');
    }
    public function video_konten()
    {
        return $this->hasOne(VideoKonten::class, 'media_dokumentasi_id');
    }
}
