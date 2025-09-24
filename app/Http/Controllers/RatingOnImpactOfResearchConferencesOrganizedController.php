<?php

namespace App\Http\Controllers;

use App\Models\RatingOnImpactOfResearchConferencesOrganized;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RatingOnImpactOfResearchConferencesOrganizedController extends Controller
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
                          $forms = RatingOnImpactOfResearchConferencesOrganized::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->scopus_indexed_confirmation) {
                                    $form->scopus_indexed_confirmation_url = Storage::url($form->scopus_indexed_confirmation);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('ORIC')) {
                
                   $status = $request->input('status');
                    if($status=="RESEARCHER"){
                        $forms = RatingOnImpactOfResearchConferencesOrganized::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->whereIn('status', [2, 3])
                        ->where('form_status', $status)
                        ->get()
                        ->map(function ($form) {
                                if ($form->scopus_indexed_confirmation) {
                                    $form->scopus_indexed_confirmation_url = Storage::url($form->scopus_indexed_confirmation);
                                }
                                return $form;
                            });
                    }
            }if ($user->hasRole('Human Resources')) {
                   $status = $request->input('status');
                    if($status=="RESEARCHER"){
                           $forms = RatingOnImpactOfResearchConferencesOrganized::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [3, 4])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->scopus_indexed_confirmation) {
                                    $form->scopus_indexed_confirmation_url = Storage::url($form->scopus_indexed_confirmation);
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
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'conference_target' => 'required|string',
                        'event_proposal_form_submission' => 'required|string',
                        'scopus_indexed_confirmation' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'scopus_indexed_confirmation.mimes' => 'Upload JPG / PNG / PDF only.',
                    ];

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                        }

                        $data = $request->only([
                            'kpa_id',
                            'sp_category_id',
                            'indicator_id',
                            'conference_target',
                            'event_proposal_form_submission',
                            'form_status'
                        ]);

                        if ($request->hasFile('scopus_indexed_confirmation')) {
                            $data['scopus_indexed_confirmation'] = $request->file('scopus_indexed_confirmation')->store('scopus_index', 'public');
                        }
            }
            $employeeId = Auth::user()->employee_id;
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = RatingOnImpactOfResearchConferencesOrganized::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
                 return response()->json([
                'message' => 'Oops! Something went wrong',
                'error' => $e->getMessage()
            ], 500);
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

        $target = RatingOnImpactOfResearchConferencesOrganized::findOrFail($id);
        $target->status = $request->status;
        $target->updated_by = Auth::id();
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
