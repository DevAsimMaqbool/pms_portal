<?php

namespace App\Http\Controllers;

use App\Models\QecAuditRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class QecAuditRatingController extends Controller
{
    public function store(Request $request)
    {
        try { 
            $employeeId = Auth::user()->employee_id;
            if($request->form_status=='HOD'){
               
                  $rules = [
                        'indicator_id' => 'required|integer',
                        'audits' => 'required|array|min:1',
                        'audits.*.audit_term' => 'required',
                        'audits.*.faculty_id' => 'required',
                        'audits.*.department_id' => 'required',
                        'audits.*.program_id' => 'required',
                        'audits.*.program_level' => 'required',
                        'audits.*.total_score' => 'required',
                        'audits.*.obtained_score' => 'required',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'audits.*.faculty_id.required' => 'Faculty is required.',
                        'audits.*.department_id.required' => 'Department is required.',
                        'audits.*.program_id.required' => 'Program is required.',
                        'audits.*.program_level.required' => 'Program level is required.',
                    ];


                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                    }
                    $savedRecords = [];
                    foreach ($request->audits as $index => $audits) {



                        $savedRecords[] = QecAuditRating::create([
                            'indicator_id'   => $request->indicator_id,
                            'audit_term'           => $audits['audit_term'],
                            'faculty_id' => $audits['faculty_id'],
                            'department_id'         => $audits['department_id'],
                            'program_id'           => $audits['program_id'],
                            'program_level'   => $audits['program_level'],
                            'total_score'   => $audits['total_score'],
                            'obtained_score'   => $audits['obtained_score'],
                            'form_status'    => $request->form_status ?? 'HOD',
                            'created_by'     => $employeeId,
                            'updated_by'     => $employeeId,
                        ]);
                    }

                    return response()->json([ 'status' => 'success','message' => 'Data saved successfully', 'data' => $savedRecords], 201);   
            }

        } catch (\Exception $e) {
               return response()->json(['status' => 'error', 'message' => 'Failed to save records','error' => $e->getMessage()], 500);
        }
    }
}
