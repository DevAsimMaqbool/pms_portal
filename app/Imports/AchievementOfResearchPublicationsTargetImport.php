<?php

namespace App\Imports;

use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\AchievementOfResearchPublicationTargetCoAuthor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AchievementOfResearchPublicationsTargetImport implements ToCollection, WithHeadingRow
{
    protected $indicatorId;
    protected $formStatus;

    public function __construct($indicatorId, $formStatus)
    {
        $this->indicatorId = $indicatorId;
        $this->formStatus = $formStatus;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {

            // ✅ Validate each row
            $validator = Validator::make($row->toArray(), [
                'target_category' => 'required|string|max:255',
                'link_of_publications' => 'required|url|max:500',
                'journal_clasification' => 'required',
                'nationality' => 'required|string|max:255',
                'as_author_your_rank' => 'required|integer|min:0',
                'scopus_q1' => 'nullable|integer|min:0',
                'scopus_q2' => 'nullable|integer|min:0',
                'scopus_q3' => 'nullable|integer|min:0',
                'scopus_q4' => 'nullable|integer|min:0',
                'hec_w' => 'nullable|integer|min:0',
                'hec_x' => 'nullable|integer|min:0',
                'hec_y' => 'nullable|integer|min:0',
                'medical_recognized' => 'nullable|integer|min:0',
                'co_author_name' => 'required|string|max:255',
                'co_author_rank' => 'required|integer|min:0',
                'co_author_univeristy_name' => 'required|string|max:255',
                'co_author_country' => 'required|string|max:255',
                'co_author_your_role' => 'required|in:Student,Researcher,Professional',
                'co_author_designation' => '',
                'co_author_no_paper_past' => 'required|integer|min:0',
                'co_author_is_the_student_fitst_coauthor' => '',
                'co_author_student_roll_no' => '',
                'co_author_career' => '',
            ]);

            // ❌ Skip invalid rows
            if ($validator->fails()) {
                dd([
                    'row' => $index + 2, // +2 for heading row
                    'errors' => $validator->errors(),
                    'data' => $row
                ]);
                continue;
            }

            // ✅ Save data
            $rating =AchievementOfResearchPublicationsTarget::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,
                'target_category' => $row['target_category'],
                'link_of_publications' => $row['link_of_publications'],
                'journal_clasification' => $row['journal_clasification'],
                'nationality' => $row['nationality'],
                'scopus_q1' => $row['scopus_q1'],
                'scopus_q2' => $row['scopus_q2'],
                'scopus_q3' => $row['scopus_q3'],
                'scopus_q4' => $row['scopus_q4'],
                'hec_w' => $row['hec_w'],
                'hec_x' => $row['hec_x'],
                'hec_y' => $row['hec_y'],
                'medical_recognized' => $row['medical_recognized'],
                'as_author_your_rank' => $row['as_author_your_rank'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
            AchievementOfResearchPublicationTargetCoAuthor::create([
                    'target_id' => $rating->id,
                    'name' => $row['co_author_name'] ?? null,
                    'rank' => $row['co_author_rank'] ?? null,
                    'univeristy_name' => $row['co_author_univeristy_name'] ?? null,
                    'country' => $row['co_author_country'] ?? null,
                    'your_role' => $row['co_author_your_role'] ?? null,
                    'designation' => $row['co_author_designation'] ?? null,
                    'no_paper_past' => $row['co_author_no_paper_past'] ?? null,
                    'is_the_student_fitst_coauthor' => $row['co_author_is_the_student_fitst_coauthor'] ?? null,
                    'student_roll_no' => $row['co_author_student_roll_no'] ?? null,
                    'career' => $row['co_author_career'] ?? null,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
        }
    }
}
