<?php

namespace App\Http\Controllers;

use App\Models\InternationalCoauthoredPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InternationalCoauthoredPaperController extends Controller
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
                          $forms = InternationalCoauthoredPaper::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])->whereIn('created_by', $all_ids)->whereIn('status', [3,2])
                            ->where('form_status', $status)->get();
                    }

            }if ($user->hasRole('HOD')) {
                $status = $request->input('status');
                   $hod_ids = User::where('manager_id', $employee_id)
                   ->role(['Teacher','HOD'])->pluck('employee_id');
                    if($status=="RESEARCHER"){
                          $forms = InternationalCoauthoredPaper::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])->whereIn('created_by', $hod_ids)->whereIn('status', [1, 2])
                            ->where('form_status', $status)->get();
                    }
                
            }if ($user->hasRole('ORIC')) {
                 $status = $request->input('status');
                    if($status=="RESEARCHER"){
                          $forms = InternationalCoauthoredPaper::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])->whereIn('status', [4,3])
                            ->where('form_status', $status)->get();
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
            $employeeId = Auth::user()->employee_id;
            if($request->form_status=='RESEARCHER'){
                  $rules = [
                        'kpa_id' => 'required|integer',
                        'sp_category_id' => 'required|integer',
                        'indicator_id' => 'required|integer',
                        'papers' => 'required|array|min:1',
                        'papers.*.name_of_co_authers' => 'required|string',
                        'papers.*.author_rank' => 'required|string',
                        'papers.*.name_of_university_country' => 'required|string',
                        'papers.*.designation' => 'required|string',
                        'papers.*.no_of_papers_past' => 'required|integer',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                    $messages = [
                        'papers.*.name_of_co_authers.required' => 'Name of co-author is required.',
                        'papers.*.author_rank.required' => 'Author rank is required.',
                        'papers.*.name_of_university_country.required' => 'University & Country is required.',
                        'papers.*.no_of_papers_past.required' => 'No of past papers is required.',
                    ];


                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()) {
                            return response()->json([
                                'status' => 'error',
                                'errors' => $validator->errors()
                            ], 422);
                    }
                    $savedRecords = [];
                    foreach ($request->papers as $paper) {
                        $paper['kpa_id'] = $request->kpa_id;
                        $paper['sp_category_id'] = $request->sp_category_id;
                        $paper['indicator_id'] = $request->indicator_id;
                        $paper['form_status'] = $request->form_status ?? 'RESEARCHER';
                        $paper['created_by'] = $employeeId;
                        $paper['updated_by'] = $employeeId;

                        $savedRecords[] = InternationalCoauthoredPaper::create($paper);
                    }
                    return response()->json([ 'status' => 'success','message' => 'Co-authored papers saved successfully', 'data' => $savedRecords], 201);   
            }

        } catch (\Exception $e) {
               return response()->json(['status' => 'error', 'message' => 'Failed to save records','error' => $e->getMessage()], 500);
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

        $target = InternationalCoauthoredPaper::findOrFail($id);
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
