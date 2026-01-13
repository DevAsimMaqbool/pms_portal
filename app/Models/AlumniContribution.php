<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniContribution extends Model
{

    protected $fillable = [
        'indicator_id',
        'form_status',
        'academic_year',
        'alumni_name',
        'graduation_year',
        'faculty_id',
        'type_of_contribution',
        'description_of_contribution',
        'date_of_contribution',
        'evidence_upload',
        'contribution_verified_by',
        'verification_status',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
}
