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
        'reject_status',
        'reject_status_remarks',
        'update_history',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'update_history' => 'array',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
