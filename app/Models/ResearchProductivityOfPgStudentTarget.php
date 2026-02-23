<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchProductivityOfPgStudentTarget extends Model
{
    //
    protected $fillable = [
        'indicator_id',
        'target_category',
        'link_of_publications',
        'journal_clasification',
        'student_name',
        'roll_no',
        'as_author_your_rank',
        'faculty_id',
        'department_id',
        'program_id',
        'nationality',
        'scopus_q1',
        'scopus_q2',
        'scopus_q3',
        'scopus_q4',
        'hec_w',
        'hec_x',
        'hec_y',
        'medical_recognized',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
    protected $casts = [
        'update_history' => 'array',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
    public function coAuthors()
    {
        return $this->hasMany(ResearchProductivityOfPgStudent::class, 'target_id');
    }
    public function facultyTarget()
    {
        return $this->belongsTo(FacultyTarget::class, 'created_by', 'user_id')
            ->whereColumn('achievement_of_research_publications_target.indicator_id', 'faculty_targets.indicator_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function facultyMember()
    {
        return $this->belongsTo(User::class, 'faculty_member_id');
    }
}
