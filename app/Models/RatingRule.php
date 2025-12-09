<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingRule extends Model
{
    protected $fillable = [
        'min_percentage',
        'max_percentage',
        'rating',
        'description',
        'color',
        'status',
        'created_by',
        'updated_by',
        
    ];
}
