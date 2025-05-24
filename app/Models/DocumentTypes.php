<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTypes extends Model
{
    protected $table = 'document_types';
    public $document_types = 'document_types';
    protected $fillable = [
        'name',
        'status',
    ];
    public function documentFinalReport()
    {
        return $this->hasMany(DocumentFinalReport::class);
    }
}
