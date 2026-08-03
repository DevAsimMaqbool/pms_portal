<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use App\Models\GoalAssignment;
use App\Models\GoalAssignmentDetail;
use App\Models\GoalAssignmentIndicator;
use App\Models\GoalAssignmentUser;
use App\Models\GoalAssignmentUserDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ViewAsignedGoalsController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $userId = Auth::id();

            // $data = GoalAssignment::with(['role', 'goal', 'kpa'])
            //     ->whereHas('users', function ($q) use ($userId) {
            //         $q->where('user_id', $userId);
            //     })
            //     ->get();
            $data = GoalAssignment::with([
                'role',
                'goal',
                'kpa',
                'details.userDetails' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                }
            ])
                ->whereHas('users', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->get();

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

                //             ->addColumn('action', function ($row) {

                //                 $edit = route('view-assign-goals.edit', $row->id);

                //                 $submitted = $row->details->contains(function ($detail) {
                //                     return $detail->userDetails->isNotEmpty();
                //                 });

                //                 if ($submitted) {
                //                     return '<span class="badge bg-success">Target Submitted</span>';
                //                 }

                //                 return '
                //     <a href="' . $edit . '" class="btn btn-sm btn-primary">
                //         Submit Target
                //     </a>
                // ';
                //             })

                ->addColumn('action', function ($row) {

                    $edit = route('view-assign-goals.edit', $row->id);

                    return '
                    <a href="' . $edit . '" class="btn btn-sm btn-primary">
                        Submit Target
                    </a>
                ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.view_assigned_goals.index');

    }

    public function edit($id)
    {
        $assignment = GoalAssignment::with([
            'users.user',
            'details.indicators',
        ])->findOrFail($id);

        $assignment = GoalAssignment::with([
            'users.user',
            'details.indicators',
            'details.userDetails'
        ])->findOrFail($id);

        $roles = Role::all();

        $kpas = KeyPerformanceArea::all();

        $goals = Goal::with([
            'objectives.dimensions'
        ])->get();

        return view('admin.view_assigned_goals.edit', compact(
            'assignment',
            'roles',
            'kpas',
            'goals'
        ));
    }

    public function managerVerifcation($id)
    {
        $assignment = GoalAssignment::with([
            'users.user',
            'details.indicators',
        ])->findOrFail($id);

        $assignment = GoalAssignment::with([
            'users.user',
            'details.indicators',
            'details.userDetails'
        ])->findOrFail($id);

        $roles = Role::all();

        $kpas = KeyPerformanceArea::all();

        $goals = Goal::with([
            'objectives.dimensions'
        ])->get();

        return view('admin.view_assigned_goals.manager_verification', compact(
            'assignment',
            'roles',
            'kpas',
            'goals'
        ));
    }

    public function managerVerify(Request $request, $id)
    {
        $request->validate([
            'progress' => 'required|array',
        ]);
        DB::beginTransaction();

        try {

            foreach ($request->progress as $detailId => $value) {
                GoalAssignmentUserDetail::where([
                    'goal_assignment_id' => $request->goal_assignment_id,
                    'goal_assignment_detail_id' => $detailId,
                    'user_id' => $request->user_id, // employee id
                ])->update([
                            'status' => 'Completed',
                        ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Progress updated successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'progress' => 'required|array',
        ]);
        DB::beginTransaction();

        try {

            foreach ($request->progress as $detailId => $value) {

                GoalAssignmentUserDetail::updateOrCreate(

                    [
                        'goal_assignment_detail_id' => $detailId,
                        'user_id' => auth()->id(),
                    ],

                    [
                        'goal_assignment_id' => $request->goal_assignment_id,
                        'target_achieved' => $value['target_achieved'] ?? 0,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Progress updated successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
    public function goalperformance()
    {
        $userId = Auth::id();

        $assignments = GoalAssignment::with([
            'goal',
            'details.userDetails',
        ])
        ->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->get()
        ->map(function ($assignment) {
            $assignment->avg_weight = round($assignment->details->avg('dimension_weight'), 2);

            return $assignment;
        });   
       return view('admin.goal_dashboard',compact('assignments'));
    }

}
