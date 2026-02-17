<?php

namespace App\Http\Controllers;

use App\Models\ScholarsSatisfactionInThesisStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ScholarsSatisfactionInThesisStageController extends Controller
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
                    $forms = ScholarsSatisfactionInThesisStage::where('created_by', $employee_id)
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
                        'scholar_satisfaction' => 'required|array|min:1',
                        'scholar_satisfaction.*.faculty_id' => 'required|integer',
                        'scholar_satisfaction.*.department_id' => 'required|integer',
                        'scholar_satisfaction.*.program_id' => 'required|integer',
                        'scholar_satisfaction.*.term' => 'required',
                        'scholar_satisfaction.*.career' => 'required',
                        'scholar_satisfaction.*.satisfaction_score' => 'required',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'scholar_satisfaction.*.faculty_id.required' => 'Faculty is required',
                        'scholar_satisfaction.*.department_id.required' => 'Department is required',
                        'scholar_satisfaction.*.program_id.required' => 'Program is required',
                        'scholar_satisfaction.*.term.required' => 'Term is required.',
                        'scholar_satisfaction.*.career.required' => 'Career is required.',
                        'scholar_satisfaction.*.satisfaction_score.required' => 'Satisfaction Score is required.',
                    ];
                

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $savedRecords = [];
                    foreach ($request->scholar_satisfaction as $scholar_satisfactions) {
                        $scholar_satisfactions['indicator_id'] = $request->indicator_id;
                        $scholar_satisfactions['form_status'] = $request->form_status ?? 'HOD';
                        $scholar_satisfactions['created_by'] = $employeeId;
                        $scholar_satisfactions['updated_by'] = $employeeId;

                        $savedRecords[] = ScholarsSatisfactionInThesisStage::create($scholar_satisfactions);
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
       $record = ScholarsSatisfactionInThesisStage::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'term' => 'required',
                'career' => 'required',
                'satisfaction_score' => 'required',
    
        ]);

        $data = $request->only([
                        'faculty_id', 'department_id', 'program_id', 'term', 'career','satisfaction_score'
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
        $record = ScholarsSatisfactionInThesisStage::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
