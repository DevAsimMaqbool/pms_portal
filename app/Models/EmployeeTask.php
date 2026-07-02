<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
     protected $fillable = [

        'task_date',
        'task_title',
        'task_description',
        'planned_type',
        'planned_start_date',
        'planned_end_date',
        'actual_start_time',
        'actual_end_time',
        'hours_worked',
        'estimated_hours',
        'location',
        'kpa_id',
        'kpi_id',
        'indicator_id',
        'goal_id',
        'self_completion',
        'manager_completion',
        'status',
        'output_deliverables',
        'employee_id',
        'nature_of_task',
        'priority',
        'ownership',
        'attachment',
        'task_status',
        'reject_status',
        'reject_status_remarks',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
