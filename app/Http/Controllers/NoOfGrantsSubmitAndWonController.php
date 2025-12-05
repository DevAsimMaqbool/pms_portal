<?php

namespace App\Http\Controllers;

use App\Models\NoOfGrantsSubmitAndWon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NoOfGrantsSubmitAndWonController extends Controller
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
                          $forms = NoOfGrantsSubmitAndWon::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                if ($form->proof) {
                                    $form->proof = Storage::url($form->proof);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('HOD')) {
                $employeeIds = User::where('manager_id', $employee_id)
                    ->role('Teacher')->pluck('employee_id');
                    $forms = NoOfGrantsSubmitAndWon::with([
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
                                if ($form->proof) {
                                    $form->proof = Storage::url($form->proof);
                                }
                                return $form;
                            });
                
            }if ($user->hasRole('ORIC')) {
                $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = NoOfGrantsSubmitAndWon::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [2, 3])
                            ->where('form_status', $status)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->map(function ($form) {
                                if ($form->proof) {
                                    $form->proof = Storage::url($form->proof);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('Human Resources')) {
                $status = $request->input('status');
                     if($status=="HOD"){
                           $forms = NoOfGrantsSubmitAndWon::with([
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try { 
            $employeeId = Auth::user()->employee_id;
            if($request->form_status=='RESEARCHER'){
               
                  $rules = [
                        'indicator_id' => 'required|integer',
                        'grants' => 'required|array|min:1',
                        'grants.*.name' => 'required|string',
                        'grants.*.funding_agency' => 'required|string',
                        'grants.*.volume' => 'required|string',
                        'grants.*.role' => 'required|string',
                        'grants.*.grant_status' => 'required|string',
                        'grants.*.proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'grants.*.name.required' => 'Name Of Grant is required.',
                        'grants.*.funding_agency.required' => 'Funding Agency is required.',
                        'grants.*.volume.required' => 'Grant Volume is required.',
                        'grants.*.proof.mimes' => 'Upload JPG / PNG / PDF only.',
                    ];


                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                    }
                    $savedRecords = [];
                    foreach ($request->grants as $index => $grant) {

                        $filename = null;

                        if (isset($grant['proof']) && $grant['proof']) {

                            $file = $grant['proof'];

                            // ORIGINAL NAME WITHOUT EXTENSION
                            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                            // REMOVE INVALID CHARACTERS
                            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                            // RANDOM 4-DIGIT NUMBER
                            $uniqueNumber = rand(1000, 9999);

                            // EXTENSION
                            $extension = $file->getClientOriginalExtension();

                            // FINAL NAME: example → "misdoc_2345.pdf"
                            $filename = $safeName . '_' . $uniqueNumber . '.' . $extension;

                            // STORE FILE
                            $path = $file->storeAs('grants', $filename, 'public');

                            // SAVE FILE PATH
                            $filename = $path;
                        }

                        $savedRecords[] = NoOfGrantsSubmitAndWon::create([
                            'indicator_id'   => $request->indicator_id,
                            'name'           => $grant['name'],
                            'funding_agency' => $grant['funding_agency'],
                            'volume'         => $grant['volume'],
                            'role'           => $grant['role'],
                            'grant_status'   => $grant['grant_status'],
                            'proof'          => $filename, // PATH STORED
                            'form_status'    => $request->form_status ?? 'RESEARCHER',
                            'status'         => 1,
                            'created_by'     => $employeeId,
                            'updated_by'     => $employeeId,
                        ]);
                    }

                    return response()->json([ 'status' => 'success','message' => 'Co-authored papers saved successfully', 'data' => $savedRecords], 201);   
            }

        } catch (\Exception $e) {
               return response()->json(['status' => 'error', 'message' => 'Failed to save records','error' => $e->getMessage()], 500);
        }
    }

     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6'
        ]);

        $target = NoOfGrantsSubmitAndWon::findOrFail($id);

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
}
