<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logbookValidations extends Model
{
    protected $table = 'logbook_validations';
    public $logbook_validations = 'logbook_validations';
    protected $fillable = [
        'logbook_id',
        'validated_by',
        'role',
        'status',
    ];
    public function logbook()
    {
        return $this->belongsTo(Logbook::class, 'logbook_id');
    }
}
