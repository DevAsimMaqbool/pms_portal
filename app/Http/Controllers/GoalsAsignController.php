<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use App\Models\GoalAssignment;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class GoalsAsignController extends Controller
{
     public function index(Request $request)
    {
        $data = GoalAssignment::with(['role', 'kpa'])
            ->get()
            ->groupBy([
                'role_id',
                'kpa_id'
            ]);
        //$goal = Goal::with(['objectives.dimensions.goalAssignments.role', 'objectives.dimensions.goalAssignments.kpa',])->get();
        dd($data);    
        if ($request->ajax()) {

            $data = GoalAssignment::with([
                'role',
                'dimension',
                'kpa'
            ])->latest();

        }
           

        return view('admin.goals_assign.index');
    }
    
    public function create()
    {

        $goals = Goal::with('objectives.dimensions')->get();
        $kpas= KeyPerformanceArea::all();
        $roles = Role::all();

        return view('admin.goals_assign.create', compact('goals','kpas','roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'kpa_id' => 'required',
            'goals' => 'required|array|min:1',
        ]);

        foreach ($request->goals as $goalId => $goalData) {

            foreach ($goalData['objectives'] as $objId => $objData) {

                foreach ($objData['dimensions'] as $dimId => $dimData) {

                    if (
                        empty($dimData['target']) ||
                        empty($dimData['weight']) ||
                        empty($dimData['kpis'])
                    ) {
                        return response()->json([
                            'success' => false,
                            'message' => 'All fields are required in each dimension'
                        ], 422);
                    }

                    GoalAssignment::create([
                        'role_id' => $request->role_id,
                        'goal_id' => $goalId,
                        'objective_id' => $objId,
                        'dimension_id' => $dimId,
                        'kpa_id' => $request->kpa_id,
                        'dimension_target' => $dimData['target'],
                        'dimension_weight' => $dimData['weight'],
                        'kpi_ids' => $dimData['kpis'],
                    ]);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
