<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramProfitability extends Model
{
    protected $fillable = [
        'indicator_id',
        'financial_year',
        'faculty_id',
        'program_id',
        'program_level',
        'total_program_income',
        'faculty_cost',
        'facilities_cost',
        'materials_cost',
        'support_services_cost',
        'other_costs',
        'evidence_reference',
        'remarks',
        'total_cost_of_delivery',
        'net_program_surplus_deficit',
        'program_profitability_status',
        'profitability_percentage',
        'total_programs_assessed',
        'number_of_profitable_programs',
        'proportion_of_profitable_programs',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
