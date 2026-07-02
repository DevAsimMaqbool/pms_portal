<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
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
                'self_completion' => $request->self_completion,
                'updated_at' => now()->toDateTimeString(),
            ];
        }

        if ($request->action_type == 'approve') {

            $task->update([
                'task_status' => '2',
                'reject_status' => '0',
                'reject_status_remarks' => null,
                'self_completion' => $request->self_completion,
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
                'self_completion' => $request->self_completion,
                'update_history' => json_encode($history),
                'updated_by' => Auth::id()
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Task status updated successfully'
        ]);
    }

}
