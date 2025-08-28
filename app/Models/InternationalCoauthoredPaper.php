<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalCoauthoredPaper extends Model
{
    use HasFactory;

    protected $table = 'international_coauthored_papers';
    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'name_of_co_authers',
        'author_rank',
        'name_of_university_country',
        'designation',
        'no_of_papers_past',
        'status',
        'created_by',
        'updated_by',
    ];
}
