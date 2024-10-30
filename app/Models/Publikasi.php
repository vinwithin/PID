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
        'status',
        'content',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
