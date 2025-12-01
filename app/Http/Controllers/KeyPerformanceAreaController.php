<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\KeyPerformanceArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        if ($id == 14) {
            return view('admin.kpa_virtue', compact('area'));
        }
        if (!$area) {
            return view("admin.error");
        }
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
        $employeeId = Auth::user()->employee_id; // logged-in employee
        $userRoleId = Auth::user()->roles->firstWhere('name', Auth::user()->getRoleNames()->first())->id;

        // Fetch indicators assigned to this category & role
        $indicators = Indicator::whereIn('id', function ($query) use ($request, $userRoleId) {
            $query->select('indicator_id')
                ->from('role_kpa_assignments')
                ->where('indicator_category_id', $request->id)
                ->where('status', 1)
                ->where('role_id', $userRoleId);
        })->get();

        // Map indicator name to table/column or custom calculation
        $indicatorCalculations = [
            'Event Performance Feedback' => [
                'table' => 'line_manager_event_feedback',
                'column' => 'rating'
            ],
            "Line Manager's Review & Rating on Tasks" => [
                'custom' => true, // use custom overall avg
            ],
            // Add more indicators here...
        ];

        $indicators = $indicators->map(function ($indicator) use ($indicatorCalculations, $employeeId) {
            $overallAvg = 0;

            if (isset($indicatorCalculations[$indicator->indicator])) {
                $config = $indicatorCalculations[$indicator->indicator];

                // Custom overall average for LineManagerFeedback
                if (isset($config['custom']) && $config['custom']) {
                    $feedbacks = \App\Models\LineManagerFeedback::where('employee_id', $employeeId)->get();

                    if ($feedbacks->count()) {
                        $total = 0;
                        foreach ($feedbacks as $item) {
                            $res_avg = ($item->responsibility_accountability_1 + $item->responsibility_accountability_2) / 2;
                            $emp_avg = ($item->empathy_compassion_1 + $item->empathy_compassion_2) / 2;
                            $hum_avg = ($item->humility_service_1 + $item->humility_service_2) / 2;
                            $hon_avg = ($item->honesty_integrity_1 + $item->honesty_integrity_2) / 2;
                            $ins_avg = ($item->inspirational_leadership_1 + $item->inspirational_leadership_2) / 2;

                            $overallAvg += ($res_avg + $emp_avg + $hum_avg + $hon_avg + $ins_avg) / 5;
                        }

                        $overallAvg = $overallAvg / $feedbacks->count(); // avg across all feedback rows
                    }
                } else {
                    // Default simple table/column avg
                    if (Schema::hasTable($config['table'])) {
                        $overallAvg = DB::table($config['table'])
                            ->where('employee_id', $employeeId)
                            ->avg($config['column']);
                    }
                }
            }

            $indicator->percentage = round($overallAvg);
            return $indicator;
        });

        return response()->json([
            'indicators' => $indicators
        ]);
    }


}
