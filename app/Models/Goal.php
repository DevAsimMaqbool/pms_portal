<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'goal_name',
        'goal_cod',
        's2r_driver_id',
        'goal_statement',
        'validate',
        'status'
    ];
    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
    public function driver()
    {
        return $this->belongsTo(S2RDriver::class, 's2r_driver_id');
    }
    public function assignments()
    {
        return $this->hasMany(GoalAssignment::class);
    }
}
