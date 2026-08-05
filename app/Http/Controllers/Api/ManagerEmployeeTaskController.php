<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTask;
use App\Models\IndicatorsPercentage;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagerEmployeeTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EmployeeTask::query()
            ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')
            ->select(
                'employee_tasks.employee_id',
                'users.name',
                DB::raw('COUNT(employee_tasks.id) as activities'),
                DB::raw('SUM(employee_tasks.hours_worked) as hours'),
                DB::raw('AVG(employee_tasks.self_completion) as self_score'),
                DB::raw('AVG(employee_tasks.manager_completion) as mgr_score')
            );

        // Date Filters
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('employee_tasks.task_date', [
                $request->from_date,
                $request->to_date
            ]);

        } elseif ($request->filled('from_date')) {

            $query->whereDate('employee_tasks.task_date', '>=', $request->from_date);

        } elseif ($request->filled('to_date')) {

            $query->whereDate('employee_tasks.task_date', '<=', $request->to_date);

        }

        $employees = $query
            ->groupBy(
                'employee_tasks.employee_id',
                'users.name'
            )
            ->get();

        $employees->transform(function ($row) {

            $selfScore = round($row->self_score ?? 0, 2);
            $mgrScore = round($row->mgr_score ?? 0, 2);

            return [
                'employee_id' => $row->employee_id,
                'employee_name' => $row->name,
                'activities' => (int) $row->activities,
                'hours' => round($row->hours ?? 0, 2),

                'self' => [
                    'score' => $selfScore,
                    'rating' => $this->rating($selfScore),
                ],

                'manager' => [
                    'score' => $mgrScore,
                    'rating' => $this->rating($mgrScore),
                ],

                'variance' => round($selfScore - $mgrScore, 2),

                'match' => $selfScore == $mgrScore,

                'match_status' => $selfScore == $mgrScore
                    ? 'Aligned'
                    : 'Not Aligned',
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Employees fetched successfully.',
            'count' => $employees->count(),
            'data' => $employees,
        ]);
    }

    private function rating($score)
    {
        if ($score >= 90) {
            return 'Outstanding';
        } elseif ($score >= 80) {
            return 'Exceed Expectations';
        } elseif ($score >= 70) {
            return 'Meet Expectations';
        } elseif ($score >= 60) {
            return 'Needs Improvement';
        }

        return 'Unsatisfactory';
    }

    public function managerVerificationSummary(Request $request)
    {
        if ($request->ajax()) {

            $daily = EmployeeTask::query()
                ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')
                ->select(
                    'employee_tasks.employee_id',
                    'users.name',
                    'employee_tasks.task_date',

                    DB::raw('COUNT(*) as total_tasks'),

                    DB::raw("
                    SUM(
                        CASE
                            WHEN task_status='2' THEN 1
                            ELSE 0
                        END
                    ) as verified_tasks
                "),

                    DB::raw('AVG(self_completion) as avg_self'),
                    DB::raw('AVG(manager_completion) as avg_mgr'),

                    DB::raw("
                    CASE
                        WHEN MIN(task_status='2') = 1
                        THEN 1
                        ELSE 0
                    END as day_verified
                "),

                    DB::raw("
                    CASE
                        WHEN ROUND(AVG(self_completion),2)=ROUND(AVG(manager_completion),2)
                        THEN 1
                        ELSE 0
                    END as aligned
                ")
                );

            if ($request->filled('from_date')) {
                $daily->whereDate('task_date', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $daily->whereDate('task_date', '<=', $request->to_date);
            }

            $daily = $daily
                ->groupBy(
                    'employee_tasks.employee_id',
                    'users.name',
                    'employee_tasks.task_date'
                )
                ->get();

            $summary = $daily
                ->groupBy('employee_id')
                ->map(function ($rows) {

                    $daysLogged = $rows->count();

                    $daysVerified = $rows->where('day_verified', 1)->count();

                    $coverage = $daysLogged
                        ? round(($daysVerified / $daysLogged) * 100, 2)
                        : 0;

                    $avgSelf = round($rows->avg('avg_self'), 2);

                    $avgMgr = round($rows->avg('avg_mgr'), 2);

                    return [
                        'employee' => $rows->first()->name,
                        'days_logged' => $daysLogged,
                        'days_verified' => $daysVerified,
                        'coverage' => $coverage,
                        'avg_self' => $avgSelf,
                        'avg_mgr' => $avgMgr,
                        'variance' => round($avgSelf - $avgMgr, 2),
                        'aligned' => $rows->where('aligned', 1)->count(),
                        'mismatch' => $rows->where('aligned', 0)->count(),
                        'status' => $daysVerified == $daysLogged
                            ? ($rows->where('aligned', 0)->count() == 0
                                ? 'Fully Verified & Aligned'
                                : 'Fully Verified & Not Aligned')
                            : 'Pending Verification'
                    ];
                })
                ->values();

            return DataTables::of($summary)
                ->addIndexColumn()

                ->editColumn('coverage', fn($r) => $r['coverage'] . '%')

                ->editColumn('avg_self', fn($r) => $r['avg_self'] . '%')

                ->editColumn('avg_mgr', fn($r) => $r['avg_mgr'] . '%')

                ->addColumn('status_badge', function ($r) {

                    if ($r['status'] == 'Fully Verified & Aligned') {
                        return '<span class="badge bg-success">' . $r['status'] . '</span>';
                    }

                    if ($r['status'] == 'Fully Verified & Not Aligned') {
                        return '<span class="badge bg-warning">' . $r['status'] . '</span>';
                    }

                    return '<span class="badge bg-danger">Pending Verification</span>';
                })

                ->rawColumns(['status_badge'])

                ->make(true);
        }

        return view('admin.manager_employee_tasks.manager-verification-summary');
    }

    public function monthlyDashboard(Request $request)
    {
        return view(
            'admin.manager_employee_tasks.monthly_team_productivity',
            compact(
                'employees',
                'snapshot',
                'topSelf',
                'topMgr',
                'aligned',
                'mismatch',
                'awaiting',
                'month',
                'daysInMonth',
                'workingDays'
            )
        );
    }
    public function MonthlyTeamProductivity(Request $request)
    {

        // Default Current Month
        $month = $request->month ?? date('Y-m');

        $year = Carbon::parse($month)->year;
        $monthNumber = Carbon::parse($month)->month;

        // Number of Days
        $daysInMonth = Carbon::create($year, $monthNumber)->daysInMonth;

        // Employees having tasks in selected month
        $employees = User::whereIn('employee_id', function ($q) use ($year, $monthNumber) {
            $q->select('employee_id')
                ->from('employee_tasks')
                ->whereYear('task_date', $year)
                ->whereMonth('task_date', $monthNumber);
        })
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Self Reported
        |--------------------------------------------------------------------------
        */

        $selfData = EmployeeTask::select(
            'employee_id',
            DB::raw('DAY(task_date) as day'),
            DB::raw('ROUND(AVG(self_completion),0) as score')
        )
            ->whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->groupBy('employee_id', DB::raw('DAY(task_date)'))
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Manager Reported
        |--------------------------------------------------------------------------
        */

        $managerData = EmployeeTask::select(
            'employee_id',
            DB::raw('DAY(task_date) as day'),
            DB::raw('ROUND(AVG(manager_completion),0) as score')
        )
            ->whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->groupBy('employee_id', DB::raw('DAY(task_date)'))
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Hours
        |--------------------------------------------------------------------------
        */

        $hours = EmployeeTask::select(
            'employee_id',
            DB::raw('SUM(hours_worked) as total_hours')
        )
            ->whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->groupBy('employee_id')
            ->pluck('total_hours', 'employee_id');

        /*
        |--------------------------------------------------------------------------
        | Activities
        |--------------------------------------------------------------------------
        */

        $activities = EmployeeTask::select(
            'employee_id',
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->groupBy('employee_id')
            ->pluck('total', 'employee_id');

        /*
        |--------------------------------------------------------------------------
        | Convert Collection To Calendar Matrix
        |--------------------------------------------------------------------------
        */

        $selfCalendar = [];

        foreach ($selfData as $row) {
            $selfCalendar[$row->employee_id][$row->day] = $row->score;
        }

        $managerCalendar = [];

        foreach ($managerData as $row) {
            $managerCalendar[$row->employee_id][$row->day] = $row->score;
        }
        /*
|--------------------------------------------------------------------------
| Department Snapshot
|--------------------------------------------------------------------------
*/

        $selfAverages = [];
        $managerAverages = [];

        foreach ($employees as $employee) {

            $employeeId = $employee->employee_id;

            // SELF
            $selfScores = $selfCalendar[$employeeId] ?? [];

            if (count($selfScores)) {
                $selfAverages[$employeeId] = round(array_sum($selfScores) / count($selfScores), 1);
            } else {
                $selfAverages[$employeeId] = 0;
            }

            // MANAGER
            $managerScores = $managerCalendar[$employeeId] ?? [];

            if (count($managerScores)) {
                $managerAverages[$employeeId] = round(array_sum($managerScores) / count($managerScores), 1);
            } else {
                $managerAverages[$employeeId] = 0;
            }

        }

        $topSelfId = !empty($selfAverages)
            ? array_keys($selfAverages, max($selfAverages))[0]
            : null;

        $topManagerId = !empty($managerAverages)
            ? array_keys($managerAverages, max($managerAverages))[0]
            : null;

        $topSelf = $employees->firstWhere('employee_id', $topSelfId);

        $topManager = $employees->firstWhere('employee_id', $topManagerId);

        $departmentSelfAverage = count($selfAverages)
            ? round(array_sum($selfAverages) / count($selfAverages), 1)
            : 0;

        $departmentManagerAverage = count($managerAverages)
            ? round(array_sum($managerAverages) / count($managerAverages), 1)
            : 0;

        $totalHours = EmployeeTask::whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->sum('hours_worked');

        $totalActivities = EmployeeTask::whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->count();

        $totalAligned = EmployeeTask::whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->whereColumn('self_completion', 'manager_completion')
            ->count();

        $totalMismatch = EmployeeTask::whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->whereColumn('self_completion', '!=', 'manager_completion')
            ->count();

        $awaitingVerification = EmployeeTask::whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber)
            ->whereNull('manager_completion')
            ->count();

        return view('admin.manager_employee_tasks.monthly_team_productivity', compact(
            'month',
            'daysInMonth',
            'employees',
            'selfCalendar',
            'managerCalendar',
            'hours',
            'activities',
            'departmentSelfAverage',
            'departmentManagerAverage',
            'totalHours',
            'totalActivities',
            'totalAligned',
            'totalMismatch',
            'awaitingVerification',
            'topSelf',
            'topManager'
        ));
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
    public function show(EmployeeTask $employeeTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(EmployeeTask $employeeTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeTask $employeeTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeTask $employeeTask)
    {
        //
    }

    public function mainDashboard(Request $request)
    {
        $month = $request->month ?? date('Y-m');

        $year = Carbon::parse($month)->year;
        $monthNumber = Carbon::parse($month)->month;

        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        */

        $employees = User::whereIn('employee_id', function ($q) use ($year, $monthNumber) {

            $q->select('employee_id')
                ->from('employee_tasks')
                ->whereYear('task_date', $year)
                ->whereMonth('task_date', $monthNumber);

        })->orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $tasks = EmployeeTask::whereYear('task_date', $year)
            ->whereMonth('task_date', $monthNumber);

        /*
        |--------------------------------------------------------------------------
        | KPI CARDS
        |--------------------------------------------------------------------------
        */

        $departmentSelfAvg = round((clone $tasks)->avg('self_completion'), 1);

        $departmentManagerAvg = round((clone $tasks)->avg('manager_completion'), 1);

        $totalHours = round((clone $tasks)->sum('hours_worked'), 2);

        $totalActivities = (clone $tasks)->count();

        $verifiedTasks = (clone $tasks)
            ->whereNotNull('manager_completion')
            ->count();

        $verificationCoverage = $totalActivities
            ? round(($verifiedTasks / $totalActivities) * 100)
            : 0;

        $daysAligned = (clone $tasks)
            ->whereColumn('self_completion', 'manager_completion')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Daily Trend Chart
        |--------------------------------------------------------------------------
        */

        $dailyTrend = (clone $tasks)

            ->select(

                DB::raw('DAY(task_date) day'),

                DB::raw('AVG(self_completion) self_avg'),

                DB::raw('AVG(manager_completion) manager_avg')

            )

            ->groupBy(DB::raw('DAY(task_date)'))

            ->orderBy('day')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Employee Productivity
        |--------------------------------------------------------------------------
        */

        $employeeProductivity = (clone $tasks)

            ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')

            ->select(

                'users.name',

                DB::raw('AVG(self_completion) self_avg'),

                DB::raw('AVG(manager_completion) manager_avg')

            )

            ->groupBy('users.name')

            ->orderBy('users.name')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Verification Status
        |--------------------------------------------------------------------------
        */

        $verification = (clone $tasks)

            ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')

            ->select(

                'users.name',

                DB::raw('SUM(CASE WHEN self_completion=manager_completion THEN 1 ELSE 0 END) aligned'),

                DB::raw('SUM(CASE WHEN self_completion<>manager_completion THEN 1 ELSE 0 END) mismatch'),

                DB::raw('SUM(CASE WHEN manager_completion IS NULL THEN 1 ELSE 0 END) awaiting')

            )

            ->groupBy('users.name')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Hours Per Employee
        |--------------------------------------------------------------------------
        */

        $hoursPerEmployee = (clone $tasks)

            ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')

            ->select(

                'users.name',

                DB::raw('SUM(hours_worked) total_hours')

            )

            ->groupBy('users.name')

            ->orderByDesc('total_hours')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Priority Distribution
        |--------------------------------------------------------------------------
        */

        $priorityData = (clone $tasks)

            ->select(

                'priority',

                DB::raw('SUM(hours_worked) total_hours')

            )

            ->groupBy('priority')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Employee Summary Table
        |--------------------------------------------------------------------------
        */

        $summary = (clone $tasks)

            ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')

            ->select(

                'users.name',

                DB::raw('SUM(hours_worked) hours'),

                DB::raw('COUNT(*) activities'),

                DB::raw('SUM(CASE WHEN self_completion=manager_completion THEN 1 ELSE 0 END) aligned'),

                DB::raw('SUM(CASE WHEN self_completion<>manager_completion THEN 1 ELSE 0 END) mismatch'),

                DB::raw('SUM(CASE WHEN manager_completion IS NULL THEN 1 ELSE 0 END) awaiting'),

                DB::raw('AVG(self_completion) self_avg'),

                DB::raw('AVG(manager_completion) manager_avg')

            )

            ->groupBy('users.name')

            ->orderBy('users.name')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return view('admin.manager_employee_tasks.visual-dashboard', compact(

            'month',

            'departmentSelfAvg',

            'departmentManagerAvg',

            'totalHours',

            'totalActivities',

            'verificationCoverage',

            'daysAligned',

            'dailyTrend',

            'employeeProductivity',

            'verification',

            'hoursPerEmployee',

            'priorityData',

            'summary'

        ));
    }

    public function facultyRetentionRate(Request $request)
    {
        $filter = $request->filter ?? 'all_time';

        $query = DB::table('faculty_retentions_remarks');

        // Apply Filter
        switch ($filter) {

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate('created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':
                if ($request->filled('from_date')) {
                    $query->whereDate('created_at', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $query->whereDate('created_at', '<=', $request->to_date);
                }
                break;

            case 'all_time':
            default:
                // No filter
                break;
        }

        $result = $query->selectRaw("
            COUNT(*) as total_records,
            ROUND(AVG(CAST(no_retention_rate AS DECIMAL(10,2))),2) as retention_rate
        ")
            ->first();

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => [
                'retention_rate' => $result->retention_rate ?? 0,
                'total_records' => $result->total_records ?? 0,
            ]
        ]);
    }

    public function goalAchievementRate(Request $request)
    {
        $filter = $request->filter ?? 'all_time';

        $query = DB::table('goal_assignment_user_details as gaud')
            ->join('goal_assignment_details as gad', 'gaud.goal_assignment_detail_id', '=', 'gad.id');

        // Apply Date Filter
        switch ($filter) {

            case 'today':
                $query->whereDate('gaud.created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':

                if ($request->filled('from_date')) {
                    $query->whereDate('gaud.created_at', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $query->whereDate('gaud.created_at', '<=', $request->to_date);
                }

                break;

            case 'all_time':
            default:
                // No filter
                break;
        }

        $result = $query->selectRaw("
            COUNT(gaud.id) as total_records,
            SUM(gad.dimension_target) as total_target,
            SUM(gaud.target_achieved) as total_achieved
        ")
            ->first();

        $totalTarget = (float) ($result->total_target ?? 0);
        $totalAchieved = (float) ($result->total_achieved ?? 0);

        $achievementRate = $totalTarget > 0
            ? round(($totalAchieved / $totalTarget) * 100, 2)
            : 0;

        // Optional: Cap at 100%
        $achievementRate = min($achievementRate, 100);

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => [
                'goal_achievement_rate' => $achievementRate,
                'total_target' => round($totalTarget, 2),
                'total_achieved' => round($totalAchieved, 2),
                'total_records' => $result->total_records ?? 0,
            ]
        ]);
    }

    public function departmentWisePerformance(Request $request)
    {
        $filter = $request->filter ?? 'all_time';

        $query = DB::table('goal_assignment_user_details as gaud')
            ->join('goal_assignment_details as gad', 'gaud.goal_assignment_detail_id', '=', 'gad.id')
            ->join('users as u', 'gaud.user_id', '=', 'u.id')
            ->leftJoin('departments as d', 'u.department_id', '=', 'd.id');

        // Apply Date Filter
        switch ($filter) {

            case 'today':
                $query->whereDate('gaud.created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate('gaud.created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':

                if ($request->filled('from_date')) {
                    $query->whereDate('gaud.created_at', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $query->whereDate('gaud.created_at', '<=', $request->to_date);
                }

                break;

            case 'all_time':
            default:
                // No filter
                break;
        }

        $departments = $query
            ->select(
                'u.department_id',
                'd.name as department_name',
                DB::raw('COUNT(DISTINCT gaud.user_id) as total_employees'),
                DB::raw('SUM(gad.dimension_target) as total_target'),
                DB::raw('SUM(gaud.target_achieved) as total_achieved')
            )
            ->groupBy('u.department_id', 'd.name')
            ->orderBy('department_name')
            ->get();

        $data = $departments->map(function ($item) {

            $target = (float) $item->total_target;
            $achieved = (float) $item->total_achieved;

            $performance = $target > 0
                ? round(($achieved / $target) * 100, 2)
                : 0;

            return [
                'department_id' => $item->department_id,
                'department_name' => $item->department_name,
                'total_employees' => $item->total_employees,
                'total_target' => round($target, 2),
                'total_achieved' => round($achieved, 2),
                'performance' => min($performance, 100)
            ];
        });

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => $data
        ]);
    }

    public function performanceReviewDashboard(Request $request)
    {
        $filter = $request->filter ?? 'all_time';

        $query = DB::table('employee_tasks');

        // Date Filters
        switch ($filter) {

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate('created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':

                if ($request->filled('from_date')) {
                    $query->whereDate('created_at', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $query->whereDate('created_at', '<=', $request->to_date);
                }

                break;

            case 'all_time':
            default:
                break;
        }

        $titles = [
            'Timely Conduct of Performance Review',
            'PMS Goal Setting Completion Rate',
            'Mid Year Review Completion Rate',
            'Annual Appraisal Completion Rate',
            '360 Feedback Coverage'
        ];

        $tasks = $query
            ->whereIn('task_title', $titles)
            ->select(
                'task_title',
                DB::raw('COUNT(*) as total_tasks'),
                DB::raw("SUM(CASE WHEN task_status='2' THEN 1 ELSE 0 END) as completed_tasks"),
                DB::raw('ROUND(AVG(manager_completion),2) as completion_rate')
            )
            ->groupBy('task_title')
            ->get()
            ->keyBy('task_title');

        $data = [];

        foreach ($titles as $title) {

            $row = $tasks->get($title);

            $data[] = [
                'kpi' => $title,
                'completion_rate' => $row ? (float) $row->completion_rate : 0,
                'completed_tasks' => $row ? (int) $row->completed_tasks : 0,
                'total_tasks' => $row ? (int) $row->total_tasks : 0,
            ];
        }

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => $data
        ]);
    }

    public function performanceDistribution(Request $request)
    {
        $filter = $request->filter ?? 'all_time';

        $query = DB::table('indicators_percentages')
            ->where('status', '1')
            ->where('is_score', 1);

        // Apply Date Filter
        switch ($filter) {

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate('created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':

                if ($request->filled('from_date')) {
                    $query->whereDate('created_at', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $query->whereDate('created_at', '<=', $request->to_date);
                }

                break;

            case 'all_time':
            default:
                break;
        }

        // Overall score of each employee
        $employees = $query
            ->select(
                'employee_id',
                DB::raw('ROUND(SUM(score),2) as overall_score')
            )
            ->groupBy('employee_id')
            ->get();

        $totalEmployees = $employees->count();

        if ($totalEmployees == 0) {
            return response()->json([
                'success' => true,
                'filter' => $filter,
                'data' => [
                    'total_employees' => 0,
                    'high_performer' => [
                        'count' => 0,
                        'percentage' => 0
                    ],
                    'above_average' => [
                        'count' => 0,
                        'percentage' => 0
                    ],
                    'meet_expectations' => [
                        'count' => 0,
                        'percentage' => 0
                    ],
                    'below_expectations' => [
                        'count' => 0,
                        'percentage' => 0
                    ]
                ]
            ]);
        }

        $high = $employees->where('overall_score', '>=', 90)->count();

        $above = $employees->filter(function ($e) {
            return $e->overall_score >= 80 && $e->overall_score < 90;
        })->count();

        $meet = $employees->filter(function ($e) {
            return $e->overall_score >= 70 && $e->overall_score < 80;
        })->count();

        $below = $employees->filter(function ($e) {
            return $e->overall_score > 0 && $e->overall_score < 70;
        })->count();

        $notEvaluated = $employees->filter(function ($e) {
            return $e->overall_score <= 0;
        })->count();

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => [
                'total_employees' => $totalEmployees,

                'high_performer' => [
                    'count' => $high,
                    'percentage' => round(($high / $totalEmployees) * 100, 2)
                ],

                'above_average' => [
                    'count' => $above,
                    'percentage' => round(($above / $totalEmployees) * 100, 2)
                ],

                'meet_expectations' => [
                    'count' => $meet,
                    'percentage' => round(($meet / $totalEmployees) * 100, 2)
                ],

                'below_expectations' => [
                    'count' => $below,
                    'percentage' => round(($below / $totalEmployees) * 100, 2)
                ],
                'not_evaluated' => $notEvaluated
            ]
        ]);
    }

    public function productivityIndexSummary(Request $request)
    {
        $filter = $request->filter ?? 'all_time';

        $query = EmployeeTask::query();

        switch ($filter) {

            case 'today':
                $query->whereDate('task_date', today());
                break;

            case 'last_30_days':
                $query->whereDate('task_date', '>=', now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('task_date', '>=', now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate('task_date', '>=', now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate('task_date', '>=', now()->subYear());
                break;

            case 'custom':
                if ($request->filled('from_date'))
                    $query->whereDate('task_date', '>=', $request->from_date);

                if ($request->filled('to_date'))
                    $query->whereDate('task_date', '<=', $request->to_date);
                break;
        }

        $summary = $query->selectRaw("
        COUNT(*) total_tasks,
        SUM(CASE WHEN task_status='2' THEN 1 ELSE 0 END) completed_tasks,
        ROUND(AVG(manager_completion),2) avg_completion,
        SUM(hours_worked) total_hours,
        SUM(estimated_hours) estimated_hours
    ")->first();

        $completionRate = $summary->total_tasks
            ? ($summary->completed_tasks / $summary->total_tasks) * 100
            : 0;

        $timeEfficiency = $summary->estimated_hours > 0
            ? min(($summary->total_hours / $summary->estimated_hours) * 100, 100)
            : 0;

        $productivityIndex = round(
            ($summary->avg_completion + $completionRate + $timeEfficiency) / 3,
            2
        );

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => [
                'productivity_index' => $productivityIndex,
                'average_completion' => round($summary->avg_completion, 2),
                'task_completion_rate' => round($completionRate, 2),
                'time_efficiency' => round($timeEfficiency, 2),
                'completed_tasks' => $summary->completed_tasks,
                'total_tasks' => $summary->total_tasks
            ]
        ]);
    }

    public function productivityTrend(Request $request)
    {
        $filter = $request->filter ?? 'last_30_days';

        $query = EmployeeTask::query();

        switch ($filter) {

            case 'today':
                $query->whereDate('task_date', today());
                $group = "DATE(task_date)";
                break;

            case 'last_30_days':
                $query->whereDate('task_date', '>=', now()->subDays(30));
                $group = "DATE(task_date)";
                break;

            case 'quarter':
            case 'last_6_months':
            case 'last_1_year':
                if ($filter == 'quarter')
                    $query->whereDate('task_date', '>=', now()->subMonths(3));

                if ($filter == 'last_6_months')
                    $query->whereDate('task_date', '>=', now()->subMonths(6));

                if ($filter == 'last_1_year')
                    $query->whereDate('task_date', '>=', now()->subYear());

                $group = "DATE_FORMAT(task_date,'%Y-%m')";
                break;

            case 'custom':
                $query->whereBetween('task_date', [
                    $request->from_date,
                    $request->to_date
                ]);

                $group = "DATE(task_date)";
                break;

            default:
                $group = "DATE_FORMAT(task_date,'%Y-%m')";
        }

        $trend = $query
            ->selectRaw("
            $group period,
            ROUND(AVG(manager_completion),2) productivity
        ")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return response()->json([
            'success' => true,
            'filter' => $filter,
            'data' => $trend
        ]);
    }

    public function employeeNetPromoterScore(Request $request)
    {
        $query = DB::table('faculty_net_promoter_scores')
            ->where('status', '1');

        // Apply Date Filter
        switch ($request->filter) {

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'last30':
                $query->whereDate('created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last6months':
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last1year':
                $query->whereDate('created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $query->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                }
                break;

            case 'all':
            default:
                // No filter
                break;
        }

        $totalSurveyed = (clone $query)->sum('total_faculty_surveyed');

        $totalPromoters = (clone $query)->sum('number_of_promoters');

        $promoterPercentage = $totalSurveyed > 0
            ? round(($totalPromoters / $totalSurveyed) * 100, 2)
            : 0;

        $promotersPercentage = round(
            $query->avg('promoters_percentage'),
            2
        );

        // Placeholder values because schema doesn't store them
        $totalPassives = 0;
        $totalDetractors = 0;
        $passivePercentage = 0;
        $detractorPercentage = 0;

        // Placeholder NPS
        $employeeNps = round($promoterPercentage - $detractorPercentage, 2);

        return response()->json([
            'success' => true,
            'filter' => $request->filter ?? 'all',

            'data' => [

                'total_surveyed' => $totalSurveyed,

                'employee_net_promoter_score' => $employeeNps,

                'distributions' => [

                    'promoters' => [
                        'count' => $totalPromoters,
                        'percentage' => $promoterPercentage
                    ],

                    'passives' => [
                        'count' => $totalPassives,
                        'percentage' => $passivePercentage
                    ],

                    'detractors' => [
                        'count' => $totalDetractors,
                        'percentage' => $detractorPercentage
                    ]
                ]
            ]
        ]);
    }

    public function leadershipSatisfactionScore(Request $request)
    {
        $query = IndicatorsPercentage::where('indicator_id', 188)
            ->where('status', '1')
            ->where('score', '>', 0);

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        switch ($request->get('filter', 'all_time')) {

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereBetween('created_at', [
                    Carbon::now()->subDays(30)->startOfDay(),
                    Carbon::now()->endOfDay()
                ]);
                break;

            case 'quarter':
                $query->whereBetween('created_at', [
                    Carbon::now()->subMonths(3)->startOfDay(),
                    Carbon::now()->endOfDay()
                ]);
                break;

            case 'last_six_months':
                $query->whereBetween('created_at', [
                    Carbon::now()->subMonths(6)->startOfDay(),
                    Carbon::now()->endOfDay()
                ]);
                break;

            case 'last_one_year':
                $query->whereBetween('created_at', [
                    Carbon::now()->subYear()->startOfDay(),
                    Carbon::now()->endOfDay()
                ]);
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween('created_at', [
                        Carbon::parse($request->from_date)->startOfDay(),
                        Carbon::parse($request->to_date)->endOfDay(),
                    ]);

                }

                break;

            case 'all_time':
            default:
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Fetch records ONCE
        |--------------------------------------------------------------------------
        */

        $records = $query->get();

        $totalResponses = $records->count();

        $averageScore = round((float) $records->avg('score'), 2);

        // Rating out of 5
        $ratingScale = round(($averageScore / 100) * 5, 2);

        /*
        |--------------------------------------------------------------------------
        | Satisfaction Level
        |--------------------------------------------------------------------------
        */

        if ($ratingScale >= 4.50) {
            $level = 'Excellent';
        } elseif ($ratingScale >= 3.50) {
            $level = 'Good';
        } elseif ($ratingScale >= 2.50) {
            $level = 'Average';
        } elseif ($ratingScale >= 1.50) {
            $level = 'Poor';
        } else {
            $level = 'Very Poor';
        }

        return response()->json([
            'success' => true,
            'filter' => $request->get('filter', 'all_time'),
            'data' => [
                'leadership_satisfaction_score' => $averageScore,
                'rating_scale' => $ratingScale,
                'maximum_rating' => 5,
                'satisfaction_level' => $level,
                'total_responses' => $totalResponses,
            ]
        ]);
    }

}
