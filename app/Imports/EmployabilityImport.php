<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Employability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;

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
        $errors = [];

        /*
        |--------------------------------------------------------------------------
        | STEP 1: Validate ALL rows first
        |--------------------------------------------------------------------------
        */

        foreach ($collection as $index => $row) {

            /*
             * Excel heading row is row 1.
             * First data row = Excel row 2.
             */
            $excelRow = $index + 2;

            $validator = Validator::make($row->toArray(), [

                'student_id' => '',

                'period' => 'required',

                'student_name' => 'required',

                'cnic' => '',

                'domicile' => '',

                'gender' => 'required',

                'faculty_id' => 'required|integer',

                'department_id' => 'required|integer',

                'program_id' => 'required|integer',

                'program_level'=> '',

                'batch' => 'required',

                'passing_year' => 'required',

                'date_of_appointment' => '',

                'proof_salary_and_appointment' => '',

                'employer_name' => '',

                'sector' => '',

                'salary' => '',

                'market_competitive_salary' =>
                    'nullable|in:Above,At Par,Low',

                'job_relevancy' =>
                    'nullable|in:yes,no',

                'employer_satisfaction' =>
                    'nullable|numeric|min:0|max:5',

                'graduate_satisfaction' =>
                    'nullable|numeric|min:0|max:5',
            ]);

            /*
            |--------------------------------------------------------------------------
            | If this row has errors
            |--------------------------------------------------------------------------
            */

            if ($validator->fails()) {

                $rowErrors = [];

                foreach ($validator->errors()->messages() as $field => $messages) {

                    foreach ($messages as $message) {

                        $rowErrors[] = $field . ': ' . $message;
                    }
                }

                $errors[] = [
                    'row' => $excelRow,

                    'student_id' =>
                        $row['student_id'] ?? null,

                    'student_name' =>
                        $row['student_name'] ?? null,

                    'errors' => $rowErrors,
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        |
        | If even ONE row is invalid,
        | DO NOT SAVE ANYTHING.
        |--------------------------------------------------------------------------
        */

        if (!empty($errors)) {

            $validationErrors = [];

            foreach ($errors as $error) {

                $validationErrors[
                    'row_' . $error['row']
                ] = [
                    'Excel Row ' . $error['row'] .
                    ' | Student ID: ' .
                    ($error['student_id'] ?? '-') .
                    ' | Student: ' .
                    ($error['student_name'] ?? '-')
                    => $error['errors']
                ];
            }

            throw ValidationException::withMessages(
                $validationErrors
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 2:
        |
        | Only reach here when EVERY row is valid.
        |--------------------------------------------------------------------------
        */

        foreach ($collection as $index => $row) {

            Employability::create([

                'indicator_id' =>
                    $this->indicatorId,

                'form_status' =>
                    $this->formStatus,

                'student_id' =>
                    $row['student_id'],

                'period' =>
                    $row['period'],

                'student_name' =>
                    $row['student_name'],

                'cnic' =>
                    $row['cnic'],

                'domicile' =>
                    $row['domicile'],

                'gender' =>
                    $row['gender'],

                'faculty_id' =>
                    $row['faculty_id'],

                'department_id' =>
                    $row['department_id'],

                'program_id' =>
                    $row['program_id'],
                
                'program_level' =>
                    $row['program_level'],

                'batch' =>
                    $row['batch'],

                'passing_year' =>
                    is_numeric($row['passing_year'])
                        ? (
                            strlen((string) $row['passing_year']) === 4
                                ? (string) $row['passing_year']
                                : Date::excelToDateTimeObject($row['passing_year'])->format('Y')
                        )
                        : $row['passing_year'],    

                'date_of_appointment' =>
                    is_numeric($row['date_of_appointment'])
                    ? Date::excelToDateTimeObject(
                        $row['date_of_appointment']
                    )->format('Y-m-d')
                    : $row['date_of_appointment'],

                'proof_salary_and_appointment' =>
                    $row['proof_salary_and_appointment'],

                'employer_name' =>
                    $row['employer_name'],

                'sector' =>
                    $row['sector'],

                'salary' =>
                    $row['salary'],

                'market_competitive_salary' =>
                    $row['market_competitive_salary'],

                'job_relevancy' =>
                    $row['job_relevancy'] ?? 'no',

                'employer_satisfaction' =>
                    $row['employer_satisfaction'] ?? null,

                'graduate_satisfaction' =>
                    $row['graduate_satisfaction'] ?? null,

                'created_by' =>
                    Auth::id(),

                'updated_by' =>
                    Auth::id(),
            ]);
        }
    }
}