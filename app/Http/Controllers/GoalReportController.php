<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Goal;
use App\Models\GoalAssignment;
use App\Models\IndicatorCategory;
use Illuminate\Http\Request;

class GoalReportController extends Controller
{
    public function pdf($role_id = null, $goal_id = null, $kpa_id = null)
    {
        $query = GoalAssignment::with([
            'role',
            'goal.driver',
            'objective',
            'dimension',
            'kpa'
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

        $assignments = $query
            ->orderBy('goal_id')
            ->orderBy('objective_id')
            ->orderBy('dimension_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | KPI Mapping
        |--------------------------------------------------------------------------
        */

        $allKpiIds = $assignments
            ->pluck('kpi_ids')
            ->flatten()
            ->filter()
            ->unique()
            ->toArray();

        $kpis = IndicatorCategory::whereIn('id', $allKpiIds)
            ->pluck('indicator_category', 'id');

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT FIX:
        | DO NOT groupBy — instead group manually in Blade or map properly
        |--------------------------------------------------------------------------
        */

        $goals = $assignments->groupBy('goal_id')->map(function ($items) {
            return $items->first()->goal;
        });

        $pdf = PDF::loadView(
            'admin.goals_assign.goal-mapping-pdf',
            compact('assignments', 'goals', 'kpis')
        );

        return $pdf->setPaper('a4', 'landscape')
            ->stream('goal-mapping-report.pdf');
    }
}