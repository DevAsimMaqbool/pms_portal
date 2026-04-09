<?php

namespace App\Http\Controllers;

use App\Imports\RecoveryImport;
use App\Models\Recovery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RecoveryController extends Controller
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
                    $forms = Recovery::with(['faculty', 'department', 'program'])->where('created_by', $employee_id)
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
    public function store(Request $request)
    {
        try {

            $employeeId = Auth::user()->employee_id;
            $rules = [
                'indicator_id' => 'required|integer',
                'recovery' => 'required|array|min:1',
                'recovery.*.faculty_id' => 'required|integer',
                'recovery.*.department_id' => 'required|integer',
                'recovery.*.program_id' => 'required|integer',
                'recovery.*.program_level' => 'required|string',
                'recovery.*.target_month_year' => 'required',
                'recovery.*.recovery_target' => 'required',
                'recovery.*.achieved_target' => 'required',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
            ];

            $messages = [
                'recovery.*.faculty_id.required' => 'Faculty is required',
                'recovery.*.department_id.required' => 'Department is required',
                'recovery.*.program_id.required' => 'Program is required',
                'recovery.*.program_level.required' => 'Program Level is required',
                'recovery.*.target_month_year.required' => 'Date is required.',
                'recovery.*.recovery_target.required' => 'Target is required.',
                'recovery.*.achieved_target.required' => 'Achieved Target is required.',
            ];


            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $savedRecords = [];
            foreach ($request->recovery as $recoverys) {


                $exists = Recovery::where('faculty_id', $recoverys['faculty_id'])
                    ->where('department_id', $recoverys['department_id'])
                    ->where('program_id', $recoverys['program_id'])
                    ->where('target_month_year', $recoverys['target_month_year'])
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Duplicate record found for same Faculty, Department, Program, and Campaign.'
                    ], 422);
                }
                $recoverys['indicator_id'] = $request->indicator_id;
                $recoverys['form_status'] = $request->form_status ?? 'HOD';
                $recoverys['created_by'] = $employeeId;
                $recoverys['updated_by'] = $employeeId;

                $savedRecords[] = Recovery::create($recoverys);
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
        $record = Recovery::findOrFail($id);

        $request->validate([
            'record_id' => 'required',
            'faculty_id' => 'required|integer',
            'department_id' => 'required|integer',
            'program_id' => 'required|integer',
            'program_level' => 'required|string',
            'target_month_year' => 'required',
            'recovery_target' => 'required|integer|min:0',
            'achieved_target' => 'required|integer|min:0',

        ]);
        $exists = Recovery::where('faculty_id', $request->faculty_id)
            ->where('department_id', $request->department_id)
            ->where('program_id', $request->program_id)
            ->where('target_month_year', $request->target_month_year)
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
            'target_month_year',
            'recovery_target',
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
        $record = Recovery::findOrFail($id);
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
            new RecoveryImport(
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
