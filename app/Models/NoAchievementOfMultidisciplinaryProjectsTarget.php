<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoAchievementOfMultidisciplinaryProjectsTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'name_of_project_initiated',
        'other_disciplines_engaged',
        'partner_industry',
        'identified_public_sector_entity',
        'completion_time_of_project',
        'product_developed',
        'third_party_validation',
        'ip_claim',
        'provide_details',
        'target_of_projects',
        'target_of_faculties',
        'form_status',
        'status',
        'created_by',
        'updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
