<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewGoal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewGoalController extends Controller
{

    public function goalsDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = DB::table('new_goals as rpt');

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'today':
                $query->whereDate('rpt.created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_six_months':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_one_year':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween('rpt.created_at', [
                        Carbon::parse($request->from_date)->startOfDay(),
                        Carbon::parse($request->to_date)->endOfDay()
                    ]);
                }

                break;

            case 'all_time':
            default:
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Cards
        |--------------------------------------------------------------------------
        */

        $totalGoals = (clone $query)->count();

        $userCount = (clone $query)
            ->distinct()
            ->count('rpt.user_id');

        $goalPerUser = $userCount > 0
            ? round($totalGoals / $userCount, 2)
            : 0;

            /*
            |--------------------------------------------------------------------------
            | Driver-Wise Goals Summary
            |--------------------------------------------------------------------------
            */

            $driverSummary = (clone $query)
                ->join(
                    's2_r_drivers as drivers',
                    'drivers.id',
                    '=',
                    'rpt.s2r_driver_enabler_alignment'
                )
                ->select(
                    'drivers.id as driver_id',
                    'drivers.driver_name',
                    DB::raw('COUNT(rpt.id) as total_goals')
                )
                ->groupBy('drivers.id', 'drivers.driver_name')
                ->orderBy('drivers.driver_name')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Trend Over Years
        |--------------------------------------------------------------------------
        */

        $trend = (clone $query)
            ->selectRaw("
            YEAR(rpt.created_at) as year,
            COUNT(*) as total
        ")
            ->groupBy(DB::raw('YEAR(rpt.created_at)'))
            ->orderBy('year')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filter' => $request->filter ?? 'all_time',

            'data' => [

                'total_goals' => $totalGoals,

                'goal_per_user' => $goalPerUser,
                'driver_summary' => $driverSummary
            ]

        ]);
    }

}
