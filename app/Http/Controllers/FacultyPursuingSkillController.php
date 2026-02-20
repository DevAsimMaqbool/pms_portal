<?php

namespace App\Http\Controllers;

use App\Models\FacultyPursuingSkill;
use App\Models\User;
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

        //  if ($user->hasRole('HOD')) {
        //         $status = $request->input('status');
        //         if($status=="HOD"){
        //             $forms = FacultyPursuingSkill::where('created_by', $employee_id)
        //                 ->orderBy('id', 'desc')
        //                 ->get()
        //                 ->map(function ($form) {
        //                         if ($form->evidence_reference) {
        //                             $form->evidence_reference = Storage::url($form->evidence_reference);
        //                         }
        //                         return $form;
        //                     });
        //         }       
        //     }





            if ($user->hasRole('Dean')) {
                   $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role('Teacher')->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = FacultyPursuingSkill::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()->map(function ($form) {
                                if ($form->evidence_reference) {
                                    $form->evidence_reference = Storage::url($form->evidence_reference);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('HOD') || $user->hasRole('Teacher')) {
                $status = $request->input('status');
                if($status=="Teacher"){
                    $forms = FacultyPursuingSkill::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()->map(function ($form) {
                                if ($form->evidence_reference) {
                                    $form->evidence_reference = Storage::url($form->evidence_reference);
                                }
                                return $form;
                            });
                }
                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                        ->role('Teacher')->pluck('employee_id');
                        $forms = FacultyPursuingSkill::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $employeeIds)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')
                            ->orderBy('id', 'desc')
                            ->get()->map(function ($form) {
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
            if($request->form_status=='RESEARCHER'){
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
        try { 
            if ($request->has('status_update_data')) {
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
            if ($request->has('status_update')) {
                $request->validate([
                    'status' => 'required|in:1,2,3,4,5,6'
                ]);

                $target = FacultyPursuingSkill::findOrFail($id);

                // Get current update history
                $history = $target->update_history ? json_decode($target->update_history, true) : [];

                // Get current user info
                $currentUserId = Auth::id();
                $currentUserName = Auth::user()->name;
                $userRoll = getRoleName(activeRole()) ?? 'N/A';

                // Avoid duplicate consecutive updates by the same user with the same status
                $lastUpdate = end($history);
                if (!$lastUpdate || $lastUpdate['user_id'] != $currentUserId || $lastUpdate['status'] != $request->status) {
                    $history[] = [
                        'user_id'    => $currentUserId,
                        'user_name'  => $currentUserName,
                        'status'     => $request->status,
                        'role'     => $userRoll,
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }





                $target->status = $request->status;
                $target->update_history = json_encode($history);
                $target->updated_by = $currentUserId;
                $target->save();

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
             DB::rollBack();
             return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
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
