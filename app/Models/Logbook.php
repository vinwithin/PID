<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbooks';
    public $logbooks = 'logbooks';
    protected $fillable = [
        'team_id',
        'date',
        'description',
        'status',
        'link_bukti',
    ];
    public function teamMembers()
    {
        return $this->belongsTo(TeamMember::class, 'team_id');
    }
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'team_id');
    }
    public function logbook_validations()
    {
        return $this->hasOne(logbookValidations::class, 'logbook_id');
    }
}

