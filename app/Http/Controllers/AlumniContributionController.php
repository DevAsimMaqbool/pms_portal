<?php

namespace App\Http\Controllers;

use App\Models\AlumniContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumniContributionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = AlumniContribution::all();
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
            $validated = $request->validate([
                'academic_year' => 'required|string',
                'alumni_name' => 'required|string',
                'graduation_year' => 'required|digits:4',
                'faculty_id' => 'required|string',
                'type_of_contribution' => 'nullable|array',
                'type_of_contribution.*' => 'string',
                'description_of_contribution' => 'nullable|string',
                'date_of_contribution' => 'required|date',
                'evidence_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
                'contribution_verified_by' => 'nullable|string',
                'verification_status' => 'nullable|in:pending,verified',
            ]);

            $filePath = null;
            if ($request->hasFile('evidence_upload')) {
                $filePath = $request->file('evidence_upload')
                    ->store('alumni_contributions', 'public');
            }

            $record = AlumniContribution::create([
                'form_status' => $request->form_status,
                'indicator_id' => $request->indicator_id,
                'academic_year' => $request->academic_year,
                'alumni_name' => $request->alumni_name,
                'graduation_year' => $request->graduation_year,
                'faculty_id' => $request->faculty_id,
                'type_of_contribution' => $request->type_of_contribution,
                'description_of_contribution' => $request->description_of_contribution,
                'date_of_contribution' => $request->date_of_contribution,
                'evidence_upload' => $filePath,
                'contribution_verified_by' => $request->contribution_verified_by,
                'verification_status' => $request->verification_status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Alumni contribution record saved successfully',
                'data' => $record
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
        $data = AlumniContribution::findOrFail($id);
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
        $data = AlumniContribution::findOrFail($id);
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
            $kfa = AlumniContribution::findOrFail($id);
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
        $area = AlumniContribution::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

