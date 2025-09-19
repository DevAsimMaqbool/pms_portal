<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\IndicatorCategory;
use App\Models\KeyPerformanceArea;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class RectorDashboardController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // $indicators = Indicator::with('category.keyPerformanceArea')->get();
            //$indicators = IndicatorCategory::with('indicators')->get();
            $KeyPerformanceArea = KeyPerformanceArea::select('id', 'performance_area')->get();
            return view('admin.rector_dashboard', compact('KeyPerformanceArea'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [], false, 500, '');
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
        $categories = array_map('trim', explode(',', $request->indicator));
        // Create new complaint
        foreach ($categories as $category) {
            $IndicatorCategory = new Indicator();
            $IndicatorCategory->indicator_category_id = $request->indicator_category;
            $IndicatorCategory->indicator = $category;
            $IndicatorCategory->created_by = $userId;
            $IndicatorCategory->updated_by = $userId;
            $IndicatorCategory->save();
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
        $category = IndicatorCategory::with('keyPerformanceArea')->findOrFail($id);
        $indicators = $category->indicators()->pluck('indicator');

        return response()->json([
            'id' => $category->id,
            'indicator_category' => $category->indicator_category,
            'key_performance_area_id' => $category->key_performance_area_id,
            'indicator' => $indicators->implode(','),
        ]);
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
        // Parse incoming indicators (comma-separated string to array)
        $newIndicators = array_filter(array_map('trim', explode(',', $request->indicator)));
        $existingIndicators = Indicator::where('indicator_category_id', $request->indicator_category)
            ->pluck('indicator')
            ->toArray();
        // Normalize arrays to lowercase for case-insensitive comparison
        $existingIndicatorsLower = array_map('strtolower', $existingIndicators);
        $newIndicatorsLower = array_map('strtolower', $newIndicators);
        // Add new indicators that don't already exist
        foreach ($newIndicators as $index => $indicator) {
            if (!in_array(strtolower($indicator), $existingIndicatorsLower)) {
                Indicator::create([
                    'indicator_category_id' => $request->indicator_category,
                    'indicator' => $indicator,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);
            }
        }

        // Delete indicators that were removed by the user
        foreach ($existingIndicators as $existingIndicator) {
            if (!in_array(strtolower($existingIndicator), $newIndicatorsLower)) {
                Indicator::where('indicator_category_id', $request->indicator_category)
                    ->where('indicator', $existingIndicator)
                    ->delete();
            }
        }

        return response()->json(['message' => 'Indicator updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $IndicatorCategory = Indicator::findOrFail($id);
            $IndicatorCategory->delete();
            return response()->json(['status' => 'success', 'message' => 'Indicator deleted successfully']);
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
    public function getCategoriesByKPA($kpaId)
    {
        $categories = IndicatorCategory::where('key_performance_area_id', $kpaId)->get();
        return response()->json($categories);
    }

    public function teacherDashboard(Request $request, $id = null)
    {
        try {
            if ($id) {
                $employee = User::findOrFail($id); // get data against given id
            } else {
                $employee = Auth::user(); // fallback to logged-in user
            }
            return view('admin.teacher_dashbord', compact('employee'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [], false, 500, '');
        }
    }

    public function departmentDashboard(Request $request, $department)
    {
        try {
            return view('admin.department_dashbord', compact('department'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [], false, 500, '');
        }
    }
}

