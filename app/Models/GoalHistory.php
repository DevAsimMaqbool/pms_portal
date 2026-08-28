<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalHistory extends Model
{
    protected $table = 'goal_histories';

    protected $fillable = [
        'new_goal_id',
        'user_id',
        'action',
        'from_status',
        'to_status',
        'comments',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function goal()
    {
        return $this->belongsTo(
            NewGoal::class,
            'goal_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}