<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationOfHecRecognizedJournal extends Model
{
    use HasFactory;

    protected $table = 'publication_of_hec_recognized_journals';

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'name_of_journal',
        'approved_frequency_of_pub',
        'no_of_issues_published',
        'revenue_generated_under_apc',
        'no_of_indexing_prior_report',
        'new_indexing_done_quarter',
        'status',
        'created_by',
        'updated_by',
    ];
}
