<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\IndicatorCategory;
use App\Models\KeyPerformanceArea;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class ComparitiveAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kfarea = KeyPerformanceArea::all();
            $labels = ['A', 'B', 'C', 'D', 'E', 'F'];

            $averageOfAverages = '80.87';
            $dataset1 = [90, 100, 85, 90, 90, 90];
            $dataset2 = [80, 90, 75, 80, 80, 80];
            return view('admin.comparitive_analysis', compact('kfarea', 'dataset1', 'dataset2', 'averageOfAverages', 'labels'));
        } catch (\Exception $e) {
            return apiResponse('Oops! Something went wrong', [], false, 500, '');
        }
    }

    public function getUsers(Request $request)
    {
        try {
            $role = $request->input('role');

            $users = User::where('job_title', 'like', "%{$role}%")->limit(5)->get();
            return response()->json([
                'users' => $users,
            ]);
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getIndicatorCategories(Request $request)
    {
        $kpaIds = $request->kpa_ids ?? [];

        $categories = IndicatorCategory::where('key_performance_area_id', $kpaIds)->get();

        return response()->json($categories);
    }

    public function getIndicators(Request $request)
    {
        $categoryIds = $request->category_ids ?? [];

        $indicators = Indicator::whereIn('indicator_category_id', $categoryIds)->get();

        return response()->json($indicators);
    }
}

