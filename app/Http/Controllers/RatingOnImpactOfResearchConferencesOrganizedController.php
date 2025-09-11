<?php

namespace App\Http\Controllers;

use App\Models\RatingOnImpactOfResearchConferencesOrganized;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RatingOnImpactOfResearchConferencesOrganizedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
