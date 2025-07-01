<?php

namespace App\Http\Controllers;

use App\Models\IndicatorCategory;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndicatorCategoryController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $IndicatorCategory = IndicatorCategory::with(['keyPerformanceArea'])->get();
            $KeyPerformanceArea = KeyPerformanceArea::select('id', 'performance_area')->get();
            if ($request->ajax()) {
                return response()->json([
                    'IndicatorCategory' => $IndicatorCategory,
                    'KeyPerformanceArea' => $KeyPerformanceArea,
                ]);
            }
            return view('admin.indicator_category');
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
            'key_performance_area' => 'required|exists:key_performance_areas,id',
            'indicator_category' => 'required',
        ]);
        $userId = session('user_id');
        // Split the comma-separated tags into an array
        $categories = array_map('trim', explode(',', $request->indicator_category));
        foreach ($categories as $category) {
            $indicatorCategory = new IndicatorCategory();
            $indicatorCategory->key_performance_area_id = $request->key_performance_area;
            $indicatorCategory->indicator_category = $category;
            $indicatorCategory->created_by = $userId;
            $indicatorCategory->updated_by = $userId;
            $indicatorCategory->save();
        }
        return response()->json(['message' => 'Indicator Category created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $IndicatorCategory = IndicatorCategory::with([
            'keyPerformanceArea:id,performance_area',
        ])->findOrFail($id);
        return response()->json($IndicatorCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_new(Request $request, $id)
    {
        $request->validate([
            'key_performance_area' => 'required|exists:key_performance_areas,id',
            'indicator_category' => 'required',
        ]);
        $userId = session('user_id');
        $IndicatorCategory = IndicatorCategory::findOrFail($id);
        $IndicatorCategory->key_performance_area_id = $request->key_performance_area;
        $IndicatorCategory->indicator_category = $request->indicator_category;
        $IndicatorCategory->updated_by = $userId;
        $IndicatorCategory->save();
        return response()->json(['message' => 'Indicator Category update successfully']);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'key_performance_area' => 'required|exists:key_performance_areas,id',
            'indicator_category' => 'required',
        ]);

        $userId = session('user_id');

        // Step 1: Convert the comma-separated string into an array of trimmed tags
        $newCategories = array_filter(array_map('trim', explode(',', $request->indicator_category)));

        // Step 2: Get existing categories for the key_performance_area
        $existingCategories = IndicatorCategory::where('key_performance_area_id', $request->key_performance_area)
            ->pluck('indicator_category')
            ->toArray();

        // Step 3: Add new categories
        foreach ($newCategories as $category) {
            if (!in_array($category, $existingCategories)) {
                $indicatorCategory = new IndicatorCategory();
                $indicatorCategory->key_performance_area_id = $request->key_performance_area;
                $indicatorCategory->indicator_category = $category;
                $indicatorCategory->created_by = $userId;
                $indicatorCategory->updated_by = $userId;
                $indicatorCategory->save();
            }
        }

        // Step 4: Delete categories that were removed by user
        IndicatorCategory::where('key_performance_area_id', $request->key_performance_area)
            ->whereNotIn('indicator_category', $newCategories)
            ->delete();

        return response()->json(['message' => 'Indicator Categories updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $IndicatorCategory = IndicatorCategory::findOrFail($id);
            $IndicatorCategory->delete();
            return response()->json(['status' => 'success', 'message' => 'Indicator Category deleted successfully']);
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

}
