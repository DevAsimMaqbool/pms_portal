<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialGainsCounsultancyResearchIncome extends Model
{
    protected $table = 'commercial_gains_counsultancy_research_incomes';
    protected $fillable = [
        'indicator_id',
        'form_status',
        'title_of_consultancy',
        'duration_of_consultancy',
        'name_of_client_organization',
        'consultancy_fee',
        'consultancy_file',
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
