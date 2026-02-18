<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineManagerReviewRatingTask extends Model
{
    protected $fillable = [
        'line_manager_review_rating_id', 'task', 'linemanager_rating'
    ];

    public function review()
    {
        return $this->belongsTo(LineManagerReviewRating::class, 'line_manager_review_rating_id');
    }
}
