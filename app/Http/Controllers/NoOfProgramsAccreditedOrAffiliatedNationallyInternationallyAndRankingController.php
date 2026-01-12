<?php

namespace App\Http\Controllers;

use App\Models\ProgramAccreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NoOfProgramsAccreditedOrAffiliatedNationallyInternationallyAndRankingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = ProgramAccreditation::all();
            if ($request->ajax()) {
                return response()->json($data);
            }
            return view('indicator_forms.employability');
        } catch (\Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                ''
            );
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

            $request->validate([
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'program_level' => 'required|string',
                'recognition_type' => 'required|string',
                'ranking_body' => 'required|string',
                'scope' => 'required|string',
                'status' => 'required|string',
                'validity_from' => 'required|date',
                'validity_to' => 'required|date|after_or_equal:validity_from',
                'university_ranking' => 'nullable|string',
                'ranking_position' => 'nullable|integer|min:1',
                'evidence_available' => 'required|string',
                'document_link' => 'nullable|file|mimes:pdf,doc,docx,zip,jpg,png',
                'remarks' => 'nullable|string',
            ]);

            // Handle file upload
            $documentPath = null;
            if ($request->hasFile('document_link')) {
                $documentPath = $request->file('document_link')->store('program_accreditation_doc', 'public');
            }

            // Save form data
            $researchForm = ProgramAccreditation::create([
                'form_status' => $request->form_status,
                'indicator_id' => $request->indicator_id,
                'faculty_id' => $request->faculty_id,
                'department_id' => $request->department_id,
                'program_id' => $request->program_id,
                'program_level' => $request->program_level,
                'recognition_type' => $request->recognition_type,
                'ranking_body' => $request->ranking_body,
                'scope' => $request->scope,
                'status' => $request->status,
                'validity_from' => $request->validity_from,
                'validity_to' => $request->validity_to,
                'university_ranking' => $request->university_ranking,
                'ranking_position' => $request->ranking_position,
                'market_competitive_salary' => $request->market_competitive_salary,
                'document_link' => $documentPath,
                'remarks' => $request->remarks,
            ]);

            return response()->json([
                'message' => 'Form submitted successfully',
                'data' => $researchForm
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProgramAccreditation::findOrFail($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'key_performance_area' => 'required',
        ]);
        $userId = session('user_id');
        $data = ProgramAccreditation::findOrFail($id);
        $data->performance_area = $request->key_performance_area;
        $data->updated_by = $userId;
        $data->save();
        return response()->json(['message' => 'data update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $kfa = ProgramAccreditation::findOrFail($id);
            $kfa->delete();
            return response()->json(['status' => 'success', 'message' => 'Survey deleted successfully']);
        } catch (\Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                ''
            );
        }
    }
    public function report($id)
    {
        $area = ProgramAccreditation::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

