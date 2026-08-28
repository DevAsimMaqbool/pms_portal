<?php

namespace App\Http\Controllers;

use App\Imports\StudentEngagementRateImport;
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
    public function store1(Request $request)
    {
        try {
            $data = [];
            if ($request->form_status == 'HOD') {
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

                    // Program Information
                    'programs' => 'required|array|min:1',

                    'programs.*.faculty_id' => 'required|integer',
                    'programs.*.department_id' => 'required|integer',
                    'programs.*.program_id' => 'required|integer',
                    'programs.*.program_level' => 'required|string|in:UG,PG',

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
                // ✅ Convert checkbox array to JSON
                $data['event_location'] = isset($data['event_location'])
                    ? json_encode($data['event_location'])
                    : null;



            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = StudentEngagementRate::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
public function store(Request $request)
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
}
