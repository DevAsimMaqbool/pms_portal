<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $faculties = Faculty::with('departments.programs')->select('id', 'name')->get();

            if ($request->ajax()) {
                return response()->json(['faculties' => $faculties]);
            }

            return view('admin.faculty_department_program');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
