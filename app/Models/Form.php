<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'id',
        'title',
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'form_user', 'form_id', 'user_id')->withTimestamps();
    }
}
