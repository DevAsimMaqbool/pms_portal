<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEngagementRate extends Model
{
    protected $fillable = [
        'indicator_id',
        'stakeholder_category',
        'nature_of_activity',
        'activity_location',
        'title_of_activity',
        'brief_description_of_activity',
        'date_of_activity',
        'partner_organization',
        'total_number_of_faculty_in_department',
        'number_of_faculty_participated',
        'total_number_of_staff_in_office',
        'number_of_staff_participated',
        'total_number_of_students_in_program',
        'number_of_students_participated',
        'typ_of_impact_achieved',
        'evidence_of_impact_available',
        'declaration',
        'employer_satisfaction',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
     protected $casts = [
        'stakeholder_category' => 'array',
        'activity_location' => 'array',
        'typ_of_impact_achieved' => 'array',
        'evidence_of_impact_available' => 'array',
        'declaration' => 'boolean',
    ];
}
