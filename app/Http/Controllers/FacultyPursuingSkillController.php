<?php

namespace App\Http\Controllers;

use App\Models\FacultyPursuingSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FacultyPursuingSkillController extends Controller
{
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

         if ($user->hasRole('HOD')) {
                $status = $request->input('status');
                if($status=="HOD"){
                    $forms = FacultyPursuingSkill::where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->map(function ($form) {
                                if ($form->evidence_reference) {
                                    $form->evidence_reference = Storage::url($form->evidence_reference);
                                }
                                return $form;
                            });
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
    
     public function store(Request $request)
    {
        try { 
            if($request->form_status=='HOD'){
                 $rules = [
                        'indicator_id' => 'required',
                        'cpd_type.*' => 'required|string',
                        'cpd_other_detail' => 'required_if:cpd_type.*,Other|nullable|string|max:255',
                        'evidence_reference' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                        'remarks'            => 'nullable|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'evidence_reference.mimes' => 'Upload JPG / PNG / PDF only.',
                        'cpd_other_detail.required_if' => 'The Other Detail field is required when "Other" is selected.',
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
                            'cpd_type',
                            'cpd_other_detail',
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
    public function update(Request $request, $id)
    {   
        $record = FacultyPursuingSkill::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'cpd_type.*' => 'required|string',
                'cpd_other_detail' => 'required_if:cpd_type.*,Other|nullable|string|max:255',
                'evidence_reference' => '',
                'remarks'            => 'nullable|string',    
        ]);

        $data = $request->only([
                        'cpd_type', 'cpd_other_detail', 'evidence_reference', 'remarks'
                    ]);
                    if ($request->hasFile('evidence_reference')) {
                         
                            if ($record->evidence_reference && Storage::disk('public')->exists($record->evidence_reference)) {
                                Storage::disk('public')->delete($record->evidence_reference);
                            }

                            $file = $request->file('evidence_reference');
                            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                            $uniqueNumber = rand(1000, 9999);
                            $extension = $file->getClientOriginalExtension();
                            $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                            $path = $file->storeAs('facultyPursuingSkill', $fileName, 'public');
                            $data['evidence_reference'] = $path;
                        }
                    $data['updated_by'] = Auth::user()->employee_id;

                    $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
    }
       public function destroy($id)
    {
        $record = FacultyPursuingSkill::findOrFail($id);
        // ✅ Delete file from storage if exists
        if ($record->evidence_reference &&
            Storage::disk('public')->exists($record->evidence_reference)) {

            Storage::disk('public')->delete($record->evidence_reference);
        }

        $record->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
