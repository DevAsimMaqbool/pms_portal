<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use App\Models\GoalAssignment;
use App\Models\GoalAssignmentDetail;
use App\Models\GoalAssignmentIndicator;
use App\Models\GoalAssignmentUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class GoalsAsignController extends Controller
{
   public function index(Request $request)
{
    if ($request->ajax()) {
        $userId = Auth::id();
        $data = GoalAssignment::with(['role', 'goal', 'kpa'])->where('created_by',  $userId) ->get();

        return DataTables::of($data)

            ->addIndexColumn()

            ->addColumn('role', function ($row) {
                return optional($row->role)->name;
            })

            ->addColumn('goal', function ($row) {
                return optional($row->goal)->goal_name;
            })

            ->addColumn('kpa', function ($row) {
                return optional($row->kpa)->performance_area;
            })

            ->addColumn('dimensions', function ($row) {

                return GoalAssignmentDetail::where(
                    'goal_assignment_id',
                    $row->id
                )->count();

            })

            ->addColumn('action', function ($row) {

                $edit = route('goals-assign.edit', $row->id);

                $delete = route('goals-assign.destroy', $row->id);

                return '
                    <a href="'.$edit.'" class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <button
                        class="btn btn-sm btn-danger deleteBtn"
                        data-url="'.$delete.'">
                        Delete
                    </button>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.goals_assign.index');
}
    public function creates($id = null)
    {
        $userId = Auth::id();
        $goals = Goal::with('objectives.dimensions')->get();
        $kpas = KeyPerformanceArea::all();
        $roles = Role::all();
        $assignment = null;
        if ($id) {

            $query = GoalAssignment::with([
                'users.user',
                'details.indicators',
            ])->where('id', $id);

            if ($userId) {
                $query->whereHas('users', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            }

            $assignment = $query->firstOrFail();
        }


        return view('admin.goals_assign.create', compact('goals', 'kpas', 'roles','assignment'));
    }
    public function show()
    {

        $goals = Goal::with('objectives.dimensions')->get();
        $kpas = KeyPerformanceArea::all();
        $roles = Role::all();
        $assignment = null;

        return view('admin.goals_assign.create', compact('goals', 'kpas', 'roles','assignment'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'kpa_id' => 'required',
            'kpi_id' => 'required',
            'employee_ids' => 'required|array',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | One Assignment Per Goal
            |--------------------------------------------------------------------------
            */

            foreach ($request->goals as $goalId => $goalData) {

            foreach ($request->employee_ids as $employeeId) {

        $exists = GoalAssignment::where([
                'role_id' => $request->role_id,
                'goal_id' => $goalId,
                'kpa_id'  => $request->kpa_id,
                'kpa_cid' => $request->kpi_id,
            ])
            ->whereHas('users', function ($q) use ($employeeId) {
                $q->where('user_id', $employeeId);
            })
            ->whereHas('details.indicators', function ($q) use ($goalData) {

                $indicatorIds = [];

                if (isset($goalData['objectives'])) {

                    foreach ($goalData['objectives'] as $objective) {

                        if (!isset($objective['dimensions'])) {
                            continue;
                        }

                        foreach ($objective['dimensions'] as $dimension) {

                            if (!empty($dimension['kpis'])) {

                                $indicatorIds = array_merge(
                                    $indicatorIds,
                                    $dimension['kpis']
                                );
                            }
                        }
                    }
                }

                $q->whereIn('indicator_id', $indicatorIds);

            })
            ->exists();

        if ($exists) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Duplicate record is not allowed. This employee already has the selected Goal and Indicators assigned.'
            ], 422);
        }
    }

                /*
                |--------------------------------------------------------------------------
                | Save Master
                |--------------------------------------------------------------------------
                */

                $assignment = GoalAssignment::create([

                    'role_id'    => $request->role_id,

                    'goal_id'    => $goalId,

                    'kpa_id'     => $request->kpa_id,

                    'kpa_cid'    => $request->kpi_id,

                    'validate'   => 1,

                    'status'     => 'Active',

                    'created_by' => auth()->id(),

                    'updated_by' => auth()->id(),

                ]);

                /*
                |--------------------------------------------------------------------------
                | Employees
                |--------------------------------------------------------------------------
                */

                foreach ($request->employee_ids as $employeeId) {

                    GoalAssignmentUser::create([

                        'goal_assignment_id' => $assignment->id,

                        'user_id'            => $employeeId,

                    ]);

                }

                /*
                |--------------------------------------------------------------------------
                | Objectives
                |--------------------------------------------------------------------------
                */

                if (!isset($goalData['objectives'])) {
                    continue;
                }

                foreach ($goalData['objectives'] as $objectiveId => $objective) {

                    if (!isset($objective['dimensions'])) {
                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Dimensions
                    |--------------------------------------------------------------------------
                    */

                    foreach ($objective['dimensions'] as $dimensionId => $dimension) {

                        $detail = GoalAssignmentDetail::create([

                            'goal_assignment_id' => $assignment->id,

                            'goal_id'            => $goalId,

                            'objective_id'       => $objectiveId,

                            'dimension_id'       => $dimensionId,

                            'dimension_target'             => $dimension['target'] ?? 0,

                            'dimension_weight'             => $dimension['weight'] ?? 0,

                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | Indicators
                        |--------------------------------------------------------------------------
                        */

                        if (!empty($dimension['kpis'])) {

                            foreach ($dimension['kpis'] as $indicatorId) {

                                GoalAssignmentIndicator::create([

                                    'goal_assignment_detail_id' => $detail->id,

                                    'indicator_id'              => $indicatorId,

                                ]);

                            }

                        }

                    }

                }

            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Goal Assignment Saved Successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $assignment = GoalAssignment::with([
            'users.user',
            'details.indicators',
        ])->findOrFail($id);

        $roles = Role::all();

        $kpas = KeyPerformanceArea::all();

        $goals = Goal::with([
            'objectives.dimensions'
        ])->get();

        return view('admin.goals_assign.edit', compact(
            'assignment',
            'roles',
            'kpas',
            'goals'
        ));
    }
public function update(Request $request, $id)
{
    $request->validate([
        'role_id'      => 'required',
        'kpa_id'       => 'required',
        'kpi_id'       => 'required',
        'employee_ids' => 'required|array',
        'goals'        => 'required|array',
    ]);

    DB::beginTransaction();

    try {

        $assignment = GoalAssignment::findOrFail($id);

        //=================================================
        // Master Update
        //=================================================

        $goalId = array_key_first($request->goals);

        $assignment->update([
            'role_id'    => $request->role_id,
            'goal_id'    => $goalId,
            'kpa_id'     => $request->kpa_id,
            'kpa_cid'    => $request->kpi_id,
            'updated_by' => auth()->id(),
        ]);

        //=================================================
        // Employees (Sync)
        //=================================================

        GoalAssignmentUser::where('goal_assignment_id', $assignment->id)
            ->whereNotIn('user_id', $request->employee_ids)
            ->delete();

        foreach ($request->employee_ids as $employeeId) {

            GoalAssignmentUser::firstOrCreate([
                'goal_assignment_id' => $assignment->id,
                'user_id'            => $employeeId,
            ]);
        }

        //=================================================
        // Details & Indicators
        //=================================================

        $keepDetailIds = [];

        foreach ($request->goals as $goalId => $goal) {

            if (!isset($goal['objectives'])) {
                continue;
            }

            foreach ($goal['objectives'] as $objectiveId => $objective) {

                if (!isset($objective['dimensions'])) {
                    continue;
                }

                foreach ($objective['dimensions'] as $dimensionId => $dimension) {

                    //------------------------------------------
                    // Update or Create Detail
                    //------------------------------------------

                    $detail = GoalAssignmentDetail::updateOrCreate(

                        [
                            'goal_assignment_id' => $assignment->id,
                            'goal_id'            => $goalId,
                            'objective_id'       => $objectiveId,
                            'dimension_id'       => $dimensionId,
                        ],

                        [
                            'dimension_target' => $dimension['target'] ?? 0,
                            'dimension_weight' => $dimension['weight'] ?? 0,
                        ]
                    );

                    $keepDetailIds[] = $detail->id;

                    //------------------------------------------
                    // Indicators Sync
                    //------------------------------------------

                    $indicatorIds = $dimension['kpis'] ?? [];

                    GoalAssignmentIndicator::where(
                        'goal_assignment_detail_id',
                        $detail->id
                    )
                    ->whereNotIn('indicator_id', $indicatorIds)
                    ->delete();

                    foreach ($indicatorIds as $indicatorId) {

                        GoalAssignmentIndicator::firstOrCreate([

                            'goal_assignment_detail_id' => $detail->id,

                            'indicator_id' => $indicatorId,

                        ]);

                    }

                }

            }

        }

        //=================================================
        // Delete Removed Details
        //=================================================

        $deleteDetailIds = GoalAssignmentDetail::where(
                'goal_assignment_id',
                $assignment->id
            )
            ->whereNotIn('id', $keepDetailIds)
            ->pluck('id')
            ->toArray();

        if (!empty($deleteDetailIds)) {

            GoalAssignmentIndicator::whereIn(
                'goal_assignment_detail_id',
                $deleteDetailIds
            )->delete();

            GoalAssignmentDetail::whereIn(
                'id',
                $deleteDetailIds
            )->delete();
        }

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Goal Assignment Updated Successfully.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => $e->getMessage(),
        ], 500);

    }
}
    public function destroy($id)
{
    DB::beginTransaction();

    try {

        $assignment = GoalAssignment::findOrFail($id);

        // Delete indicators
        $detailIds = GoalAssignmentDetail::where(
            'goal_assignment_id',
            $assignment->id
        )->pluck('id');

        GoalAssignmentIndicator::whereIn(
            'goal_assignment_detail_id',
            $detailIds
        )->delete();

        // Delete details
        GoalAssignmentDetail::where(
            'goal_assignment_id',
            $assignment->id
        )->delete();

        // Delete employees
        GoalAssignmentUser::where(
            'goal_assignment_id',
            $assignment->id
        )->delete();

        // Delete assignment
        $assignment->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Goal Assignment deleted successfully.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ],500);

    }
}
    public function viewAssignGoal11()
{
    $data = GoalAssignment::select(
            'role_id',
            'goal_id',
            'kpa_id',
            'kpa_cid'
        )
        ->groupBy(
            'role_id',
            'goal_id',
            'kpa_id',
            'kpa_cid'
        )
        ->get();

    $assignments = [];

    foreach ($data as $row) {

        $assignments[] = [
            'role_id' => $row->role_id,
            'goal_id' => $row->goal_id,
            'kpa_id'  => $row->kpa_id,
            'kpa_cid'  => $row->kpa_cid,

            'data' => GoalAssignment::where([
                'role_id' => $row->role_id,
                'goal_id' => $row->goal_id,
                'kpa_id'  => $row->kpa_id,
                'kpa_cid'  => $row->kpa_cid
            ])->get()
        ];
    }

    return view('admin.goals_assign.view', compact('assignments'));
}
public function viewAssignGoal()
{
    $userId = Auth::id();
    $assignments = GoalAssignment::with([
        'role',
        'goal.driver',
        'users.user',
        'details.objective',
        'details.dimension',
        'details.indicators.indicator'
    ])->where('created_by', $userId)->get();

    // Group details by objective_id
    $assignments->each(function ($assignment) {
        $assignment->groupedObjectives = $assignment->details->groupBy('objective_id');
    });

    return view('admin.goals_assign.view', compact('assignments'));
}
public function viewAssignToGoal()
{
    $userId = Auth::id();

    $assignments = GoalAssignment::with([
        'role',
        'goal.driver',
        'details.objective',
        'details.dimension',
        'details.indicators.indicator',
        'users' => function ($q) use ($userId) {
            $q->where('user_id', $userId)->with('user');
        }
    ])
    ->whereHas('users', function ($q) use ($userId) {
        $q->where('user_id', $userId);
    })
    ->get();

    $assignments->each(function ($assignment) {
        $assignment->groupedObjectives = $assignment->details->groupBy('objective_id');
    });

    return view('admin.goals_assign.view_to', compact('assignments'));
}
public function getEmployees($roleId)
{
    $user = Auth::user();
    $employee_id = $user->employee_id;
    $role = Role::findOrFail($roleId);

    $users = User::where('manager_id', $employee_id)->role($role->name)
        ->select('id', 'name', 'email')
        ->orderBy('name')
        ->get();
    return response()->json($users);
}
}
