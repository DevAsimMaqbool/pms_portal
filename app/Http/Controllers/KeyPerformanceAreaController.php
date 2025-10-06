<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\KeyPerformanceArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeyPerformanceAreaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $kfa = KeyPerformanceArea::all();
            if ($request->ajax()) {
                return response()->json($kfa);
            }
            return view('admin.key_performance_area');
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
            'key_performance_area' => 'required',
        ]);

        $userId = Auth::id();
        $kfa = new KeyPerformanceArea();
        $kfa->performance_area = $request->key_performance_area;
        $kfa->created_by = $userId;
        $kfa->updated_by = $userId;
        $kfa->save();
        return response()->json(['message' => 'Survey created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kfa = KeyPerformanceArea::findOrFail($id);
        return response()->json($kfa);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'key_performance_area' => 'required',
        ]);
        $userId = Auth::id();
        $kfa = KeyPerformanceArea::findOrFail($id);
        $kfa->performance_area = $request->key_performance_area;
        $kfa->updated_by = $userId;
        $kfa->save();
        return response()->json(['message' => 'kfa update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $kfa = KeyPerformanceArea::findOrFail($id);
            $kfa->delete();
            return response()->json(['status' => 'success', 'message' => 'Survey deleted successfully']);
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
    public function report($id)
    {
        $area = KeyPerformanceArea::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
    public function kpa($id)
    {
        $result = getRoleAssignments(Auth::user()->getRoleNames()->first());
        $area = collect($result)->firstWhere('id', $id); // pick one KPA
        if($id==14){
            return view('admin.kpa_virtue', compact('area'));
        }
         if (!$area) {
               return view("admin.error");
        }
        return view('admin.kpa', compact('area'));
    }
    public function getIndicators(Request $request)
    {
        $indicators = Indicator::whereIn('id', function ($query) use ($request) {
            $query->select('indicator_id')
                ->from('role_kpa_assignments')
                ->where('indicator_category_id', $request->id)
                ->where('status', 1)
                ->where('role_id', Auth::user()->roles->firstWhere('name', Auth::user()->getRoleNames()->first())->id); // optional if role-based
        })->get();

        return response()->json([
            'indicators' => $indicators
        ]);
    }

}
