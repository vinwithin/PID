<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use Sluggable;

    protected $table = 'berita';
    public $berita = 'berita';
    protected $fillable = [
        'created_by',
        'title',
        'slug',
        'thumbnail',
        'content',
        'excerpt'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function user()
    {
        return $this->hasMany(User::class, 'id', 'created_by');
    }
}
