<?php

namespace App\Imports;

use App\Models\AdmissionTargetAchieved;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdmissionTargetAchievedImport implements ToCollection, WithHeadingRow
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
                'faculty_id' => 'required|exists:faculties,id',
                'department_id' => 'required|exists:departments,id',
                'program_id' => 'required|exists:programs,id',
                'admissions_campaign' => 'required|string',
                'admissions_target' => 'required|integer|min:0',
                'achieved_target' => 'required|integer|min:0',
            ]);

            // ❌ Skip invalid rows
            if ($validator->fails()) {
                continue;
            }

           

            // ✅ Save data
            AdmissionTargetAchieved::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,

                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'program_id' => $row['program_id'],
                'admissions_campaign' => $row['admissions_campaign'],
                'admissions_target' => $row['admissions_target'],
                'achieved_target' => $row['achieved_target'],

                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
