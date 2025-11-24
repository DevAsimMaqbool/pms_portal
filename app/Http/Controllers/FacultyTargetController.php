<?php

namespace App\Http\Controllers;

use App\Models\FacultyTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function update(Request $request, FacultyTarget $facultyTarget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FacultyTarget $facultyTarget)
    {
        //
    }
}
