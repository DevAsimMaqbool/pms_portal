<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'term',
        'start_year',
        'end_year',
        'status',
        'created_by',
        'updated_by',
    ];
}
