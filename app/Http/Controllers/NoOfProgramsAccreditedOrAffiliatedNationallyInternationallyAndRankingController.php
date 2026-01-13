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
            if($request->form_status=='HOD'){
                 $rules = [
                'indicator_id' => 'required',
                'faculty_id' => 'required|integer',
                'department_id' => 'required|integer',
                'program_id' => 'required|integer',
                'program_level' => 'required|string',
                'recognition_type' => 'required|string',
                'ranking_body' => 'required|string',
                'scope' => 'required|string',
                'validity_from' => 'required|date',
                'validity_to' => 'required|date|after_or_equal:validity_from',
                'university_ranking' => 'nullable|string',
                'ranking_position' => 'nullable|integer|min:1',
                'evidence_available' => 'required|string',
                'document_link' => 'nullable|file|mimes:pdf,doc,docx,zip,jpg,png',
                'remarks' => 'nullable|string',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                 ];
                 
                $messages = [
                    'document_link.mimes' => 'Upload JPG / PNG / PDF only.',
                ];
                 $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 422);
                }
                $data = $request->only([
                    'indicator_id',
                    'faculty_id',
                    'contracting_industry',
                    'project_duration',
                    'estimated_project_cost',
                    'estimated_complection',
                    'form_status',
                    'faculty_id',
                    'department_id',
                    'program_id',
                    'program_level',
                    'recognition_type',
                    'ranking_body',
                    'scope',
                    'status',
                    'validity_from',
                    'validity_to',
                    'university_ranking',
                    'ranking_position',
                    'evidence_available',
                    'remarks',
                    'form_status'
                ]); 
                 if ($request->hasFile('document_link')) {

                        $file = $request->file('document_link');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('program_accreditation_doc', $fileName, 'public');
                        $data['document_link'] = $path;
                    }   

                        

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = ProgramAccreditation::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);
        } catch (\Exception $e) {
           // DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
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

