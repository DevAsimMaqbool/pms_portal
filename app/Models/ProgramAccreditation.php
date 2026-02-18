<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramAccreditation extends Model
{
    protected $table = 'no_of_programs_accredited';
    protected $fillable = [
        'indicator_id',
        'form_status',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'recognition_type',
        'accrediting',
        'accrediting_other_detail',
        'affiliated_body_name',
        'affiliated_for',
        'scope',
        'status',
        'validity_from',
        'validity_to',
        'university_ranking',
        'ranking_position',
        'evidence_available',
        'document_link',
        'remarks',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
}
