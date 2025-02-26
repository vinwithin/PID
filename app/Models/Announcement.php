<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';
    public $announcements = 'announcements';
    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'status',
        'created_by'
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'id', 'created_by');
    }
}
