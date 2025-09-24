<?php

namespace App\Http\Controllers;

use App\Models\PublicationOfHecRecognizedJournal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PublicationOfHecRecognizedJournalController extends Controller
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
                          $forms = PublicationOfHecRecognizedJournal::with([
                                'creator' => function ($q) {
                                    $q->select('employee_id', 'name');
                                }
                            ])
                            ->whereIn('created_by', $all_ids)
                            ->whereIn('status', [1, 2])
                            ->where('form_status', $status)
                            ->get();
                    }

            }if ($user->hasRole('ORIC')) {
                
                   $status = $request->input('status');
                    if($status=="RESEARCHER"){
                        $forms = PublicationOfHecRecognizedJournal::with([
                            'creator' => function ($q) {
                                $q->select('employee_id', 'name');
                            }
                        ])
                        ->whereIn('status', [2, 3])
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
                        'name_of_journal' => 'required|string',
                        'approved_frequency_of_pub' => 'required|string',
                        'no_of_issues_published' => 'required|string',
                        'revenue_generated_under_apc' => 'required|string',
                        'no_of_indexing_prior_report' => 'required|string',
                        'new_indexing_done_quarter' => 'required|string',
                        'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                    ];

                     $messages = [
                        'required' => 'The :attribute field is required.',
                        'string'   => 'The :attribute must be a valid string.',
                        'in'       => 'The :attribute must be one of: HOD, RESEARCHER, DEAN, OTHER.',
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
                            'name_of_journal',
                            'approved_frequency_of_pub',
                            'no_of_issues_published',
                            'revenue_generated_under_apc',
                            'no_of_indexing_prior_report',
                            'new_indexing_done_quarter',
                            'form_status'
                        ]);

                        
            }
            $employeeId = Auth::user()->employee_id;
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = PublicationOfHecRecognizedJournal::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);

        } catch (\Exception $e) {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Something went wrong: ' . $e->getMessage()
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

        $target = PublicationOfHecRecognizedJournal::findOrFail($id);
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
