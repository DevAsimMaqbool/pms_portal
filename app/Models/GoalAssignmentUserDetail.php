<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalAssignmentUserDetail extends Model
{
    protected $fillable = [
        'goal_assignment_id',
        'goal_assignment_detail_id',
        'user_id',
        'target_achieved',
        'remarks',
        'status',
    ];

    public function assignment()
    {
        return $this->belongsTo(GoalAssignment::class, 'goal_assignment_id');
    }

    public function detail()
    {
        return $this->belongsTo(
            GoalAssignmentDetail::class,
            'goal_assignment_detail_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
