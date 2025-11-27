<?php

namespace App\Http\Controllers;

use App\Models\FacultyTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyTargetController extends Controller
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
                   $forms = FacultyTarget::with(['user:id,name,employee_id', 'indicator:id,indicator'])
                ->where('created_by', $employee_id)
                ->where('form_status', 'OTHER')
                ->get();
                
            }
            if ($user->hasRole('Dean')) {
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                           $forms = FacultyTarget::with(['user:id,name,employee_id', 'indicator:id,indicator','assign:id,name,employee_id',])
                            ->whereIn('created_by', $hod_ids)
                            ->whereIn('status', [1, 2])
                            ->whereIn('form_status', ['OTHER', 'HOD'])
                            ->get();
            }
            if ($user->hasRole('ORIC')) {
                
                            $forms = FacultyTarget::with(['user:id,name,employee_id', 'indicator:id,indicator','assign:id,name,employee_id',])
                            ->whereIn('status', [2, 3])
                            ->whereIn('form_status', ['OTHER', 'HOD'])
                            ->get();

            }
            if ($user->hasRole('Human Resources')) {
                
                            $forms = FacultyTarget::with(['user:id,name,employee_id', 'indicator:id,indicator','assign:id,name,employee_id',])
                            ->whereIn('status', [3, 4])
                            ->whereIn('form_status', ['OTHER', 'HOD'])
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
            if($request->form_status=='HOD'){
                 $rules = [
                        'indicator_id' => 'required',
                        'faculty_member_id' => 'required|array',
                        'national' => 'required|integer',
                        'international' => 'required|integer',
                        'faculty_member_id.*' => 'integer|exists:users,id',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                         $data = [
                            'indicator_id' => $request->indicator_id,
                            'target'=>$request->target,
                            'form_status' => $request->form_status,
                            'scopus_q1' => $request->scopus_q1,
                            'scopus_q2' => $request->scopus_q2,
                            'scopus_q3' => $request->scopus_q3,
                            'scopus_q4' => $request->scopus_q4,
                            'hec_w' => $request->hec_w,
                            'hec_x' => $request->hec_x,
                            'hec_y' => $request->hec_y,
                            'medical_recognized' => $request->medical_recognized,
                            'national' => $request->national,
                            'international' => $request->international,
                            'created_by' => $employeeId,
                            'updated_by' => $employeeId,
                        ];
                        DB::beginTransaction();
                        foreach ($request->faculty_member_id as $userId) {
                                FacultyTarget::create(array_merge($data, [
                                    'user_id' => $userId,
                                ]));
                            }
               
                       
                        DB::commit();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Form saved successfully!',
                        ]);
                       
            }if($request->form_status=='OTHER'){
                     $rules = [
                        'indicator_id' => 'required|array',
                        'indicator_id.*' => 'integer',
                        'faculty_member_id' => 'required|array',
                        'target' => 'required|integer',
                        'faculty_member_id.*' => 'integer|exists:users,id',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                     $data = [
                            'target'=>$request->target,
                            'form_status' => $request->form_status,
                            'created_by' => $employeeId,
                            'updated_by' => $employeeId,
                        ];
                        DB::beginTransaction();

                            foreach ($request->faculty_member_id as $userId) {
                                foreach ($request->indicator_id as $indicatorId) {

                                    // ✅ CHECK IF ALREADY ASSIGNED
                                    $existing = FacultyTarget::with(['user', 'indicator'])
                                        ->where('user_id', $userId)
                                        ->where('indicator_id', $indicatorId)
                                        ->first();

                                    if ($existing) {
                                    DB::rollBack();
                                    return response()->json([
                                        'status' => 'error',
                                        'message' => "{$existing->user->name} is already assigned to {$existing->indicator->indicator}.",
                                        'details' => [
                                            'faculty_member_id' => $userId,
                                            'indicator_id'      => $indicatorId
                                        ]
                                    ], 409);
                                }

                                    // ✅ CREATE NEW RECORD
                                    FacultyTarget::create(array_merge($data, [
                                        'user_id'      => $userId,
                                        'indicator_id' => $indicatorId,
                                    ]));
                                }
                            }
               
                       
                        DB::commit();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Form saved successfully!',
                        ]);    
            }

           

        } catch (\Exception $e) {
            DB::rollBack();
            // return response()->json([
            //     'message' => 'Oops! Something went wrong',
            //     'error' => $e->getMessage()
            // ], 500);
            return response()->json([
            'message' => 'Oops! Something went wrong'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FacultyTarget $facultyTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FacultyTarget $facultyTarget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6'
        ]);

        $target = FacultyTarget::findOrFail($id);
        $target->status = $request->status;
        $target->updated_by = Auth::id();
        $target->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacultyTarget $facultyTarget)
    {
        //
    }
    // app/Http/Controllers/FacultyTargetController.php
    public function getTarget11(Request $request)
    {
        $record = FacultyTarget::where('indicator_id', $request->indicator_id)
                    ->where('user_id', 45433)
                    ->first(); // ✅ No error if not found

        return response()->json([
            'target' => $record ? $record->target : null
        ]);
    }

    public function getTarget(Request $request)
    {
        $employeeId = Auth::user()->employee_id;
        $record = FacultyTarget::where('indicator_id', $request->indicator_id)
             ->where('user_id', $employeeId)
            ->first();

        return response()->json([
            'target' => $record ? $record->target : null,
            'data' => $record
        ]);
    }

}
