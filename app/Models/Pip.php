<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pip extends Model
{
    //
    protected $fillable = [
        'description',
        'document',
        'status',
        'created_by',
        'updated_by'
    ];
}
