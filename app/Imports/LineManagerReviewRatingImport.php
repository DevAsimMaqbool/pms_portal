<?php

namespace App\Imports;

use App\Models\LineManagerReviewRating;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LineManagerReviewRatingImport implements ToCollection, WithHeadingRow
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
                'employee_id' => 'required|integer',
                'year' => 'required|string',
                'task' => 'required|string',
                'linemanager_rating' => 'required',
                'remarks' => 'required',
            ]);
                
            // ❌ Skip invalid rows
            if ($validator->fails()) {
                continue;
            }

            // ✅ Save data
            $rating =LineManagerReviewRating::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,
                'employee_id' => $row['employee_id'],
                'year' => $row['year'],
                'remarks' => $row['remarks'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
            $rating->tasks()->create([
                    'task' => $row['task'],
                    'linemanager_rating' => $row['linemanager_rating'],
                ]);
        }
    }
}
