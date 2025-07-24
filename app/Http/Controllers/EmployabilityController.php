<?php

namespace App\Http\Controllers;

use App\Models\Employability;
use Illuminate\Http\Request;

class EmployabilityController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = Employability::all();
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
        $request->validate([
            'student_id' => 'required',
            'secure_job' => 'required',
        ]);

        $userId = session('user_id');
        $data = new Employability();
        $data->student_id = $request->student_id;
        $data->secure_job = $request->secure_job;
        $data->job_relevancy = $request->job_relevancy;
        $data->salary = $request->salary;
        $data->job_nature = $request->job_nature;
        $data->joining_date = $request->joining_date;
        $data->created_by = '1338';
        $data->updated_by = '1338';
        $data->save();
        return redirect()->route('forms.show', [
            'id' => $request->student_id,
            'slug' => 'Employability'
        ])->with('message', 'Employability added successfully');

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
        $data = Employability::findOrFail($id);
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
        $data = Employability::findOrFail($id);
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
            $kfa = Employability::findOrFail($id);
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
        $area = Employability::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

