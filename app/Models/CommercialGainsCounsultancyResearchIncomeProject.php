<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialGainsCounsultancyResearchIncomeProject extends Model
{
    protected $table = 'commercial_gains_counsultancy_research_income_project';
    protected $fillable = [
        'consultancy_id',
        'no_of_projects',
        'name_of_project',
        'name_of_contracting_industry',
        'total_duration_of_project',
        'estimate_cost_project',
        'completion_year',
        'created_by',
        'updated_by',
        
    ];
    public function consultancy()
    {
        return $this->belongsTo(CommercialGainsCounsultancyResearchIncome::class, 'consultancy_id');
    }
   
}
