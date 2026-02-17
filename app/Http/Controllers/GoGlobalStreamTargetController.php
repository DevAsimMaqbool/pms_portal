<?php

namespace App\Http\Controllers;

use App\Models\GoGlobalStreamTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GoGlobalStreamTargetController extends Controller
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
                    $forms = GoGlobalStreamTarget::where('created_by', $employee_id)
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
                        'student_enroll_1m' => 'required|array|min:1',
                        'student_enroll_1m.*.faculty_id' => 'required|integer',
                        'student_enroll_1m.*.department_id' => 'required|integer',
                        'student_enroll_1m.*.program_id' => 'required|integer',
                        'student_enroll_1m.*.experience_target' => 'required',
                        'student_enroll_1m.*.achieved_target' => 'required',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'student_enroll_1m.*.faculty_id.required' => 'Faculty is required',
                        'student_enroll_1m.*.department_id.required' => 'Department is required',
                        'student_enroll_1m.*.program_id.required' => 'Program is required',
                        'student_enroll_1m.*.experience_target.required' => 'Target is required.',
                        'student_enroll_1m.*.achieved_target.required' => 'Achieved Target is required.',
                    ];
                

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $savedRecords = [];
                    foreach ($request->student_enroll_1m as $student_enroll_1ms) {
                        $student_enroll_1ms['indicator_id'] = $request->indicator_id;
                        $student_enroll_1ms['form_status'] = $request->form_status ?? 'HOD';
                        $student_enroll_1ms['created_by'] = $employeeId;
                        $student_enroll_1ms['updated_by'] = $employeeId;

                        $savedRecords[] = GoGlobalStreamTarget::create($student_enroll_1ms);
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
       $record = GoGlobalStreamTarget::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'experience_target' => 'required|integer|min:0',
                'achieved_target' => 'required|integer|min:0',
    
        ]);

        $data = $request->only([
                        'faculty_id', 'department_id', 'program_id', 'admissions_campaign', 'experience_target','achieved_target'
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
        $record = GoGlobalStreamTarget::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
