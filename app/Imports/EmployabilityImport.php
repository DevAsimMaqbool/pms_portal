<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Employability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployabilityImport implements ToCollection, WithHeadingRow
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
                'student_id' => '',
                'period'=> 'required',
                'student_name'=> 'required',
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'batch' => 'required|string',
                'passing_year' => 'required',
                'date_of_appointment' => 'required',
                'proof_salary_and_appointment'=> 'required',
                'employer_name' => 'required|string',
                'sector' => 'required|string',
                'salary' => 'required',
                'market_competitive_salary' => 'required|in:Above,At Par,Low',
                'job_relevancy' => 'nullable|in:yes,no',
                'employer_satisfaction' => 'nullable|numeric|min:0|max:5',
                'graduate_satisfaction' => 'nullable|numeric|min:0|max:5',
            ]);

            // ❌ Skip invalid rows
             if ($validator->fails()) {
                continue;
             }
           

            // 🔁 Optional: Prevent duplicate entry
            // $exists = Employability::where('indicator_id', $this->indicatorId)
            //     ->exists();

            // if ($exists) {
            //     continue;
            // }

            // ✅ Save data
            Employability::create([
                'indicator_id' => $this->indicatorId,
                'form_status' => $this->formStatus,
                'student_id' => null,

                'period' => $row['period'],
                'student_name'=> $row['student_name'],
                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'program_id' => $row['program_id'],
                'batch' => $row['batch'],

                'passing_year' => is_numeric($row['passing_year'])
                    ? Date::excelToDateTimeObject($row['passing_year'])->format('Y-m-d')
                    : $row['passing_year'],

                'date_of_appointment' => is_numeric($row['date_of_appointment'])
                    ? Date::excelToDateTimeObject($row['date_of_appointment'])->format('Y-m-d')
                    : $row['date_of_appointment'],

                'proof_salary_and_appointment'=>$row['proof_salary_and_appointment'],
                'employer_name' => $row['employer_name'],
                'sector' => $row['sector'],
                'salary' => $row['salary'],
                'market_competitive_salary' => $row['market_competitive_salary'],
                'job_relevancy' => $row['job_relevancy'] ?? 'no',
                'employer_satisfaction' => $row['employer_satisfaction'] ?? null,
                'graduate_satisfaction' => $row['graduate_satisfaction'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
