<?php

namespace App\Imports;

use App\Models\AlumniSatisfactionRate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AlumniSatisfactionRateImport implements ToCollection, WithHeadingRow
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
                'name' => 'required',
                'gender' => 'required',
                'faculty_id' => 'required',
                'department_id' => 'required',
                'program_id' => 'required',
                'program_level'=>'required',
                'roll_no' => 'required',
                'graduation_year' => 'required',
                'current_organization' => 'required',
                'current_designation' => 'required',
                'current_salary' => 'required',
                'email' => 'required',
                'satisfaction_rate' => 'required',
            ]);

            // ❌ Skip invalid rows
            if ($validator->fails()) {
                continue;
            }

           

            // ✅ Save data
            AlumniSatisfactionRate::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,
                'name' => $row['name'],
                'gender' => $row['gender'],
                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'program_id' => $row['program_id'],
                'program_level'=> $row['program_level'],
                'roll_no' => $row['roll_no'],
                'graduation_year' => is_numeric($row['graduation_year'])
                    ? Date::excelToDateTimeObject($row['graduation_year'])->format('Y-m-d')
                    : $row['graduation_year'],
                'current_organization' => $row['current_organization'],
                'current_designation' => $row['current_designation'],
                'current_salary' => $row['current_salary'],
                'email' => $row['email'],
                'satisfaction_rate' => $row['satisfaction_rate'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
