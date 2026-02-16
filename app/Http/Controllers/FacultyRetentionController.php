<?php

namespace App\Http\Controllers;

use App\Models\FacultyRetention;
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

         if ($user->hasRole('HOD')) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = FacultyRetention::where('created_by', $employee_id)
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

                        $savedRecords = [];
                    foreach ($request->retention_rate as $retention_rates) {
                        $retention_rates['indicator_id'] = $request->indicator_id;
                        $retention_rates['form_status'] = $request->form_status ?? 'HOD';
                        $retention_rates['created_by'] = $employeeId;
                        $retention_rates['updated_by'] = $employeeId;

                        $savedRecords[] = FacultyRetention::create($retention_rates);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $record = FacultyRetention::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'faculty_id' => 'required|integer',
                'no_retention_rate' => 'required|integer',
                'remarks' => '',
    
        ]);

        $data = $request->only([
                        'faculty_id', 'no_retention_rate', 'remarks'
                    ]);
                    $data['updated_by'] = Auth::user()->employee_id;

                    $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($id)
    {
        $record = FacultyRetention::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}

