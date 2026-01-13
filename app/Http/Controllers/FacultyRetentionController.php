<?php

namespace App\Http\Controllers;

use App\Models\FacultyRetention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultyRetentionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = FacultyRetention::all();
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
                'strength_at_start_of_month' => 'required|integer|min:0',
                'join_during_month' => 'required|integer|min:0',
                'left_during_month' => 'required|integer|min:0',
                'strength_end_month' => 'required|integer|min:0',
                'retention_rate' => 'required|numeric|min:0|max:100',
                'retention_status' => 'required|in:excellent,satisfactory,needs_attention',
                'remarks' => 'nullable|string',
                'form_status' => 'required|in:HOD,RESEARCHER,DEAN,OTHER',
                 ];
               
                 $validator = Validator::make($request->all(), $rules);
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
                    'strength_at_start_of_month',
                    'join_during_month',
                    'left_during_month',
                    'strength_end_month',
                    'retention_rate',
                    'retention_status',
                    'remarks',
                    'form_status'
                ]);            

            }
            $employeeId = Auth::user()->employee_id;
            DB::beginTransaction();
            $data['created_by'] = $employeeId;
            $data['updated_by'] = $employeeId;

            $record = FacultyRetention::create($data);
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
        $data = FacultyRetention::findOrFail($id);
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
        $data = FacultyRetention::findOrFail($id);
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
            $kfa = FacultyRetention::findOrFail($id);
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
        $area = FacultyRetention::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

