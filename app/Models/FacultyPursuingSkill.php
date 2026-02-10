<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class FacultyPursuingSkill extends Model
{
    use HasFactory;

    protected $table = 'faculty_pursuing_skills';

    protected $fillable = [
        'indicator_id',
        'total_faculty',
        'faculty_in_cpd_activities',
        'cpd_type',
        'evidence_reference',
        'remarks',
        'faculty_cpd_percentage',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'cpd_type' => 'array',
    ];
}
