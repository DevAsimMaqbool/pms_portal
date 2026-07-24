<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Goal;
use App\Models\GoalAssignment;
use App\Models\IndicatorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalReportController extends Controller
{
    public function pdf($role_id = null, $goal_id = null, $kpa_id = null)
    {
        $query = GoalAssignment::with([
            'role',
            'goal.driver',
            'kpa',
            'details.objective',
            'details.dimension',
            'details.indicators.indicator'
        ]);

        if ($role_id) {
            $query->where('role_id', $role_id);
        }

        if ($goal_id) {
            $query->where('goal_id', $goal_id);
        }

        if ($kpa_id) {
            $query->where('kpa_id', $kpa_id);
        }
        $userId = Auth::id();

        $assignments = $query
            ->where('created_by',  $userId)->orderBy('goal_id')
            ->get();
            

        $pdf = PDF::loadView(
            'admin.goals_assign.goal-mapping-pdf',
            compact('assignments')
        );

        return $pdf->setPaper('a4','landscape')
                ->stream('goal-mapping-report.pdf');
    }
}