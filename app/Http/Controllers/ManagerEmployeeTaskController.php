<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
use App\Models\User;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagerEmployeeTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = EmployeeTask::query()
                ->join('users', 'users.employee_id', '=', 'employee_tasks.employee_id')
                ->select(
                    'employee_tasks.employee_id',
                    'users.name',
                    DB::raw('COUNT(employee_tasks.id) as activities'),
                    DB::raw('SUM(employee_tasks.hours_worked) as hours'),
                    DB::raw('AVG(employee_tasks.self_completion) as self_score'),
                    DB::raw('AVG(employee_tasks.manager_completion) as mgr_score')
                );
            if ($request->filled('from_date') && $request->filled('to_date')) {

                $data->whereBetween('employee_tasks.task_date', [
                    $request->from_date,
                    $request->to_date
                ]);

            } elseif ($request->filled('from_date')) {

                $data->whereDate('employee_tasks.task_date', '>=', $request->from_date);

            } elseif ($request->filled('to_date')) {

                $data->whereDate('employee_tasks.task_date', '<=', $request->to_date);
            }
            $data->groupBy(
                'employee_tasks.employee_id',
                'users.name'
            );

            return DataTables::of($data)

                ->addIndexColumn()

                ->editColumn('hours', function ($row) {
                    return number_format($row->hours, 2);
                })

                ->addColumn('self_exec', function ($row) {
                    return 0;
                })

                ->editColumn('self_score', function ($row) {
                    return number_format($row->self_score, 2);
                })

                ->addColumn('self_rating', function ($row) {
                    return $this->rating($row->self_score);
                })

                ->addColumn('mgr_exec', function ($row) {
                    return 0;
                })

                ->editColumn('mgr_score', function ($row) {
                    return number_format($row->mgr_score, 2);
                })

                ->addColumn('mgr_rating', function ($row) {
                    return $this->rating($row->mgr_score);
                })

                ->addColumn('variance', function ($row) {
                    return number_format($row->self_score - $row->mgr_score, 2);
                })

                ->addColumn('match', function ($row) {

                    return round($row->self_score, 2) == round($row->mgr_score, 2)
                        ? '<span class="badge bg-success">Aligned</span>'
                        : '<span class="badge bg-danger">Not Aligned</span>';
                })

                ->rawColumns(['match'])

                ->make(true);
        }

        return view('admin.manager_employee_tasks.index');
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
                        'variance' => round($avgMgr - $avgSelf, 2),
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

}
