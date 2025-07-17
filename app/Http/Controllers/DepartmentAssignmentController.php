<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentAssignmentController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $faculties = Faculty::with('departments.programs')->select('id', 'name')->get();
            $users = User::all()->take(10);
            //dd($users);
            if ($request->ajax()) {
                return response()->json([
                    'faculties' => $faculties,
                    'users' => $users,
                ]);
            }

            return view('admin.assign-department');
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->departments()->syncWithoutDetaching([$request->department_id]);

        return redirect()->route('assign.form')->with('success', 'Department assigned successfully!');
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
