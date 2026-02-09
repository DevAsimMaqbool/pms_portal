<?php

namespace App\Http\Controllers;

use App\Models\ReportedIncidentCompliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportedIncidentComplianceController extends Controller
{
    public function store(Request $request)
    {
        try { 
            if($request->form_status=='HOD'){
                 $rules = [
                        'indicator_id' => 'required',
                        'total_reported_incidents' => 'nullable|integer',
                        'academic_misconduct_cases' => 'nullable|integer',
                        'administrative_breaches' => 'nullable|integer',
                        'governance_protocol_violations' => 'nullable|integer',
                        'severity_level' => 'required|in:Low,Medium,High',
                        'evidence_case_reference' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx',
                        'remarks' => 'nullable|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'evidence_case_reference.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'total_reported_incidents',
                            'academic_misconduct_cases',
                            'administrative_breaches',
                            'governance_protocol_violations',
                            'severity_level',
                            'remarks',
                            'form_status'
                        ]); 
                    if ($request->hasFile('evidence_case_reference')) {

                        $file = $request->file('evidence_case_reference');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('reportedIncidentCompliance', $fileName, 'public');
                        $data['evidence_case_reference'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = ReportedIncidentCompliance::create($data);
                       
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
