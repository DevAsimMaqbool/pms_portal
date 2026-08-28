<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalSelfReport extends Model
{
    protected $table = 'goal_self_reports';

    protected $fillable = [
        'new_goal_id',
        'user_id',
        'progress_against_goal',
        'achievement_status',
        'rating',
        'manager_rating',
        'weightage',
        'hr_rating',
        'status',
        'submitted_at',
        'manager_reviewed_at',
        'hr_reviewed_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'manager_rating' => 'integer',
        'hr_rating' => 'integer',

        'submitted_at' => 'datetime',
        'manager_reviewed_at' => 'datetime',
        'hr_reviewed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Employee
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Goal
    |--------------------------------------------------------------------------
    */

    public function goal()
    {
        return $this->belongsTo(
            NewGoal::class,
            'new_goal_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */

    public function reviews()
    {
        return $this->hasMany(
            GoalReportReview::class,
            'goal_self_report_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager Review
    |--------------------------------------------------------------------------
    */

    public function managerReview()
    {
        return $this->hasOne(
            GoalReportReview::class,
            'goal_self_report_id'
        )->where(
                'reviewer_type',
                'manager'
            )->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | HR Review
    |--------------------------------------------------------------------------
    */

    public function hrReview()
    {
        return $this->hasOne(
            GoalReportReview::class,
            'goal_self_report_id'
        )->where(
                'reviewer_type',
                'hr'
            )->latestOfMany();
    }
}