<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementOfResearchPublicationsTarget extends Model
{

    protected $table = 'achievement_of_research_publications_target';

     protected $fillable = [
        'indicator_id','target_category','link_of_publications','rank','nationality',
        'scopus_q1','scopus_q2','scopus_q3','scopus_q4',
        'hec_w','hec_x','hec_y','medical_recognized','as_author_your_rank',
        'form_status','status','created_by','updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
    public function coAuthors()
    {
        return $this->hasMany(AchievementOfResearchPublicationTargetCoAuthor::class, 'target_id');
    }
    public function facultyTarget()
    {
        return $this->belongsTo(FacultyTarget::class, 'created_by', 'user_id')
            ->whereColumn('achievement_of_research_publications_target.indicator_id', 'faculty_targets.indicator_id');
    }



}
