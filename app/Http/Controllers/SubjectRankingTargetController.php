<?php

namespace App\Http\Controllers;

use App\Models\SubjectRankingTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectRankingTargetController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = SubjectRankingTarget::all();
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
                'faculty_id' => 'required|string',
                'department_id' => 'required|string',
                'subject_id' => 'required|string',
                'ranking_body' => 'nullable|string',
                'targeted_ranking_range' => 'required|integer|min:1',
                'actual_ranking_achieved' => 'required|in:numeric,not_ranked',
                'ranking_status' => 'required|in:achieved,partially_achieved,not_achieved',
                'evidence_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
                'remarks' => 'nullable|string',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                 ];
                 
                $messages = [
                    'evidence_upload.mimes' => 'Upload JPG / PNG / PDF only.',
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
                    'faculty_id',
                    'department_id',
                    'subject_id',
                    'ranking_body',
                    'targeted_ranking_range',
                    'actual_ranking_achieved',
                    'ranking_status',
                    'remarks',
                    'form_status'
                ]); 
                 if ($request->hasFile('evidence_upload')) {

                        $file = $request->file('evidence_upload');
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $uniqueNumber = rand(1000, 9999);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $safeName . '_' . $uniqueNumber . '.' . $extension;
                        $path = $file->storeAs('subject_ranking_evidence', $fileName, 'public');
                        $data['evidence_upload'] = $path;
                    }            

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = SubjectRankingTarget::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Record saved successfully',
                'data' => $record
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'oops some thing wrong'], 500);
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
        $data = SubjectRankingTarget::findOrFail($id);
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
        $data = SubjectRankingTarget::findOrFail($id);
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
            $kfa = SubjectRankingTarget::findOrFail($id);
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
        $area = SubjectRankingTarget::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}


