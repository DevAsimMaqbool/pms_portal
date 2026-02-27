<?php

namespace App\Http\Controllers;

use App\Models\FacultyRetention;
use App\Models\FacultyRetentionRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyRetentionController extends Controller
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

        
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = FacultyRetention::with('remarks')->where('created_by', $employee_id)
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
                        'year' => 'required',
                        'retention_rate' => 'required|array|min:1',
                        'retention_rate.*.faculty_id' => 'required|integer',
                        'retention_rate.*.no_retention_rate' => 'required|numeric|min:0|max:100',
                        'retention_rate.*.remarks' => 'nullable|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'retention_rate.*.faculty_id.required' => 'Faculty is required',
                        'retention_rate.*.no_retention_rate.required' => 'Rate is required',
                    ];
                

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                    // Create main record
                    $FacultyRetention = FacultyRetention::create([
                        'indicator_id' => $request->indicator_id,
                        'year' => $request->year,
                        'form_status' => $request->form_status,
                        'created_by' => $employeeId,
                        'updated_by' => $employeeId,
                    ]);      

                    foreach ($request->retention_rate as $retention_rates) {
                        FacultyRetentionRemark::create([
                            'faculty_retention_id' => $FacultyRetention->id,
                            'faculty_id' => $retention_rates['faculty_id'],
                            'no_retention_rate' => $retention_rates['no_retention_rate'],
                            'remarks' => $retention_rates['remarks'],
                        ]);
                    }

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $FacultyRetention
            ]);

        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = [
                'year' => 'required',
                'retention_rate' => 'required|array|min:1',
                'retention_rate.*.faculty_id' => 'required|integer',
                'retention_rate.*.no_retention_rate' => 'required|numeric|min:0|max:100',
                'retention_rate.*.remarks' => 'nullable|string',
    
        ];
        Validator::validate($request->all(), $rules);
        $record = FacultyRetention::findOrFail($id);
        // ✅ Update parent
        $record->update([
            'year' => $request->year,
            'updated_by' => Auth::user()->employee_id
        ]);
        // ✅ Sync child tasks
        $record->remarks()->delete();
        foreach ($request->retention_rate as $row) {

            $record->remarks()->create([
                'faculty_id' => $row['faculty_id'],
                'no_retention_rate' => $row['no_retention_rate'],
                'remarks' => $row['remarks'],
            ]);
        }
        return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = FacultyRetention::findOrFail($id);
        // Delete related remarks (assuming remarks are in separate table)
        $record->remarks()->delete();

        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}

