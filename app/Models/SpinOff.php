<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinOff extends Model
{
    use HasFactory;

    protected $table = 'spin_offs';

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'name_of_faculty_member',
        'spin_off_form_submission',
        'status_of_spin_off_feasibility',
        'work_plan_for_the_spin_off',
        'name_of_pre_spin_off',
        'total_revenue_generated',
        'annual_revenue_generated',
        'rev_current_financial_year',
        'target_of_new_spin_offs',
        'target_of_pre_spin_offs',
        'name_of_lead_faculty_member',
        'created_by',
        'updated_by',
    ];
}
