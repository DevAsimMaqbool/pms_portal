<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineManagerReviewRating extends Model
{
    //
    protected $table = 'line_manager_review_ratings';
    protected $fillable = [
        'indicator_id',
        'employee_id',
        'year',

        'remarks',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];

    public function tasks()
    {
        return $this->hasMany(LineManagerReviewRatingTask::class, 'line_manager_review_rating_id');
    }
}
