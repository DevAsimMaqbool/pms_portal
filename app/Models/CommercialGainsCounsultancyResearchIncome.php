<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialGainsCounsultancyResearchIncome extends Model
{
    protected $table = 'commercial_gains_counsultancy_research_incomes';
    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'target_of_consultancy_projects',
        'target_of_industrial_projects',
        'no_of_consultancies_done',
        'title_of_consultancy',
        'duration_of_consultancy',
        'name_of_client_organization',
        'status',
        'created_by',
        'updated_by',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
    public function Projects()
    {
        return $this->hasMany(CommercialGainsCounsultancyResearchIncomeProject::class, 'consultancy_id');
    }
}
