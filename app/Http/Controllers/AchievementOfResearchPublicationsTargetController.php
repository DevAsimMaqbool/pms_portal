<?php

namespace App\Http\Controllers;

use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AchievementOfResearchPublicationsTargetController extends Controller
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
                    if($status=="HOD"){
                           $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $hod_ids)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->email_screenshot) {
                                    $form->email_screenshot_url = Storage::url($form->email_screenshot);
                                }
                                return $form;
                            });
                    }
                    if($status=="RESEARCHER"){
                        $teacher_id = User::whereIn('manager_id', $hod_ids)
                        ->role('Teacher')->pluck('employee_id');
                          $all_ids = $teacher_id->merge($hod_ids);
                          $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [3, 2])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->email_screenshot) {
                                    $form->email_screenshot_url = Storage::url($form->email_screenshot);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('HOD')) {
                $employeeIds = User::where('manager_id', $employee_id)
                    ->role('Teacher')->pluck('employee_id');
                    $forms = AchievementOfResearchPublicationsTarget::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                         ->whereIn('created_by', $employeeIds)
                        ->whereIn('status', [1, 2])
                        ->where('form_status', 'RESEARCHER')
                        ->get()
                        ->map(function ($form) {
                            if ($form->email_screenshot) {
                                $form->email_screenshot_url = Storage::url($form->email_screenshot);
                            }
                            return $form;
                        });
                
            }if ($user->hasRole('ORIC')) {
                $status = $request->input('status');
                    if($status=="HOD"){
                           $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [2, 3])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->email_screenshot) {
                                    $form->email_screenshot_url = Storage::url($form->email_screenshot);
                                }
                                return $form;
                            });
                    }
                    if($status=="RESEARCHER"){
                          $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [4, 3])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->email_screenshot) {
                                    $form->email_screenshot_url = Storage::url($form->email_screenshot);
                                }
                                return $form;
                            });
                    }

            }if ($user->hasRole('Human Resources')) {
                   $status = $request->input('status');
                    if($status=="HOD"){
                           $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('status', [3, 4])
                            ->where('form_status', $status)
                            ->get()
                            ->map(function ($form) {
                                if ($form->email_screenshot) {
                                    $form->email_screenshot_url = Storage::url($form->email_screenshot);
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
                        'target_category' => 'required|string',
                        'target_of_publications' => 'required|string',
                        'progress_on_publication' => 'required|string',
                        'draft_stage' => 'required_if:progress_on_publication,At draft stage|string|nullable',
                        'email_screenshot' => 'required_if:progress_on_publication,In Review|file|mimes:jpg,jpeg,png,pdf|max:2048',
                        'scopus_link' => 'required_if:progress_on_publication,Published|nullable|url',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'scopus_link.url' => 'Please provide a valid URL for the Scopus link.',
                        'email_screenshot.mimes' => 'Upload JPG / PNG / PDF only.',
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
                            'target_category',
                            'target_of_publications',
                            'draft_stage',
                            'scopus_link',
                            'form_status'
                        ]);

                        if ($request->hasFile('email_screenshot')) {
                            $data['email_screenshot'] = $request->file('email_screenshot')->store('screenshots', 'public');
                        }
            }
            if($request->form_status=='HOD'){
                  $rules = [
                        'kpa_id' => 'required',
                        'sp_category_id' => 'required',
                        'indicator_id' => 'required',
                        'faculty_member_id' => 'required|exists:users,id',
                        'target_category' => 'required|string|in:Scopus-Indexed,HEC',
                        'target_of_publications' => 'required|string|max:255',
                        'capacity_building' => 'required|boolean',
                        'need' => 'required_if:capacity_building,1|string|nullable',
                        'any_specifics_related_to_capacity_building' => 'nullable|string|max:500',
                        'frequency' => 'nullable|integer|min:0',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                            'faculty_member_id.required' => 'Please select a faculty member.',
                            'need.required_if' => 'You must select a need when capacity building is required.',
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
                            'faculty_member_id',
                            'target_category',
                            'target_of_publications',
                            'capacity_building',
                            'need',
                            'any_specifics_related_to_capacity_building',
                            'frequency',
                            'form_status'
                        ]);    

            }
            $employeeId = Auth::user()->employee_id;
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = AchievementOfResearchPublicationsTarget::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {

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

        $target = AchievementOfResearchPublicationsTarget::findOrFail($id);
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
  public function getPublicationTarget(Request $request)
{
    try {
        $userId = Auth::id();

        $query = AchievementOfResearchPublicationsTarget::where('faculty_member_id', $userId)
            ->where('form_status', 'HOD');

        if ($request->has('target_category')) {
            $query->where('target_category', $request->target_category);
        }

        $target = $query->first();

        if ($target) {
            return response()->json([
                'success' => true,
                'target_category' => $target->target_category,
                'target_of_publications' => $target->target_of_publications,
            ]);
        }

        return response()->json(['success' => false]);
    } catch (\Exception $e) {
        // if error, still return JSON
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


}
