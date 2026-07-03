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
    public function employee() { return $this->belongsTo( User::class, 'employee_id', 'id' ); }
    // ========================================= // KPA RELATION // ========================================= 
    public function kpa() { return $this->belongsTo( KeyPerformanceArea::class, 'kpa_id', 'id' ); }
     // ========================================= // KPI CATEGORY RELATION // ========================================= 
     public function kpi() { return $this->belongsTo( IndicatorCategory::class, 'kpi_id', 'id' ); } 
     // ========================================= // INDICATOR RELATION // ========================================= 
     public function indicator() { return $this->belongsTo( Indicator::class, 'indicator_id', 'id' ); }
     // ========================================= // Goal // ========================================= 
     public function goal() { return $this->belongsTo( Goal::class, 'goal_id', 'id' ); }

}
