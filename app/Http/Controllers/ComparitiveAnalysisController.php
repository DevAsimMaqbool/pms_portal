<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\IndicatorCategory;
use App\Models\KeyPerformanceArea;
use App\Models\RoleKpaAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class ComparitiveAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $role = $user->roles->first();
            $roleId = $role->id;
            $roleName = $role->name;
            $department = $user->department;
            $employee_id = $user->employee_id;
            $keyPerformanceAreaId = 1;
            
           
           
            // Assigned KPAs based on role
            $assignments = RoleKpaAssignment::with('kpa')
                ->where('role_id', $role->id)
                ->get();

            // Extract KPAs from assignments
            $kfarea = $assignments->map(fn($item) => $item->kpa)->unique('id')->values();
            $labels = ['A', 'B', 'C', 'D', 'E', 'F'];

            $averageOfAverages = '80.87';
            $dataset1 = [90, 100, 85, 90, 90, 90];
            $dataset2 = [80, 90, 75, 80, 80, 80];

          

            
            $dataset2 = [80, 90, 75, 80, 80, 80];

            return view('admin.comparitive_analysis', compact(
                'kfarea','labels','dataset1','dataset2'
            ));
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
        //$roleId = Auth::user()->roles->firstWhere('name', Auth::user()->getRoleNames()->first())->id ?? null;

        // $indicators = Indicator::where('status', 1)
        //     ->whereIn('id', function ($query) use ($request, $roleId) {
        //         $query->select('indicator_id')
        //             ->from('role_kpa_assignments')
        //             ->whereIn('indicator_category_id', (array) $request->category_ids)
        //             ->where('status', 1);

        //         if ($roleId) {
        //             $query->where('role_id', $roleId);
        //         }
        //     })
        //     ->get();

        $indicators = User::whereIn('id', [20233, 20249, 20253, 20268, 23154])
            ->whereHas('roles', function ($query) {
                $query->where('id', 21); // role_id = 21
            })
            ->limit(5)
            ->get();

        return response()->json($indicators);
    }

public function getSelfVsSelfData(Request $request)
{
    $keyPerformanceAreaId = $request->input('keyPerformanceAreaId', 1);

    $user = Auth::user();
    $role = $user->roles->first();
    $roleId = $role->id;
    $roleName = $role->name;
    $employeeId = $user->employee_id;

    $currentYear  = Carbon::now()->year;
    $previousYear = Carbon::now()->subYear()->year;

    // $kpaAvgWeightage = kpaAvgWeightage($keyPerformanceAreaId, $roleId);
    // $weight = $kpaAvgWeightage['kpa_weightage'] ?? 100;

    $userRecord = User::where('employee_id', $employeeId)
        ->role($roleName)
        ->select('id', 'name', 'employee_id')
        ->with(['indicatorsPercentages' => function ($q) use ($keyPerformanceAreaId, $currentYear, $previousYear) {
            $q->select(
                'employee_id',
                'score',
                'key_performance_area_id',
                'created_at'
            )
            ->where('key_performance_area_id', $keyPerformanceAreaId)
            ->where(function ($query) use ($currentYear, $previousYear) {
                $query->whereYear('created_at', $currentYear)
                      ->orWhereYear('created_at', $previousYear);
            });
        }])
        ->first();

    // Default values
    $years  = [$previousYear, $currentYear];
    $values = [0, 0];

    if ($userRecord && $userRecord->indicatorsPercentages->isNotEmpty()) {

        // Group indicators by year
        $grouped = $userRecord->indicatorsPercentages->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->year;
        });

        foreach ($years as $index => $year) {
            if (isset($grouped[$year])) {
                $totalScore = $grouped[$year]->sum('score');
                $count = $grouped[$year]->count();

                $average = $count ? ($totalScore / $count) : 0;
                // $weighted = ($average * $weight) / 100;

                $values[$index] = round($average, 1);
            }
        }
    }

    return response()->json([
        'years'  => $years,
        'values' => $values
    ]);
}

    public function getCarrierChartData(Request $request)
{
    $keyPerformanceAreaId = $request->input('keyPerformanceAreaId', 1); // default 1 if not passed

    $user = Auth::user();
    $role = $user->roles->first();
    $roleId = $role->id;
    $roleName = $role->name;
    $department = $user->department;

    // $kpaAvgWeightage = kpaAvgWeightage($keyPerformanceAreaId, $roleId);
    // $weight = $kpaAvgWeightage['kpa_weightage'] ?? 100;

    // Fetch users with their indicators
    $records = User::where('department', $department)
        ->role($roleName)
        ->select('id', 'name', 'employee_id')
        ->with(['indicatorsPercentages' => function($q) use ($keyPerformanceAreaId) {
            $q->select('employee_id', 'score', 'rating', 'key_performance_area_id','indicator_id')
              ->where('key_performance_area_id', $keyPerformanceAreaId);
        }])
        ->get();

        // Calculate average score for each user
        $usersWithScores = $records->map(function ($u) {
            $indicators = $u->indicatorsPercentages;

            $totalScore = $indicators->sum('score');
            $totalIndicators = $indicators->count();

            $averageScore = $totalIndicators
                ? round($totalScore / $totalIndicators, 1)
                : 0;

            // Attach average score
            $u->averageScore = min($averageScore, 100);


            return $u;
        });

    // Sort users by weighted score descending
    $sortedUsers = $usersWithScores->sortBy('averageScore'); 

    // Prepare chart data
    $categories = $sortedUsers->pluck('name')->toArray();
    $values = $sortedUsers->pluck('averageScore')->toArray();

    // Logged-in user to highlight
    $highlightName = $user->name;

    return response()->json([
        'categories' => $categories,
        'values' => $values,
        'highlightName' => $highlightName
    ]);
}


}

