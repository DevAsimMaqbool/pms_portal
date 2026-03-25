<?php

namespace App\Http\Controllers;

use App\Models\IndustrialVisit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IndustrialVisitController extends Controller
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

            if(in_array(getRoleName(activeRole()), ['Dean'])) {
                   $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role(['Teacher','Professor','Assistant Professor','Associate Professor'])->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = IndustrialVisit::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                if ($form->evidence_upload) {
                                    $form->evidence_upload = Storage::url($form->evidence_upload);
                                }
                                return $form;
                            });
                    }

            }
            if(in_array(getRoleName(activeRole()), ['HOD','Teacher','Professor','Assistant Professor','Associate Professor'])) {
                $status = $request->input('status');
                if($status=="Teacher"){
                        $forms = IndustrialVisit::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->map(function ($form) {
                                    if ($form->evidence_upload) {
                                        $form->evidence_upload = Storage::url($form->evidence_upload);
                                    }
                                    return $form;
                                });
                }


                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                        ->role(['Teacher','Professor','Assistant Professor','Associate Professor'])->pluck('employee_id');
                        $all_ids = $employeeIds->merge($employee_id);
                        $forms = IndustrialVisit::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                    if ($form->evidence_upload) {
                                        $form->evidence_upload = Storage::url($form->evidence_upload);
                                    }
                                    return $form;
                                });
                        }            

                
            }
            if(in_array(getRoleName(activeRole()), ['ORIC'])) {
                $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = IndustrialVisit::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [2, 3])
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                if ($form->evidence_upload) {
                                    $form->evidence_upload = Storage::url($form->evidence_upload);
                                }
                                return $form;
                            });
                    }

            }
            if(in_array(getRoleName(activeRole()), ['Human Resources'])) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = IndustrialVisit::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'Projects'
                            ])
                            ->whereIn('status', [3, 4])
                            ->where('form_status', $status)
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
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        'indicator_id' => 'required',
                        'employee_name' => 'required',
                        'employee_id' => 'required',
                        'designation' => 'required',
                        'department_program' => 'required',
                        'campus_unit' => 'required',
                        'report_submission_date'=>'required',
                        'industry_organization' => 'required',
                        'industry_sector' => 'required',
                        'purpose_learning_objective' => 'required',
                        'course_subject' => 'required',
                        'students_involved' => 'required|integer',
                        'employee_role' => 'required',
                        'visit_category' => 'required',
                        'visit_start_date' => 'required|date',
                        'visit_end_date' => 'required|date',
                        'location' => 'required',
                        'visit_report_submitted' => 'required',
                        'evidence_upload' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'evidence_upload.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'employee_name',
                            'employee_id',
                            'designation',
                            'department_program',
                            'campus_unit',
                            'report_submission_date',
                            'industry_organization',
                            'industry_sector',
                            'purpose_learning_objective',
                            'course_subject',
                            'students_involved',
                            'employee_role',
                            'visit_category',
                            'visit_start_date',
                            'visit_end_date',
                            'location',
                            'visit_report_submitted',
                            'form_status'
                        ]); 
                    if ($request->hasFile('evidence_upload')) {

                        $file = $request->file('evidence_upload');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('industrialvisit', $fileName, 'public');
                        $data['evidence_upload'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = IndustrialVisit::create($data);
                       
                        DB::commit();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Form saved successfully!',
                            'data' => $research
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
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6'
        ]);

        $target = IndustrialVisit::findOrFail($id);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updateIndustrialVisit(Request $request, $id)
    {

        $record = IndustrialVisit::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'employee_name' => 'required',
                'employee_id' => 'required',
                'designation' => 'required',
                'department_program' => 'required',
                'campus_unit',
                'report_submission_date',
                'industry_organization' => 'required',
                'industry_sector' => 'required',
                'purpose_learning_objective' => 'required',
                'course_subject' => 'required',
                'students_involved' => 'required|integer',
                'employee_role' => 'required',
                'visit_category' => 'required',
                'visit_start_date' => 'required|date',
                'visit_end_date' => 'required|date',
                'location' => 'required',
                'visit_report_submitted' => 'required',
                'evidence_upload' => '',
            
        ]);

        $data = $request->only([
                        'employee_name',
                        'employee_id',
                        'designation',
                        'department_program',
                        'campus_unit',
                        'report_submission_date',
                        'industry_organization',
                        'industry_sector',
                        'purpose_learning_objective',
                        'course_subject',
                        'students_involved',
                        'employee_role',
                        'visit_category',
                        'visit_start_date',
                        'visit_end_date',
                        'location',
                        'visit_report_submitted',
                    ]);
                    if ($request->hasFile('evidence_upload')) {

                        // Delete old file if exists
                        if ($record->evidence_upload && Storage::disk('public')->exists($record->evidence_upload)) {
                            Storage::disk('public')->delete($record->evidence_upload);
                        }

                        $file = $request->file('evidence_upload');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('industrialvisit', $fileName, 'public');
                        $data['evidence_upload'] = $path;
                    }  
                    $data['updated_by'] = Auth::user()->employee_id;

                    $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
    }
}
