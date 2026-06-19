<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    protected $fillable = [
        'goal_id',
        'title',
        'objective_cod',
        'validate',
        'status'
    ];
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function dimensions()
    {
        return $this->hasMany(Dimension::class);
    }

    public function assignments()
    {
        return $this->hasMany(
            GoalAssignment::class,
            'objective_id',
            'id'
        );
    }
}
