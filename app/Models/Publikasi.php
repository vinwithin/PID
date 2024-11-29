<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Publikasi extends Model
{
    use Sluggable;

    
    protected $table = 'publikasi';
    public $publikasi = 'publikasi';
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'status',
        'content',
        'excerpt',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function teamMembers()
    {
        return $this->belongsTo(TeamMember::class, 'team_id');
    }
}
