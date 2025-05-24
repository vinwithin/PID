<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFinalReport extends Model
{
    protected $table = 'document_final_reports';
    public $document_final_reports = 'document_final_reports';
    protected $fillable = [
        'team_id',
        'document_type_id',
        'content',
        'publish_status',
        'status',
        'komentar',
    ];
    public function teamMembers()
    {
        return $this->belongsTo(TeamMember::class, 'team_id');
    }
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'team_id');
    }
    public function documentType()
    {
        return $this->belongsTo(DocumentTypes::class, 'document_type_id');
    }
}
