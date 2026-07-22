<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalAssignmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_assignment_id',
        'goal_id',
        'objective_id',
        'dimension_id',
        'dimension_target',
        'dimension_weight',
    ];
    public function assignment()
    {
        return $this->belongsTo(GoalAssignment::class, 'goal_assignment_id');
    }
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
    public function objective()
    {
        return $this->belongsTo(Objective::class, 'objective_id');
    }
    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'dimension_id');
    }
    public function indicators()
    {
        return $this->hasMany(GoalAssignmentIndicator::class, 'goal_assignment_detail_id','id');
    }
    
}
