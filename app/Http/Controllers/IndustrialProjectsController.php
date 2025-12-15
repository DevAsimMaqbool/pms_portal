<?php

namespace App\Http\Controllers;

use App\Models\IndustrialProjects;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IndustrialProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         try {
            $user = Auth::user();
            $userId = Auth::id();
            $employee_id = $user->employee_id;

            if ($user->hasRole('Dean')) {
                   $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role('Teacher')->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = IndustrialProjects::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                if ($form->attachment) {
                                    $form->attachment = Storage::url($form->attachment);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('HOD') || $user->hasRole('Teacher')) {
                $status = $request->input('status');
                if($status=="Teacher"){
                    $forms = IndustrialProjects::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                         ->where('created_by', $employee_id)
                        ->orderBy('id', 'desc')
                        ->get()
                        ->map(function ($form) {
                                if ($form->attachment) {
                                    $form->attachment = Storage::url($form->attachment);
                                }
                                return $form;
                            });
                }
                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                    ->role('Teacher')->pluck('employee_id');
                    $forms = IndustrialProjects::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                         ->whereIn('created_by', $employeeIds)
                        ->whereIn('status', [1, 2])
                        ->where('form_status', 'RESEARCHER')
                        ->orderBy('id', 'desc')
                        ->get()
                        ->map(function ($form) {
                                if ($form->attachment) {
                                    $form->attachment = Storage::url($form->attachment);
                                }
                                return $form;
                            });
                }
                
            }if ($user->hasRole('ORIC')) {
                $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = IndustrialProjects::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [2, 3])
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                if ($form->attachment) {
                                    $form->attachment = Storage::url($form->attachment);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('Human Resources')) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = IndustrialProjects::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
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
                        'project_name' => 'required|string|max:255',
                        'contracting_industry' => 'required|string|max:255',
                        'project_duration' => 'required|integer',
                        'estimated_project_cost' => 'required|integer',
                        'estimated_complection' => 'required|date',
                        'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'attachment.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'project_name',
                            'contracting_industry',
                            'project_duration',
                            'estimated_project_cost',
                            'estimated_complection',
                            'form_status'
                        ]); 
                    if ($request->hasFile('attachment')) {

                        $file = $request->file('attachment');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('industrialProject', $fileName, 'public');
                        $data['attachment'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = IndustrialProjects::create($data);
                       
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
    public function show(IndustrialProjects $industrialProjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndustrialProjects $industrialProjects)
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

        $target = IndustrialProjects::findOrFail($id);

        // Get current update history
        $history = $target->update_history ? json_decode($target->update_history, true) : [];


        // Get current user info
        $currentUserId = Auth::id();
        $currentUserName = Auth::user()->name;
        $userRoll = Auth::user()->getRoleNames()->first() ?? 'N/A';

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
    public function destroy(IndustrialProjects $industrialProjects)
    {
        //
    }
    public function updateIndustrialProjectsProject(Request $request, $id)
    {

        $record = IndustrialProjects::findOrFail($id);

        $request->validate([
                'record_id' => 'required',
                'project_name' => 'required|string|max:255',
                'contracting_industry' => 'required|string|max:255',
                'project_duration' => 'required|integer',
                'estimated_project_cost' => 'required|integer',
                'estimated_complection' => 'required|date',
                'attachment' => '',
            
        ]);

        $data = $request->only([
                        'project_name', 'contracting_industry', 'project_duration', 'estimated_project_cost',
                        'estimated_complection'
                    ]);
                     if ($request->hasFile('attachment')) {

                        // Delete old file if exists
                        if ($record->attachment && Storage::disk('public')->exists($record->attachment)) {
                            Storage::disk('public')->delete($record->attachment);
                        }

                        $file = $request->file('attachment');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('industrialProject', $fileName, 'public');
                        $data['attachment'] = $path;
                    }    
                    $data['updated_by'] = Auth::user()->employee_id;

                    $record->update($data);

                    return response()->json(['status' => 'success','message' => 'Record updated successfully', 'data' => $record]);
    }
}
