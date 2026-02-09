<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedIncidentCompliance extends Model
{
    protected $fillable = [
        'indicator_id',
        'total_reported_incidents',
        'academic_misconduct_cases',
        'administrative_breaches',
        'governance_protocol_violations',
        'severity_level',
        'evidence_case_reference',
        'remarks',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
