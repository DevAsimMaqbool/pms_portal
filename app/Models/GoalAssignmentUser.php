<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoalAssignmentUser extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'goal_assignment_id',
        'user_id',
    ];
    public function assignment()
    {
        return $this->belongsTo(GoalAssignment::class, 'goal_assignment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
