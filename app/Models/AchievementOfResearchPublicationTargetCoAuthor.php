<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AchievementOfResearchPublicationTargetCoAuthor extends Model
{
    use HasFactory;
    protected $table = 'achievement_of_research_publications_target_co_author';

    protected $fillable = [
        'target_id','name','rank','univeristy_name','country','designation',
        'no_paper_past','first_author_superviser','student_roll_no','career','created_by','updated_by'
    ];

    public function target()
    {
        return $this->belongsTo(AchievementOfResearchPublicationsTarget::class, 'target_id');
    }
}
