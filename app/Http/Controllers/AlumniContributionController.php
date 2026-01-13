<?php

namespace App\Http\Controllers;

use App\Models\AlumniContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            if($request->form_status=='HOD'){
                 $rules = [
                'indicator_id' => 'required',
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
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                 ];
                 
                $messages = [
                    'evidence_upload.mimes' => 'Upload JPG / PNG / PDF only.',
                    'type_of_contribution.array' => 'Type of contribution must be a valid list.',
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
                    'academic_year',
                    'alumni_name',
                    'graduation_year',
                    'faculty_id',
                    'description_of_contribution',
                    'date_of_contribution',
                    'contribution_verified_by',
                    'verification_status',
                    'form_status'
                ]); 
                 if ($request->hasFile('evidence_upload')) {

                        $file = $request->file('evidence_upload');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('alumni_contributions', $fileName, 'public');
                        $data['evidence_upload'] = $path;
                    }    
                if ($request->filled('type_of_contribution')) {
                    $data['type_of_contribution'] = json_encode($request->type_of_contribution);
                }            

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = AlumniContribution::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'oops something wrong'], 500);
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

