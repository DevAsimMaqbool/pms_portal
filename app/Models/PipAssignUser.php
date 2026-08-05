<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PipAssignUser extends Model
{
    protected $fillable=[
        'pip_id',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pip()
    {
        return $this->belongsTo(Pip::class);
    }
}
