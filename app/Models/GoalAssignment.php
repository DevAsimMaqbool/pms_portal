<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalAssignment extends Model
{
    protected $fillable = [
        'role_id',
        'goal_id',
        'kpa_id',
        'kpa_cid',
        'validate',
        'status',
        'created_by',
        'updated_by'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }
    // KPA Relation
    public function kpa()
    {
        return $this->belongsTo(KeyPerformanceArea::class, 'kpa_id', 'id');
    }
    public function kpa_indicator()
    {
        return $this->belongsTo(IndicatorCategory::class, 'kpa_cid', 'id');
    }
    public function users()
    {
        return $this->hasMany(GoalAssignmentUser::class, 'goal_assignment_id');
    }
    public function details()
    {
        return $this->hasMany(GoalAssignmentDetail::class, 'goal_assignment_id');
    }

}
