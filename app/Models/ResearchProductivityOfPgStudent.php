<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchProductivityOfPgStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_id',
        'name',
        'rank',
        'univeristy_name',
        'country',
        'designation',
        'co_author_email',
        'no_paper_past',
        'your_role',
        'student_roll_no',
        'career',
        'is_the_student_fitst_coauthor',
        'created_by',
        'updated_by'
    ];

    public function target()
    {
        return $this->belongsTo(ResearchProductivityOfPgStudentTarget::class, 'target_id');
    }
}
