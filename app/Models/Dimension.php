<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $fillable = [
        'objective_id',
        'name',
        'dimension_cod',
        'validate',
        'status'
    ];
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
    public function goalAssignments()
    {
        return $this->hasMany(
            GoalAssignment::class,
            'dimension_id',
            'id'
        );
    }
}
