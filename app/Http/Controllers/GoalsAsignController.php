<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use App\Models\GoalAssignment;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class GoalsAsignController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = GoalAssignment::select(
                'role_id',
                'goal_id',
                'kpa_id'
            )
                ->selectRaw('COUNT(*) as total_dimensions')
                ->groupBy(
                    'role_id',
                    'goal_id',
                    'kpa_id'
                );

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('role', function ($row) {
                    return Role::find($row->role_id)?->name;
                })

                ->addColumn('goal', function ($row) {
                    return Goal::find($row->goal_id)?->goal_name;
                })

                ->addColumn('kpa', function ($row) {
                    return KeyPerformanceArea::find($row->kpa_id)?->performance_area;
                })

                ->addColumn('dimensions', function ($row) {
                    return $row->total_dimensions;
                })

                ->addColumn('action', function ($row) {

                    $edit = route(
                        'goals-assign.group.edit',
                        [
                            'role_id' => $row->role_id,
                            'goal_id' => $row->goal_id,
                            'kpa_id' => $row->kpa_id
                        ]
                    );

                    $delete = route(
                        'goals-assign.destroyGroup',
                        [
                            'role_id' => $row->role_id,
                            'goal_id' => $row->goal_id,
                            'kpa_id' => $row->kpa_id
                        ]
                    );

                    return '
        <a href="' . $edit . '"
           class="btn btn-sm btn-primary">
           Edit
        </a>

        <button
            class="btn btn-sm btn-danger deleteBtn"
            data-url="' . $delete . '">
            Delete
        </button>
    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.goals_assign.index');
    }

    public function create()
    {

        $goals = Goal::with('objectives.dimensions')->get();
        $kpas = KeyPerformanceArea::all();
        $roles = Role::all();

        return view('admin.goals_assign.create', compact('goals', 'kpas', 'roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'kpa_id' => 'required',
            'goals' => 'required|array|min:1',
        ]);
        $existing = GoalAssignment::where('role_id', $request->role_id)
            ->where('kpa_id', $request->kpa_id)
            ->pluck('goal_id')
            ->toArray();

        $skippedGoals = [];

        foreach ($request->goals as $goalId => $goalData) {

            // collect duplicates instead of silent skip
            if (in_array($goalId, $existing)) {
                $skippedGoals[] = $goalId;
                continue;
            }

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

        if (!empty($skippedGoals)) {

            return response()->json([
                'success' => true,
                'message' => 'Saved successfully, but some goals were already assigned.',
                'skipped_goals' => $skippedGoals
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'All goals assigned successfully.'
        ]);
    }


    public function edit($roleId, $goalId, $kpaId)
    {
        $assignments = GoalAssignment::where([
            'role_id' => $roleId,
            'goal_id' => $goalId,
            'kpa_id' => $kpaId
        ])->get();

        $roles = Role::all();
        $kpas = KeyPerformanceArea::all();

        $goals = Goal::with([
            'objectives.dimensions'
        ])->get();

        // ✅ THIS IS WHAT YOU MISSED
        $mapped = [];

        foreach ($assignments as $a) {
            $mapped[$a->goal_id]
            [$a->objective_id]
            [$a->dimension_id] = [
                'dimension_target' => $a->dimension_target,
                'dimension_weight' => $a->dimension_weight,
                'kpis' => $a->kpi_ids ?? []
            ];
        }

        return view('admin.goals_assign.edit', compact(
            'assignments',
            'roles',
            'kpas',
            'goals',
            'mapped',
            'roleId',
            'goalId',
            'kpaId'
        ));
    }
    public function updateGroup(Request $request)
    {
        // STEP 1: delete old group
        GoalAssignment::where([
            'role_id' => $request->old_role_id,
            'goal_id' => $request->old_goal_id,
            'kpa_id' => $request->old_kpa_id,
        ])->delete();

        // STEP 2: insert new structure
        foreach ($request->goals as $goalId => $goalData) {

            foreach ($goalData['objectives'] as $objId => $objData) {

                foreach ($objData['dimensions'] as $dimId => $dimData) {

                    GoalAssignment::create([
                        'role_id' => $request->role_id,
                        'goal_id' => $goalId,
                        'objective_id' => $objId,
                        'dimension_id' => $dimId,
                        'kpa_id' => $request->kpa_id,
                        'dimension_target' => $dimData['dimension_target'] ?? null,
                        'dimension_weight' => $dimData['dimension_weight'] ?? null,
                        'kpi_ids' => $dimData['kpis'] ?? [],
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully'
        ]);
    }
    public function destroyGroup(Request $request)
    {
        GoalAssignment::where([
            'role_id' => $request->role_id,
            'goal_id' => $request->goal_id,
            'kpa_id' => $request->kpa_id
        ])->delete();

        return response()->json([
            'success' => true
        ]);
    }
    public function viewAssignGoal()
{
    $data = GoalAssignment::select(
            'role_id',
            'goal_id',
            'kpa_id'
        )
        ->groupBy(
            'role_id',
            'goal_id',
            'kpa_id'
        )
        ->get();

    $assignments = [];

    foreach ($data as $row) {

        $assignments[] = [
            'role_id' => $row->role_id,
            'goal_id' => $row->goal_id,
            'kpa_id'  => $row->kpa_id,

            'data' => GoalAssignment::where([
                'role_id' => $row->role_id,
                'goal_id' => $row->goal_id,
                'kpa_id'  => $row->kpa_id
            ])->get()
        ];
    }

    return view('admin.goals_assign.view', compact('assignments'));
}
}
