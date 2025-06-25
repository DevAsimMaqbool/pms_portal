<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\IndicatorCategory;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $indicators = Indicator::with('category.keyPerformanceArea')->get();
            $KeyPerformanceArea = KeyPerformanceArea::select('id', 'performance_area')->get();
            if ($request->ajax()) {
                    return response()->json([
                    'indicators' => $indicators,
                    'KeyPerformanceArea' => $KeyPerformanceArea,
                ]);
            }
            return view('admin.indicator');
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [],
                false, 500,'');
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
                'key_performance_area' => 'required',
                'indicator_category' => 'required',
                'indicator' => 'required',
            ]);
            $userId = session('user_id');
            // Create new complaint
            $IndicatorCategory = new Indicator();
            $IndicatorCategory->indicator_category_id = $request->indicator_category;
            $IndicatorCategory->indicator = $request->indicator;
            $IndicatorCategory->created_by = $userId;
            $IndicatorCategory->updated_by = $userId;
            $IndicatorCategory->save();
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
        $IndicatorCategory = Indicator::with('category.keyPerformanceArea')->findOrFail($id);
            
        return response()->json($IndicatorCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {  
        $request->validate([
                'key_performance_area' => 'required',
                'indicator_category' => 'required',
                'indicator' => 'required',
        ]);
        $userId = session('user_id');
        $IndicatorCategory = Indicator::findOrFail($id);
        $IndicatorCategory->indicator_category_id = $request->indicator_category;
        $IndicatorCategory->indicator = $request->indicator;
        $IndicatorCategory->updated_by = $userId;
        $IndicatorCategory->save();
        return response()->json(['message' => 'Indicator update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,Request $request)
    {
        try {
            $IndicatorCategory = Indicator::findOrFail($id);
            $IndicatorCategory->delete();
            return response()->json(['status' => 'success', 'message' => 'Indicator deleted successfully']);
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [],
                false, 500,'');
        }
    }
     public function getCategoriesByKPA($kpaId)
    {
        $categories = IndicatorCategory::where('key_performance_area_id', $kpaId)->get();
        return response()->json($categories);
    }
}
