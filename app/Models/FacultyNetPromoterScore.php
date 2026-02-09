<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyNetPromoterScore extends Model
{
    protected $fillable = [
        'indicator_id',
        'total_faculty_surveyed',
        'number_of_promoters',
        'number_of_passives',
        'number_of_detractors',

        'evidence_reference',
        'remarks',

        'promoters_percentage',
        'detractors_percentage',
        'net_promoter_score',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
