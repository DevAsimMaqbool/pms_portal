<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustrialProjects extends Model
{
    protected $fillable = [
        'indicator_id',
        'form_status',
        'project_name',
        'contracting_industry',
        'project_duration',
        'estimated_project_cost',
        'estimated_complection',
        'attachment',
        'status',
        'created_by',
        'updated_by',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
