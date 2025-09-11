<?php

namespace App\Http\Controllers;

use App\Models\InternationalCoauthoredPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InternationalCoauthoredPaperController extends Controller
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
