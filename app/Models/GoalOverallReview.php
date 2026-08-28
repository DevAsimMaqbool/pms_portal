<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalOverallReview extends Model
{
    protected $table = 'goal_overall_reviews';

    protected $fillable = [
        'user_id',
        'reviewer_id',
        'manager_overall_rating',
        'hr_overall_rating',
        'decision',
        'comments',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Employee
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | HR Reviewer
    |--------------------------------------------------------------------------
    */

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}