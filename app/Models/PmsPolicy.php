<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmsPolicy extends Model
{
    protected $fillable = [
        'sop_file',
        'policy_file',
        'created_by',
        'updated_by'
    ];
}
