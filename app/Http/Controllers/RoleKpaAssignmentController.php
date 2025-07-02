<?php

namespace App\Http\Controllers;

use App\Models\RoleKpaAssignment;
use App\Models\KeyPerformanceArea;
use App\Models\IndicatorCategory;
use App\Models\Indicator;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleKpaAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $kpas = KeyPerformanceArea::all();
        return view('assignments.create', compact('roles', 'kpas'));
    }

    public function getCategories($kpaId)
    {
        $categories = IndicatorCategory::where('key_performance_area_id', $kpaId)->get();
        return response()->json($categories);
    }

    public function getIndicators($categoryId)
    {
        $indicators = Indicator::where('indicator_category_id', $categoryId)->get();
        return response()->json($indicators);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'key_performance_area_id' => 'required|exists:key_performance_areas,id',
            'indicator_category_id' => 'required|exists:indicator_categories,id',
            'indicators' => 'required|array',
        ]);

        foreach ($request->indicators as $indicatorId) {
            RoleKpaAssignment::updateOrCreate([
                'role_id' => $request->role_id,
                'key_performance_area_id' => $request->key_performance_area_id,
                'indicator_category_id' => $request->indicator_category_id,
                'indicator_id' => $indicatorId,
            ]);
        }

        return back()->with('success', 'Assignments saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }
}
