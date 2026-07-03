<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ManagerTaskController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $employeeId = Auth::user()->employee_id;

            $allmanageremploy = User::where('manager_id', $employeeId)
                ->pluck('employee_id')
                ->toArray();

            $tasks = EmployeeTask::whereIn('employee_id', $allmanageremploy)
                ->latest()
                ->get();


                return DataTables::of($tasks)

                    ->addIndexColumn()

                    ->editColumn('status', function ($row) {

                        if ($row->task_status == '2') {

                            return '<span class="badge bg-success">Approved</span>';

                        } elseif ($row->task_status == '3') {

                            return '<span class="badge bg-danger">Rejected</span>';

                        } else {

                            return '<span class="badge bg-warning">Pending</span>';
                        }
                    })

                    ->addColumn('action', function ($row) {

                        return '
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-sm view-form-btn"

                                data-id="'.$row->id.'"
                                data-title="'.$row->task_title.'"
                                data-description="'.$row->task_description.'"
                                data-date="'.$row->task_date.'"
                                data-status="'.$row->status.'"
                                data-priority="'.$row->priority.'"
                                data-location="'.$row->location.'"
                                data-hours="'.$row->hours_worked.'"
                                data-estimated="'.$row->estimated_hours.'"
                                data-deliverables="'.$row->output_deliverables.'"
                                data-taskstatus="'.$row->task_status.'"
                                data-updatehistory="'.htmlspecialchars($row->update_history, ENT_QUOTES, 'UTF-8').'"
                                data-manager_completion="'.$row->manager_completion.'"

                                data-bs-toggle="modal"
                                data-bs-target="#viewFormModal"
                            >
                                View
                            </button>
                        ';
                    })

                    ->rawColumns(['action', 'status'])

                    ->make(true);

        }

        return view('admin.employee_tasks.manager');
    }



    public function update(Request $request, $id)
    {
        $task = EmployeeTask::findOrFail($id);

        $request->validate([
            'action_type' => 'required|in:approve,reject',
            'self_completion' => 'required|numeric|min:0|max:100',
            'reject_remarks' => 'nullable|string|max:500'
        ]);
        $currentUserId = Auth::id();
        $currentUserName = Auth::user()->name;
        $userRoll = getRoleName(activeRole()) ?? 'N/A';
        // Get current update history
        $history = $task->update_history ? json_decode($task->update_history, true) : [];
        // Avoid duplicate consecutive updates by the same user with the same status
        $lastUpdate = end($history);
        if (!$lastUpdate || $lastUpdate['user_id'] != $currentUserId || $lastUpdate['status'] != $request->action_type) {
            $history[] = [
                'user_id'    => $currentUserId,
                'user_name'  => $currentUserName,
                'status'     => $request->action_type,
                'role'     => $userRoll,
                'remarks'     => $request->reject_remarks,
                'manager_completion' => $request->self_completion,
                'updated_at' => now()->toDateTimeString(),
            ];
        }

        if ($request->action_type == 'approve') {

            $task->update([
                'task_status' => '2',
                'reject_status' => '0',
                'reject_status_remarks' => null,
                'manager_completion' => $request->self_completion,
                'update_history' => json_encode($history),
                'updated_by' => Auth::id()
            ]);

        } else {

            if (!$request->reject_remarks) {

                return response()->json([
                    'status' => false,
                    'message' => 'Remarks required'
                ], 422);
            }

            $task->update([
                'task_status' => '3',
                'reject_status' => '1',
                'reject_status_remarks' => $request->reject_remarks,
                'manager_completion' => $request->self_completion,
                'update_history' => json_encode($history),
                'updated_by' => Auth::id()
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Task status updated successfully'
        ]);
    }
public function allEmployeeTasks(Request $request)
{
    $query = EmployeeTask::with([
        'employee',
        'employee.facultyyy',
        'employee.departmentttt',
        'kpa',
        'kpi',
        'indicator',
        'goal'
    ]);

    // =========================================
    // FILTER BY TASK TITLE
    // =========================================

    if ($request->filled('task_title')) {

        $query->when( $request->filled('task_title'), fn ($q) => $q->where('task_title','like', '%' . $request->task_title . '%') );
    }

    // =========================================
    // FILTER BY DATE
    // =========================================

    if ($request->filled('task_date')) {

         $query->when( $request->filled('task_date'), fn ($q) => $q->where( 'task_date', $request->task_date ) );
    }

    // =========================================
    // FILTER BY HOURS WORKED
    // =========================================

    if ($request->filled('hours_worked')) {

        $query->when( $request->filled('hours_worked'), fn ($q) => $q->where( 'hours_worked', $request->hours_worked ) );
    }

    // =========================================
    // FILTER BY TASK STATUS
    // =========================================

    if ($request->filled('status')) {

        $query->when( $request->filled('status'), fn ($q) => $q->where( 'status', $request->status ) );
    }
    // =====================================================
    // GOAL FILTER 
    // =====================================================
     if ($request->filled('goal_id')) {
         $query->when( $request->filled('goal_id'), fn ($q) => $q->where( 'goal_id', $request->goal_id ) );
    }

    // =====================================================
    // NATURE OF TASK FILTER 
    // =====================================================
    if ($request->filled('nature_of_task')) { 
        $query->when( $request->filled('nature_of_task'), fn ($q) => $q->where( 'nature_of_task', $request->nature_of_task ) );
    }

    // =====================================================
    // PRIORITY FILTER 
    // ===================================================== 
    if ($request->filled('priority')) {
         $query->when( $request->filled('priority'), fn ($q) => $q->where( 'priority', $request->priority ) );
    }

    // ===================================================== 
    // PLANNED / UNPLANNED FILTER 
    // =====================================================
    if ($request->filled('planned_type')) {
          $query->when( $request->filled('planned_type'), fn ($q) => $q->where( 'planned_type', $request->planned_type ) );
    }

    // =====================================================
     // TASK STATUS FILTER 
     // =====================================================
      if ($request->filled('task_status')) {
         $query->when( $request->filled('task_status'), fn ($q) => $q->where( 'task_status', $request->task_status ) );
     }


    // =========================================
    // PAGINATION
    // =========================================

    $tasks = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();
    $goals = Goal::with('objectives')->get();    

    return view(
        'admin.employee_tasks.alldata',
        compact('tasks','goals')
    );
}


}
