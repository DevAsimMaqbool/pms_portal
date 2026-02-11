<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'id',
        'faculty_id',
        'name',
        'code'
    ];

    public $incrementing = false;

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
