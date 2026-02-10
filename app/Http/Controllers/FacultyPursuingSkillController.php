<?php

namespace App\Http\Controllers;

use App\Models\FacultyPursuingSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyPursuingSkillController extends Controller
{
     public function store(Request $request)
    {
        try { 
            if($request->form_status=='HOD'){
                 $rules = [
                        'indicator_id' => 'required',
                        'total_faculty' => 'nullable|integer|min:0',
                        'faculty_in_cpd_activities' => 'nullable|integer|min:0',

                        'cpd_type'   => 'nullable|array',
                        'cpd_type.*' => 'string',

                        'evidence_reference' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                        'remarks'            => 'nullable|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'evidence_reference.mimes' => 'Upload JPG / PNG / PDF only.',
                    ];

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }
                        $data = $request->only([
                            'indicator_id',
                            'total_faculty',
                            'faculty_in_cpd_activities',
                            'cpd_type',
                            'remarks',
                            'form_status'
                        ]); 
                    if ($request->hasFile('evidence_reference')) {

                        $file = $request->file('evidence_reference');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('facultyPursuingSkill', $fileName, 'public');
                        $data['evidence_reference'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = FacultyPursuingSkill::create($data);
                       
                        DB::commit();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Form saved successfully!',
                            'data' => $research
                        ]);
                       
            }
           

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
            'message' => 'Oops! Something went wrong'], 500);
        }
    }
}
