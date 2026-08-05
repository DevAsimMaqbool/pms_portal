<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchTaskAssignedHodDean extends Model
{
     //
    protected $table = 'research_task_assigned_hod_deans';
    protected $fillable = [
        'indicator_id',
        'employee_id',
        'year',
        'kpa_category',
        'remarks',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];

    public function tasks()
    {
        return $this->hasMany(ResearchTaskAssignedHodDeanTask::class, 'research_task_assigned_hod_dean_id');
    }
}
