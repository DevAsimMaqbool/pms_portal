<?php

namespace App\Imports;

use App\Models\QecAuditRating;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class QecAuditRatingImport implements ToCollection, WithHeadingRow
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
                'remarks' => 'required',
                'audit_term' => 'required',
                'faculty_id' => 'required',
                'department_id' => 'required',
                'program_id' => 'required',  
                'program_level' => 'required',  
                'total_score' => 'required', 
                'obtained_score' => 'required', 
                'strenght' => 'required',     
                'area_of_improvement' => 'required', 
            ]);

            // ❌ Skip invalid rows
            if ($validator->fails()) {
                continue;
            }

            // ✅ Save data
            $rating =QecAuditRating::create([
                'indicator_id' => $this->indicatorId,
                'user_id' => Auth::id(),
                'form_status' => $this->formStatus,
                'remarks' => $row['remarks'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
            $rating->details()->create([
                    'audit_term' => $row['audit_term'],
                    'faculty_id' => $row['faculty_id'],
                    'department_id' => $row['department_id'],
                    'program_id' => $row['program_id'],
                    'program_level'=> $row['program_level'],
                    'total_score' => $row['total_score'],
                    'obtained_score' => $row['obtained_score'],
                    'strenght' => $row['strenght'],
                    'area_of_improvement' => $row['area_of_improvement'],
                ]);
        }
    }
}
