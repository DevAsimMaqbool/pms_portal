<?php

namespace App\Http\Controllers;

use App\Imports\StudentEngagementRateImport;
use App\Models\Department;
use App\Models\Program;
use App\Models\StudentEngagementRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StudentEngagementRateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

            $status = $request->input('status');
            if ($status == "HOD") {
                $forms = StudentEngagementRate::with(['faculty', 'department', 'program'])->where('created_by', $employee_id)
                    ->orderBy('id', 'desc')
                    ->get();
            }

            if ($request->ajax()) {
                return response()->json([
                    'forms' => $forms
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
{
    try {

        $validator = Validator::make($request->all(), [
            'indicator_id' => 'required|integer',
            'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',

            'nature_of_event' => 'required|string',
            'other_event_detail' => 'nullable|string',
            'event_location' => 'nullable|array',
            'scope_of_the_event' => 'required|string',

            'title_of_the_event' => 'nullable|string',
            'brief_description_of_activity' => 'nullable|string',

            'event_start_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_start_date',

            'faculty_ids' => 'required|array|min:1',
            'faculty_ids.*' => 'integer|exists:faculties,id',

            'department_ids' => 'required|array|min:1',
            'department_ids.*' => 'integer|exists:departments,id',

            'program_ids' => 'required|array|min:1',
            'program_ids.*' => 'integer|exists:programs,id',

            'program_level' => 'required|in:UG,PG',

            'participation_target' => 'nullable|integer',
            'number_of_students_participated' => 'nullable|integer',
            'employer_satisfaction' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $facultyIds = array_map('intval', $request->faculty_ids);
        $departmentIds = array_map('intval', $request->department_ids);
        $programIds = array_map('intval', $request->program_ids);

        /*
        |--------------------------------------------------------------------------
        | Get valid Faculty -> Department relationships
        |--------------------------------------------------------------------------
        */

        $departments = Department::whereIn('id', $departmentIds)
            ->whereIn('faculty_id', $facultyIds)
            ->get(['id', 'faculty_id']);

        if ($departments->count() !== count($departmentIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Faculty / Department relationship selected.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Get valid Department -> Program relationships
        |--------------------------------------------------------------------------
        */

        $programs = Program::whereIn('id', $programIds)
            ->whereIn('department_id', $departmentIds)
            ->get(['id', 'department_id']);

        if ($programs->count() !== count($programIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Department / Program relationship selected.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Build exact Faculty -> Department -> Program rows
        |--------------------------------------------------------------------------
        */

        $rows = [];

        foreach ($programs as $program) {

            $department = $departments->firstWhere(
                'id',
                $program->department_id
            );

            if (!$department) {
                continue;
            }

            $facultyId = $department->faculty_id;

            $rows[] = [
                'faculty_id' => $facultyId,
                'department_id' => $department->id,
                'program_id' => $program->id,
                'program_level' => $request->program_level,
            ];
        }

        if (empty($rows)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No valid Faculty, Department and Program combination found.'
            ], 422);
        }

        DB::beginTransaction();

        $employeeId = Auth::user()->employee_id;

        /*
        |--------------------------------------------------------------------------
        | Common data
        |--------------------------------------------------------------------------
        */

        $commonData = [
            'indicator_id' => $request->indicator_id,
            'form_status' => $request->form_status,
            'nature_of_event' => $request->nature_of_event,
            'other_event_detail' => $request->other_event_detail,
            'event_location' => $request->event_location
                ? json_encode($request->event_location)
                : null,
            'scope_of_the_event' => $request->scope_of_the_event,
            'title_of_the_event' => $request->title_of_the_event,
            'brief_description_of_activity' => $request->brief_description_of_activity,
            'event_start_date' => $request->event_start_date,
            'event_end_date' => $request->event_end_date,
            'participation_target' => $request->participation_target,
            'number_of_students_participated' => $request->number_of_students_participated,
            'employer_satisfaction' => $request->employer_satisfaction,
            'created_by' => $employeeId,
            'updated_by' => $employeeId,
        ];

        /*
        |--------------------------------------------------------------------------
        | Duplicate + Insert
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $row) {

            $duplicate = StudentEngagementRate::where(
                    'indicator_id',
                    $request->indicator_id
                )
                ->where('faculty_id', $row['faculty_id'])
                ->where('department_id', $row['department_id'])
                ->where('program_id', $row['program_id'])
                ->where('program_level', $row['program_level'])
                ->where(function ($query) use ($request) {

                    if ($request->nature_of_event === 'Other') {
                        $query->where('nature_of_event', 'Other')
                            ->where('other_event_detail', $request->other_event_detail);
                    } else {
                        $query->where('nature_of_event', $request->nature_of_event);
                    }

                })
                ->exists();

            if ($duplicate) {

                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'message' =>
                        "Duplicate record already exists for Faculty {$row['faculty_id']}, " .
                        "Department {$row['department_id']}, " .
                        "Program {$row['program_id']} and " .
                        "Level {$row['program_level']}."
                ], 409);
            }

            StudentEngagementRate::create(
                array_merge($commonData, $row)
            );
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => count($rows) . ' record(s) saved successfully.'
        ]);

    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
public function store1(Request $request)
{
    try {

        if ($request->form_status != 'HOD') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid form status.'
            ], 422);
        }

        // -------------------------------------------------
        // Validation
        // -------------------------------------------------
        $rules = [

            'indicator_id' => 'required',

            'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',

            // Engagement
            'nature_of_event' => 'required|string',
            'other_event_detail' => 'nullable|string',
            'event_location' => 'nullable|array',
            'scope_of_the_event' => 'required|string',

            // Event Details
            'title_of_the_event' => 'nullable|string',
            'brief_description_of_activity' => 'nullable|string',
            'event_start_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_start_date',

            // Multiple Program Information
            'programs' => 'required|array|min:1',

            'programs.*.faculty_id' => 'required|integer',
            'programs.*.department_id' => 'required|integer',
            'programs.*.program_id' => 'required|integer',
            'programs.*.program_level' => 'required|string|in:UG,PG',

            // Participation
            'participation_target' => 'nullable|integer|min:0',
            'number_of_students_participated' => 'nullable|integer|min:0',
            'employer_satisfaction' => 'required|numeric|min:0|max:5',
        ];


        $validator = Validator::make(
            $request->all(),
            $rules
        );


        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        // -------------------------------------------------
        // Get validated data
        // -------------------------------------------------
        $data = $validator->validated();


        // -------------------------------------------------
        // Employee
        // -------------------------------------------------
        $employeeId = Auth::user()->employee_id;


        // -------------------------------------------------
        // Programs
        // -------------------------------------------------
        $programs = $data['programs'];

        unset($data['programs']);


        // -------------------------------------------------
        // Convert Event Location to JSON
        // -------------------------------------------------
        $data['event_location'] = isset($data['event_location'])
            ? json_encode($data['event_location'])
            : null;


        // -------------------------------------------------
        // Check duplicate programs inside submitted request
        // -------------------------------------------------
        $uniquePrograms = [];

        foreach ($programs as $index => $program) {

            $programKey =
                $program['faculty_id'] . '-' .
                $program['department_id'] . '-' .
                $program['program_id'] . '-' .
                $program['program_level'];


            if (in_array($programKey, $uniquePrograms)) {

                return response()->json([
                    'status' => 'error',
                    'message' =>
                        'Duplicate program found in the submitted data at row '
                        . ($index + 1)
                        . '. Please remove the duplicate program.'
                ], 409);
            }


            $uniquePrograms[] = $programKey;
        }


        // -------------------------------------------------
        // Start transaction
        // -------------------------------------------------
        DB::beginTransaction();


        $records = [];


        // -------------------------------------------------
        // Check and create each program record
        // -------------------------------------------------
        foreach ($programs as $program) {


            $duplicate = StudentEngagementRate::where('faculty_id', $program['faculty_id'])
                ->where('department_id', $program['department_id'])
                ->where('program_id', $program['program_id'])
                ->where('program_level', $program['program_level'])
                ->exists();


            if ($duplicate) {

                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'message' =>
                        'Duplicate record already exists for the selected '
                        . 'Faculty, Department, Program and Program Level.'
                ], 409);
            }


            // -------------------------------------------------
            // Prepare record data
            // -------------------------------------------------
            $recordData = array_merge($data, [

                'faculty_id' => $program['faculty_id'],

                'department_id' => $program['department_id'],

                'program_id' => $program['program_id'],

                'program_level' => $program['program_level'],

                'created_by' => $employeeId,

                'updated_by' => $employeeId,
            ]);


            // -------------------------------------------------
            // Create record
            // -------------------------------------------------
            $records[] = StudentEngagementRate::create(
                $recordData
            );
        }


        // -------------------------------------------------
        // Commit
        // -------------------------------------------------
        DB::commit();


        // -------------------------------------------------
        // Success
        // -------------------------------------------------
        return response()->json([

            'status' => 'success',

            'message' =>
                count($records) . ' record(s) saved successfully.',

            'data' => $records
        ]);


    } catch (\Exception $e) {

        // -------------------------------------------------
        // Rollback
        // -------------------------------------------------
        DB::rollBack();


        return response()->json([

            'status' => 'error',

            'message' => $e->getMessage()

        ], 500);
    }
}

    public function update(Request $request, $id)
    {
        try {
            $data = [];
            if ($request->has('status_update_data')) {
                $record = StudentEngagementRate::findOrFail($id);

                $rules = [
                    // Engagement
                    'nature_of_event' => 'required|string',
                    'other_event_detail' => 'nullable|string',
                    'event_location' => 'nullable|array',
                    'scope_of_the_event' => 'nullable|string',

                    // Event Details
                    'title_of_the_event' => 'nullable|string',
                    'brief_description_of_activity' => 'nullable|string',
                    'event_start_date' => 'required|date',
                    'event_end_date' => 'required|date|after_or_equal:event_start_date',

                    // Program Info
                    'faculty_id' => 'required|integer',
                    'department_id' => 'required|integer',
                    'program_id' => 'required|integer',
                    'program_level' => 'required|string',

                    // Participation
                    'participation_target' => 'nullable|integer',
                    'number_of_students_participated' => 'nullable|integer',
                    'employer_satisfaction' => 'required',
                ];


                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 422);
                }

                $data = $validator->validated();
                // Check duplicate record except current record
                $duplicate = StudentEngagementRate::where('id', '!=', $id)
                    ->where('faculty_id', $data['faculty_id'])
                    ->where('department_id', $data['department_id'])
                    ->where('program_id', $data['program_id'])
                    ->where('program_level', $data['program_level'])
                    ->exists();

                if ($duplicate) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Duplicate record already exists for the selected Faculty, Department, Program and Program Level.'
                    ], 409);
                }
                // ✅ Convert checkbox array to JSON
                $data['event_location'] = isset($data['event_location'])
                    ? json_encode($data['event_location'])
                    : null;

                // ✅ If "Other" selected — override value
                if ($request->nature_of_event != 'Other') {
                    $data['other_event_detail'] = null;
                }

                $data['updated_by'] = Auth::user()->employee_id;
                $record->update($data);
                return response()->json(['status' => 'success', 'message' => 'Record updated successfully', 'data' => $record]);
            }
            if ($request->has('status_update')) {

            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }
    // Destroy single or bulk records
    public function destroy($id)
    {
        $record = StudentEngagementRate::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'indicator_id' => 'required',
            'form_status' => 'required',
        ]);

        Excel::import(
            new StudentEngagementRateImport(
                $request->indicator_id,
                $request->form_status
            ),
            $request->file
        );

        return response()->json([
            'message' => 'Imported successfully'
        ]);
    }
    public function getMultipleDepartments(Request $request)
    {
        $facultyIds = $request->input('faculty_ids', []);

        return Department::whereIn('faculty_id', $facultyIds)
            ->select('id', 'name', 'faculty_id')
            ->orderBy('name')
            ->get();
    }
    public function getMultiplePrograms(Request $request)
    {
        $departmentIds = $request->input('department_ids', []);

        return Program::whereIn('department_id', $departmentIds)
            ->select('id', 'program_name', 'department_id')
            ->orderBy('program_name')
            ->get();
    }
}
