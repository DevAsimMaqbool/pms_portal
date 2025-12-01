<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineManagerEventFeedback extends Model
{

    protected $fillable = ['employee_id', 'event_name', 'rating', 'remarks'];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
