<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\KeyPerformanceArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Exports\EmployeeKpaReportExport;
use App\Exports\EmployeeCombineReportExport;
use Maatwebsite\Excel\Facades\Excel;
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
    public function kpabk($id)
    {
        $result = getRoleAssignments(Auth::user()->getRoleNames()->first());
        $area = collect($result)->firstWhere('id', $id); // pick one KPA
        if ($id == 14) {
            return view('admin.kpa_virtue', compact('area'));
        }
        if (!$area) {
            return view("admin.error");
        }
        return view('admin.kpa', compact('area'));
    }
    public function kpaBkASIM($id)
    {
        $userRole = activeRole();
        $userRoleId = getRoleIdByName(activeRole());
        $displayRole = match (strtolower($userRole)) {
            'hod' => 'HOD',
            default => ucfirst($userRole),
        };
        $result = getRoleAssignments($displayRole);
        $area = collect($result)->firstWhere('id', $id); // pick one KPA
        if (!$area) {
            return view("admin.error");
        }

        $employeeId = Auth::user()->employee_id;

        // Fetch indicator categories under this KPA
        $indicatorCategories = \App\Models\IndicatorsPercentage::select('indicator_category_id', DB::raw('AVG(score) as avg_score'))
            ->where('employee_id', $employeeId)
            ->where('key_performance_area_id', $id)
            ->where('role_id', $userRoleId)
            ->groupBy('indicator_category_id')
            ->get();

        // Map avg score to the area categories
        $area['category'] = collect($area['category'])->map(function ($cat) use ($indicatorCategories) {
            $avg = $indicatorCategories->firstWhere('indicator_category_id', $cat['id']);
            $cat['score'] = $avg ? floor($avg->avg_score) : 0;
            return $cat;
        });
        if ($id == 14) {
            return view('admin.kpa_virtue', compact('area'));
        }
        return view('admin.kpa', compact('area'));
    }

    public function kpa($id)
    {
        $userRole = activeRole();
        $userRoleId = getRoleIdByName(activeRole());

        $displayRole = match (strtolower($userRole)) {
            'hod' => 'HOD',
            default => ucfirst($userRole),
        };

        $result = getRoleAssignments($displayRole);
        $area = collect($result)->firstWhere('id', $id);

        if (!$area) {
            return view("admin.error");
        }

        $employeeId = Auth::user()->employee_id;

        // =====================================================
        // ✅ STEP 1: Get SUM of scores per category
        // =====================================================
        $indicatorScores = \App\Models\IndicatorsPercentage::select(
            'indicator_category_id',
            DB::raw('SUM(score) as total_score')
        )
            ->where('employee_id', $employeeId)
            ->where('key_performance_area_id', $id)
            ->where('role_id', $userRoleId)
            ->groupBy('indicator_category_id')
            ->get()
            ->keyBy('indicator_category_id');

        // =====================================================
        // ✅ STEP 2: Map score + divide by SUM(weightage)
        // =====================================================
        $area['category'] = collect($area['category'])->map(function ($cat) use ($indicatorScores) {

            $categoryId = $cat['id'];

            // SUM of scores
            $totalScore = isset($indicatorScores[$categoryId])
                ? $indicatorScores[$categoryId]->total_score
                : 0;

            // SUM of weightage from role_kpa_assignments (already inside indicators list)
            $totalWeight = collect($cat['indicator'])
                ->sum('indicator_weightage');
            // FINAL FORMULA: SUM(score) / SUM(weightage)
            $cat['score'] = $totalWeight > 0
                ? round(($totalScore / $totalWeight) * 100, 1)
                : 0;
            $cat['total_weight'] = $totalWeight ?? 0;
            $cat['total_score'] = $totalScore ?? 0;
            return $cat;
        });

        // =====================================================
        // ✅ Views (UNCHANGED)
        // =====================================================
        if ($id == 14) {
            return view('admin.kpa_virtue', compact('area'));
        }
        // dd($area);
        return view('admin.kpa', compact('area'));
    }

    public function getIndicatorsbk(Request $request)
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

    public function getIndicators(Request $request)
    {
        $employeeId = Auth::user()->employee_id;
        $userRoleId = getRoleIdByName(activeRole());

        // Fetch assignments
        $assignments = \DB::table('role_kpa_assignments')
            ->where('indicator_category_id', $request->id)
            ->where('status', 1)
            ->where('role_id', $userRoleId)
            ->get();

        $indicatorIds = $assignments->pluck('indicator_id');

        // Weightage map
        $weightages = $assignments->pluck('indicator_weightage', 'indicator_id');

        // Fetch indicators
        $indicators = Indicator::whereIn('id', $indicatorIds)->get();

        // Fetch saved scores
        $savedScores = \App\Models\IndicatorsPercentage::where('employee_id', $employeeId)
            ->whereIn('indicator_id', $indicatorIds)
            ->where('role_id', $userRoleId)
            ->get()
            ->keyBy('indicator_id');

        // Map response
        $indicators = $indicators->map(function ($indicator) use ($savedScores, $weightages) {

            $weightage = $weightages[$indicator->id] ?? 1;

            if (isset($savedScores[$indicator->id])) {

                $saved = $savedScores[$indicator->id];

                // ✅ Raw score (WITHOUT division)
                $indicator->score = round($saved->score, 2);
                $indicator->weightage = $weightage;
                $indicator->indicatorId = $indicator->id;

                // ✅ Percentage (WITH division)
                $percentage = ($weightage > 0)
                    ? ($saved->score / $weightage) * 100
                    : 0;

                $indicator->percentage = min(round($percentage, 1), 100);
                $indicator->color = $saved->color;
                $indicator->rating = $saved->rating;

            } else {
                $indicator->score = 0; // no score
                $indicator->percentage = 0;
                $indicator->color = '#d3d3d3';
                $indicator->rating = 'NA';
            }

            // send weightage too
            $indicator->indicator_weightage = $weightage;

            return $indicator;
        });

        return response()->json([
            'indicators' => $indicators
        ]);
    }

    public function exportKpaReport()
    {
        return Excel::download(new EmployeeKpaReportExport, 'employee_kpa_report.xlsx');
    }

    public function exportCombineReport()
    {
        return Excel::download(new EmployeeCombineReportExport, 'employee_kpa_report.xlsx');
    }


}
