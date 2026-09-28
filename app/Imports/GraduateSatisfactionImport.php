<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Employability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class GraduateSatisfactionImport implements ToCollection, WithHeadingRow
{
    protected $indicatorId;
    protected $formStatus;

    public function __construct($indicatorId, $formStatus)
    {
        $this->indicatorId = $indicatorId;
        $this->formStatus = $formStatus;
    }

    public function collection(Collection $collection)
    {
        $errors = [];

        /*
        |--------------------------------------------------------------------------
        | STEP 1: VALIDATE ALL ROWS
        |--------------------------------------------------------------------------
        */

        foreach ($collection as $index => $row) {

            $excelRow = $index + 2;

            $studentId = trim((string) ($row['student_id'] ?? ''));

            $graduateSatisfaction =
                $row['graduate_satisfaction'] ?? null;

            /*
            |--------------------------------------------------------------------------
            | Validate Student ID
            |--------------------------------------------------------------------------
            */

            $validator = Validator::make(
                [
                    'student_id' => $studentId,
                    'graduate_satisfaction' => $graduateSatisfaction,
                ],
                [
                    'student_id' =>
                        'required|string',

                    'graduate_satisfaction' =>
                        'nullable|numeric|min:0|max:5',
                ]
            );

            if ($validator->fails()) {

                $rowErrors = [];

                foreach ($validator->errors()->messages() as $field => $messages) {

                    foreach ($messages as $message) {

                        $rowErrors[] =
                            $field . ': ' . $message;
                    }
                }

                $errors[] = [
                    'row' => $excelRow,
                    'student_id' => $studentId,
                    'errors' => $rowErrors,
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Check Student Exists
            |--------------------------------------------------------------------------
            */

            $exists = Employability::where(
                'student_id',
                $studentId
            )
            ->where('indicator_id', $this->indicatorId)
            ->exists();

            if (!$exists) {

                $errors[] = [
                    'row' => $excelRow,
                    'student_id' => $studentId,
                    'errors' => [
                        'student_id: Student ID not found in Employability records.'
                    ],
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STOP EVERYTHING IF ANY ERROR
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
                    ($error['student_id'] ?: '-') =>
                    $error['errors']
                ];
            }

            throw ValidationException::withMessages(
                $validationErrors
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 2: UPDATE
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($collection) {

            foreach ($collection as $row) {

                $studentId =
                    trim((string) $row['student_id']);

                $graduateSatisfaction =
                    $row['graduate_satisfaction'] ?? null;

                Employability::where(
                    'student_id',
                    $studentId
                )
                ->where(
                    'indicator_id',
                    $this->indicatorId
                )
                ->update([

                    'graduate_satisfaction' =>
                        $graduateSatisfaction,

                    'updated_by' =>
                        Auth::id(),

                    'updated_at' =>
                        now(),
                ]);
            }
        });
    }
}