<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'id',
        'name',
        'complete_name',
        'parent_id'
    ];

    public $incrementing = false;
}
