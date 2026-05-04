<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchConferenceImpact extends Model
{
    protected $fillable = [
        'indicator_id',
        'conference_name',
        'conference_theme',
        'conference_date',
        'conference_venue',
        'conference_scope',
        'scopus_indexing',
        'national_participants',
        'international_participants',
        'industry_participants',
        'scholarly_impact',
        'industry_engagement',
        'international_participation',
        'indexing_recognition',
        'overall_remarks',
        'nature_of_partner',
        'partner_institute',
        'partner_country',

        'form_status',
        'status',
        'reject_status',
        'reject_status_remarks',
        'update_history',
        'created_by',
        'updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
    public function participants()
    {
        return $this->hasMany(ResearchConferenceParticipant::class,'research_conference_impact_id');
    }
}
