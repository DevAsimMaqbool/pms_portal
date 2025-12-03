<?php

namespace App\Http\Controllers;

use App\Models\CommercialGainsCounsultancyResearchIncome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CommercialGainsCounsultancyResearchIncomeController extends Controller
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

            if ($user->hasRole('Dean')) {
                   $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role('HOD')->pluck('employee_id');
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role('Teacher')->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [3, 2])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->consultancy_file) {
                                    $form->consultancy_file = Storage::url($form->consultancy_file);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('HOD') || $user->hasRole('Teacher')) {
                $status = $request->input('status');
                if($status=="Teacher"){
                        $forms = CommercialGainsCounsultancyResearchIncome::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->where('created_by', $employee_id)
                        ->get()
                        ->map(function ($form) {
                                    if ($form->consultancy_file) {
                                        $form->consultancy_file = Storage::url($form->consultancy_file);
                                    }
                                    return $form;
                                });
                }


                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                        ->role('Teacher')->pluck('employee_id');
                        $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $employeeIds)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')
                            ->get()
                            ->map(function ($form) {
                                    if ($form->consultancy_file) {
                                        $form->consultancy_file = Storage::url($form->consultancy_file);
                                    }
                                    return $form;
                                });
                        }            

                
            }if ($user->hasRole('ORIC')) {
                $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [4, 3])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->consultancy_file) {
                                    $form->consultancy_file = Storage::url($form->consultancy_file);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('Human Resources')) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = CommercialGainsCounsultancyResearchIncome::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'Projects'
                            ])
                            ->whereIn('status', [3, 4])
                            ->where('form_status', $status)
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
                        'title_of_consultancy' => 'required|string',
                        'duration_of_consultancy' => 'required|string',
                        'name_of_client_organization' => 'required|string',
                        'consultancy_fee' => 'required|numeric|min:0',
                        'consultancy_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];
                    $messages = [
                        'consultancy_file.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'title_of_consultancy',
                            'duration_of_consultancy',
                            'name_of_client_organization',
                            'consultancy_fee',
                            'form_status'
                        ]); 
                    if ($request->hasFile('consultancy_file')) {

                        $file = $request->file('consultancy_file');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('consultancy_file', $fileName, 'public');
                        $data['consultancy_file'] = $path;
                    }
                       $employeeId = Auth::user()->employee_id;
                        DB::beginTransaction();
                        $data['created_by'] = $employeeId;
                        $data['updated_by'] = $employeeId;
                        $research = CommercialGainsCounsultancyResearchIncome::create($data);
                       
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

        $target = CommercialGainsCounsultancyResearchIncome::findOrFail($id);

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
    public function destroy(string $id)
    {
        //
    }
}
