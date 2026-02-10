<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicGovernanceCompliance extends Model
{
    protected $fillable = [
        'indicator_id',
        'total_scheduled_activities',
        'activities_conducted_as_scheduled',
        'missed_activities',
        'evidence_reference',
        'remarks',
        'compliance_percentage',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
