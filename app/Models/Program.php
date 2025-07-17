<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'id',
        'department_id',
        'program_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
