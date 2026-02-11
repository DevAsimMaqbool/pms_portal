<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = [
        'id',
        'code',
        'name',
        'city',
        'effective_date',
    ];

    public $incrementing = false;
}
