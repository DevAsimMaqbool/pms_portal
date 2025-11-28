<?php

namespace App\Http\Controllers;

use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\AchievementOfResearchPublicationTargetCoAuthor;
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
                                },'coAuthors:id,target_id,name,rank,country,designation'
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [3, 2])
                            ->where('form_status', $status)
                            ->get();
                    }

            }if ($user->hasRole('HOD') || $user->hasRole('Teacher')) {

                $status = $request->input('status');
                if($status=="Teacher"){
                        $forms = AchievementOfResearchPublicationsTarget::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            },'coAuthors:id,target_id,name,rank,country,designation'
                        ])
                        ->where('created_by', $employee_id)
                        ->get();
                }

                if($status=="HOD"){
                    $employeeIds = User::where('manager_id', $employee_id)
                        ->role('Teacher')->pluck('employee_id');
                        $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'coAuthors:id,target_id,name,rank,country,designation'
                            ])
                            ->whereIn('created_by', $employeeIds)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', 'RESEARCHER')
                            ->get();
                        }        
                
            }if ($user->hasRole('ORIC')) {
                          $forms = AchievementOfResearchPublicationsTarget::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                },'coAuthors:id,target_id,name,rank,country,designation'
                            ])
                            ->whereIn('status', [4, 3])
                            ->where('form_status', 'RESEARCHER')
                            ->get();

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
    public function store1(Request $request)
    {
        try { 
            if($request->form_status=='RESEARCHER'){
                 $rules = [
                        
                        'indicator_id' => 'required',
                        'target_category' => 'required|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        
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
    public function store(Request $request)
{
    try {
        $rules = [
            'indicator_id' => 'required|exists:indicators,id',
            'target_category' => 'required|string|max:255',
            'link_of_publications' => 'required|url|max:500',
            'rank' => 'required|integer|min:0',
            'nationality' => 'required|string|max:255',
            'as_author_your_rank' => 'required|integer|min:0',
            'scopus_q1' => 'nullable|integer|min:0',
            'scopus_q2' => 'nullable|integer|min:0',
            'scopus_q3' => 'nullable|integer|min:0',
            'scopus_q4' => 'nullable|integer|min:0',
            'hec_w' => 'nullable|integer|min:0',
            'hec_x' => 'nullable|integer|min:0',
            'hec_y' => 'nullable|integer|min:0',
            'medical_recognized' => 'nullable|integer|min:0',
            'co_author' => 'nullable|array',
            'co_author.*.name' => 'required_with:co_author|string|max:255',
            'co_author.*.rank' => 'required_with:co_author|integer|min:0',
            'co_author.*.univeristy_name' => 'required_with:co_author|string|max:255',
            'co_author.*.country' => 'required_with:co_author|string|max:255',
            'co_author.*.designation' => 'required_with:co_author|string|max:255',
            'co_author.*.no_paper_past' => 'required_with:co_author|integer|min:0',
            'co_author.*.first_author_superviser' => 'required_with:co_author|in:YES,NO',
            'co_author.*.student_roll_no' => 'required_with:co_author|string|max:50',
            'co_author.*.career' => 'required_with:co_author|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status'=>'error','errors'=>$validator->errors()], 422);
        }

        $employeeId = Auth::user()->employee_id;

        $targetData = $request->only([
            'indicator_id','target_category','link_of_publications','rank','nationality',
            'as_author_your_rank','scopus_q1','scopus_q2','scopus_q3','scopus_q4',
            'hec_w','hec_x','hec_y','medical_recognized','form_status','status'
        ]);
        $targetData['created_by'] = $employeeId;
        $targetData['updated_by'] = $employeeId;

        $target = AchievementOfResearchPublicationsTarget::create($targetData);

        if ($request->has('co_author')) {
            foreach ($request->co_author as $co) {
                $co['target_id'] = $target->id;
                $co['created_by'] = $employeeId;
                $co['updated_by'] = $employeeId;
                AchievementOfResearchPublicationTargetCoAuthor::create($co);
            }
        }

        return response()->json(['status'=>'success','message'=>'Record saved successfully','data'=>$target->load('coAuthors')]);

    } catch (\Exception $e) {
        return response()->json(['status'=>'error','message'=>$e->getMessage()], 500);
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
