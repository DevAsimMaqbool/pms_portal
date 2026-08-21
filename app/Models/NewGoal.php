<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewGoal extends Model
{
    use SoftDeletes;

    protected $table = 'new_goals';

    protected $fillable = [
        'user_id',
        'goal',
        's2r_driver_enabler_alignment',
        'objectives',
        'target',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
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
    | S2R Driver
    |--------------------------------------------------------------------------
    */

    public function s2rDriver()
    {
        return $this->belongsTo(
            S2RDriver::class,
            's2r_driver_enabler_alignment'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Self Reports
    |--------------------------------------------------------------------------
    */

    public function selfReports()
    {
        return $this->hasMany(
            GoalSelfReport::class,
            'new_goal_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Latest Self Report
    |--------------------------------------------------------------------------
    */

    public function latestSelfReport()
    {
        return $this->hasOne(
            GoalSelfReport::class,
            'new_goal_id'
        )->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | Goal History
    |--------------------------------------------------------------------------
    */

    public function histories()
    {
        return $this->hasMany(
            GoalHistory::class,
            'new_goal_id'
        );
    }
}