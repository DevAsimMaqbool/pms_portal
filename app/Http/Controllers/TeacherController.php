<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function areaOfImprovements(Request $request)
    {
        $user = Auth::user();
        $employeeId = $user->employee_id;


        $labels = ['a', 'b', 'c', 'd', 'e', 'f'];
        $dataset1 = [90, 100, 85, 90, 90, 90];
        $dataset2 = [80, 90, 75, 80, 80, 80];
        $areaOfImprovement = getIndicatorsByScore('<=', 69,$employeeId);
        return view('admin.area_of_improvement', compact('labels', 'dataset1', 'dataset2','areaOfImprovement'));
    }
    public function noteablePerformance(Request $request)
    {
        $labels = ['a', 'b', 'c', 'd', 'e', 'f'];
        $dataset1 = [90, 100, 85, 90, 90, 90];
        $dataset2 = [80, 90, 75, 80, 80, 80];
        return view('admin.noteable_performance', compact('labels', 'dataset1', 'dataset2'));
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
