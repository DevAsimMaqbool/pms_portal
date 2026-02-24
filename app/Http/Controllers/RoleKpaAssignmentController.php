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
                'key_performance_area_id' => 'required|array',
                'key_performance_area_id.*' => 'exists:key_performance_areas,id',
                'indicator_category_id' => 'required|array',
                'indicator_category_id.*' => 'exists:indicator_categories,id',
                'indicators' => 'required|array',
                'indicators.*' => 'exists:indicators,id',
                'user_role' => 'required|exists:roles,id',
            ]);
            //dd($validated);
            // --- Validate hierarchy ---
            // 1. Categories must belong to one of the selected KPAs
            $validCategoryIds = IndicatorCategory::whereIn('key_performance_area_id', $validated['key_performance_area_id'])
                ->pluck('id')
                ->toArray();

            foreach ($validated['indicator_category_id'] as $catId) {
                if (!in_array($catId, $validCategoryIds)) {
                    return back()->withErrors(['indicator_category_id' => 'One or more categories do not belong to the selected KPAs.'])->withInput();
                }
            }

            // 2. Indicators must belong to one of the selected categories
            $validIndicatorIds = Indicator::whereIn('indicator_category_id', $validated['indicator_category_id'])
                ->pluck('id')
                ->toArray();

            foreach ($validated['indicators'] as $indId) {
                if (!in_array($indId, $validIndicatorIds)) {
                    return back()->withErrors(['indicators' => 'One or more indicators do not belong to the selected categories.'])->withInput();
                }
            }

            // --- Save valid hierarchy ---
            foreach ($validated['key_performance_area_id'] as $kpaId) {
                $categories = IndicatorCategory::whereIn('id', $validated['indicator_category_id'])
                    ->where('key_performance_area_id', $kpaId)
                    ->get();

                foreach ($categories as $category) {
                    $indicators = Indicator::whereIn('id', $validated['indicators'])
                        ->where('indicator_category_id', $category->id)
                        ->get();

                    foreach ($indicators as $indicator) {
                        RoleKpaAssignment::updateOrCreate(
                            [
                                'role_id' => $validated['user_role'],
                                'user_id' => 0,
                                'key_performance_area_id' => $kpaId,
                                'indicator_category_id' => $category->id,
                                'indicator_id' => $indicator->id,
                            ],
                            [] // Add update fields if needed
                        );
                    }
                }
            }

            return back()->with('success', 'Assignments saved successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
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
    public function edit()
    {
        $roles = Role::select('id', 'name')->get();
        $kfarea = KeyPerformanceArea::all();

        return view('assignments.kpa_edit', compact('kfarea', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'key_performance_area_id' => 'required|array',
            'indicator_category_id' => 'required|array',
            'indicators' => 'required|array',
            'user_role' => 'required|exists:roles,id',
        ]);

        $roleId = $validated['user_role'];

        // 1. Remove assignments for KPAs that are no longer selected
        RoleKpaAssignment::where('role_id', $roleId)
            ->whereNotIn('key_performance_area_id', $validated['key_performance_area_id'])
            ->delete();

        // 2. Remove assignments for Categories that are no longer selected
        RoleKpaAssignment::where('role_id', $roleId)
            ->whereIn('key_performance_area_id', $validated['key_performance_area_id'])
            ->whereNotIn('indicator_category_id', $validated['indicator_category_id'])
            ->delete();

        // 3. Remove assignments for Indicators that are no longer selected
        RoleKpaAssignment::where('role_id', $roleId)
            ->whereIn('indicator_category_id', $validated['indicator_category_id'])
            ->whereNotIn('indicator_id', $validated['indicators'])
            ->delete();

        // 4. Insert or update current selections
        foreach ($validated['key_performance_area_id'] as $kpaId) {

            $categories = IndicatorCategory::whereIn('id', $validated['indicator_category_id'])
                ->where('key_performance_area_id', $kpaId)
                ->get();

            foreach ($categories as $category) {

                $indicators = Indicator::whereIn('id', $validated['indicators'])
                    ->where('indicator_category_id', $category->id)
                    ->get();

                foreach ($indicators as $indicator) {

                    RoleKpaAssignment::updateOrCreate(
                        [
                            'role_id' => $roleId,
                            'user_id' => 0,
                            'key_performance_area_id' => $kpaId,
                            'indicator_category_id' => $category->id,
                            'indicator_id' => $indicator->id,
                        ],
                        [] // No additional fields for update
                    );
                }
            }
        }

        return back()->with('success', 'Assignments updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }
    public function saveWeightage(Request $request)
    {
        $roleId = Role::where('name', $request->role_id)->value('id');

        // KPA Weightage
        if ($request->has('kpa_id') && $request->has('kpa_weightage')) {
            foreach ($request->kpa_id as $index => $kpaId) {
                RoleKpaAssignment::where('role_id', $roleId)
                    ->where('key_performance_area_id', $kpaId)
                    ->update(['kpa_weightage' => $request->kpa_weightage[$index]]);
            }
        }

        // Indicator Category Weightage
        if ($request->has('indicator_category_id') && $request->has('indicator_category_weightage')) {
            foreach ($request->indicator_category_id as $index => $catId) {
                RoleKpaAssignment::where('role_id', $roleId)
                    ->where('indicator_category_id', $catId)
                    ->update(['indicator_category_weightage' => $request->indicator_category_weightage[$index]]);
            }
        }

        // Indicator Weightage
        if ($request->has('indicator_id') && $request->has('indicator_weightage')) {
            foreach ($request->indicator_id as $index => $indicatorId) {
                RoleKpaAssignment::where('role_id', $roleId)
                    ->where('indicator_id', $indicatorId)
                    ->update(['indicator_weightage' => $request->indicator_weightage[$index]]);
            }
        }

        // ✅ Form Status
        if ($request->has('form_status')) {
            foreach ($request->form_status as $indicatorId => $status) {
                RoleKpaAssignment::where('role_id', $roleId)
                    ->where('indicator_id', $indicatorId)
                    ->update([
                        'form_status' => $status
                    ]);
            }
        }

        return redirect()->back()->with('success', 'Weightages updated successfully!');
    }

    public function getAssigned(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $assignments = RoleKpaAssignment::where('role_id', $request->role_id)
            ->get();

        return response()->json([
            'kpas' => $assignments->pluck('key_performance_area_id')->unique()->values(),
            'categories' => $assignments->pluck('indicator_category_id')->unique()->values(),
            'indicators' => $assignments->pluck('indicator_id')->unique()->values(),
        ]);
    }


}
