<?php

namespace App\Http\Controllers;

use App\Imports\AdmissionTargetAchievedImport;
use App\Models\AdmissionTargetAchieved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdmissionTargetAchievedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

            if (in_array(getRoleName(activeRole()), ['Finance'])) {
                $status = $request->input('status');
                if ($status == "HOD") {
                    $forms = AdmissionTargetAchieved::with(['faculty', 'department', 'program'])
                        ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get();
                }
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store11(Request $request)
    {
        try {

            $employeeId = Auth::user()->employee_id;
            $rules = [
                'indicator_id' => 'required|integer',
                'admission' => 'required|array|min:1',
                'admission.*.faculty_id' => 'required|integer',
                'admission.*.department_id' => 'required|integer',
                'admission.*.program_id' => 'required|integer',
                'admission.*.admissions_campaign' => 'required|string',
                'admission.*.admissions_target' => 'required',
                'admission.*.achieved_target' => 'required',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            ];

            $messages = [
                'admission.*.faculty_id.required' => 'Faculty is required',
                'admission.*.department_id.required' => 'Department is required',
                'admission.*.program_id.required' => 'Program is required',
                'admission.*.admissions_campaign.required' => 'Campaign is required.',
                'admission.*.admissions_target.required' => 'Target is required.',
                'admission.*.achieved_target.required' => 'Achieved Target is required.',
            ];


            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $savedRecords = [];
            foreach ($request->admission as $admissions) {


                $exists = AdmissionTargetAchieved::where('faculty_id', $admissions['faculty_id'])
                    ->where('department_id', $admissions['department_id'])
                    ->where('program_id', $admissions['program_id'])
                    ->where('admissions_campaign', $admissions['admissions_campaign'])
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Duplicate record found for same Faculty, Department, Program, and Campaign.'
                    ], 422);
                }
                $admissions['indicator_id'] = $request->indicator_id;
                $admissions['form_status'] = $request->form_status ?? 'HOD';
                $admissions['created_by'] = $employeeId;
                $admissions['updated_by'] = $employeeId;

                $savedRecords[] = AdmissionTargetAchieved::create($admissions);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $savedRecords
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $employeeId = Auth::user()->employee_id;

            $validator = Validator::make($request->all(), [
                'indicator_id' => 'required|integer',
                'admission' => 'required|array|min:1',
                'admission.*.faculty_id' => 'required|integer',
                'admission.*.department_id' => 'required|integer',
                'admission.*.program_id' => 'required|integer',
                'admission.*.program_level' => 'required|string',
                'admission.*.admissions_campaign' => 'required|string',
                'admission.*.admissions_target' => 'required',
                'admission.*.achieved_target' => 'required',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $errors = [];
            $savedRecords = [];

            foreach ($request->admission as $index => $admissions) {

                $exists = AdmissionTargetAchieved::where('faculty_id', $admissions['faculty_id'])
                    ->where('department_id', $admissions['department_id'])
                    ->where('program_id', $admissions['program_id'])
                    ->where('admissions_campaign', $admissions['admissions_campaign'])
                    ->exists();

                if ($exists) {
                    $errors["admission.$index"] = "Row " . ($index + 1) . " already exists.";
                    continue;
                }

                $admissions['indicator_id'] = $request->indicator_id;
                $admissions['form_status'] = $request->form_status ?? 'HOD';
                $admissions['created_by'] = $employeeId;
                $admissions['updated_by'] = $employeeId;

                $savedRecords[] = AdmissionTargetAchieved::create($admissions);
            }

            // ❌ If ANY duplicate found → rollback ALL
            if (!empty($errors)) {
                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'errors' => $errors
                ], 422);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'All records saved successfully',
                'data' => $savedRecords
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $record = AdmissionTargetAchieved::findOrFail($id);

        $request->validate([
            'record_id' => 'required',
            'faculty_id' => 'required|integer',
            'department_id' => 'required|integer',
            'program_id' => 'required|integer',
            'program_level' => 'required|string',
            'admissions_campaign' => 'required',
            'admissions_target' => 'required|integer|min:0',
            'achieved_target' => 'required|integer|min:0',

        ]);
        // Check for duplicate record (ignore current record ID)
        $exists = AdmissionTargetAchieved::where('faculty_id', $request->faculty_id)
            ->where('department_id', $request->department_id)
            ->where('program_id', $request->program_id)
            ->where('admissions_campaign', $request->admissions_campaign)
            ->where('id', '!=', $id)  // exclude current record
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Duplicate record found for same Faculty, Department, Program, and Campaign.'
            ], 422);
        }

        $data = $request->only([
            'faculty_id',
            'department_id',
            'program_id',
            'program_level',
            'admissions_campaign',
            'admissions_target',
            'achieved_target'
        ]);
        $data['updated_by'] = Auth::user()->employee_id;

        $record->update($data);

        return response()->json(['status' => 'success', 'message' => 'Record updated successfully', 'data' => $record]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = AdmissionTargetAchieved::findOrFail($id);
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
            new AdmissionTargetAchievedImport(
                $request->indicator_id,
                $request->form_status
            ),
            $request->file
        );

        return response()->json([
            'message' => 'Admission Target data imported successfully'
        ]);
    }


}
