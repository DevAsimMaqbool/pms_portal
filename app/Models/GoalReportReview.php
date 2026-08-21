<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalReportReview extends Model
{
    protected $table = 'goal_report_reviews';

    protected $fillable = [
        'goal_self_report_id',
        'reviewer_id',
        'reviewer_type',
        'decision',
        'rating',
        'comments',
        'reviewed_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(
            GoalSelfReport::class,
            'goal_self_report_id'
        );
    }

    public function reviewer()
    {
        return $this->belongsTo(
            User::class,
            'reviewer_id'
        );
    }
}