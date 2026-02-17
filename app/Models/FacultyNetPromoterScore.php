<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyNetPromoterScore extends Model
{
    protected $fillable = [
        'indicator_id',
        'year',
        'total_faculty_surveyed',
        'number_of_promoters',
        'promoters_percentage',
        'remarks',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
