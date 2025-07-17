<?php

namespace App\Http\Controllers;

use App\Models\RoleKpaAssignment;
use App\Models\KeyPerformanceArea;
use App\Models\IndicatorCategory;
use App\Models\Indicator;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        try {

            $validated = $request->validate([
                'key_performance_area_id' => 'sometimes|required|array',
                'key_performance_area_id.*' => 'exists:key_performance_areas,id',
                'indicator_category_id' => 'sometimes|required|array',
                'indicator_category_id.*' => 'exists:indicator_categories,id',
                'indicators' => 'sometimes|required|array',
                'indicators.*' => 'exists:indicators,id',
                'user_role' => 'required|string|in:Dean,HOD',
                'user' => 'sometimes|required|array',
                'user.*' => 'exists:users,id',
            ]);

            //dd($validated);
            if (!empty($validated['user'])) {
                foreach ($validated['user'] as $userId) {
                    foreach ($validated['key_performance_area_id'] as $kpaId) {
                        foreach ($validated['indicator_category_id'] as $categoryId) {
                            foreach ($validated['indicators'] as $indicatorId) {
                                RoleKpaAssignment::updateOrCreate(
                                    [
                                        'role_id' => 3,
                                        'user_id' => $userId,
                                        'key_performance_area_id' => $kpaId,
                                        'indicator_category_id' => $categoryId,
                                        'indicator_id' => $indicatorId,
                                    ],
                                    [] // Add update fields here if needed
                                );
                            }
                        }
                    }
                }
            }

            return back()->with('success', 'Assignments saved successfully.');
        } catch (ValidationException $e) {
            dd('Validation failed', $e->errors(), $request->all());
        }
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
