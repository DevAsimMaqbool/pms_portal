<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveRecord extends Model
{
     protected $fillable = [
        'year_id',
        'term_spring_id',
        'term_fall_id',
        'description',
        'status_year',
        'status_spring',
        'status_fall',
        'status',
    ];
     public function year()
    {
        return $this->belongsTo(Years::class, 'year_id', 'id');
    }
    public function springTerm()
    {
        return $this->belongsTo(Term::class, 'term_spring_id', 'id');
    }

    public function fallTerm()
    {
        return $this->belongsTo(Term::class, 'term_fall_id', 'id');
    }
}
