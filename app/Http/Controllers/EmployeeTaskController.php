<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
use App\Models\Goal;
use App\Models\KeyPerformanceArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class EmployeeTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employeeId = Auth::user()->employee_id;
            $tasks = EmployeeTask::where('employee_id', $employeeId)->latest()->get();

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

                    $editUrl = route('employee-tasks.edit', $row->id);

                    $btn = '
                         <button
                                type="button"
                                class="btn btn-icon view-form-btn"

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
                            >  <i class="icon-base ti tabler-eye"></i>
                            </button>

                        <a href="'.$editUrl.'"
                        class="btn btn-icon">
                             <i class="icon-base ti tabler-pencil"></i>
                        </a>

                        <button
                            class="btn btn-icon deleteBtn"
                            data-id="'.$row->id.'">
                            <i class="icon-base ti tabler-trash"></i>
                        </button>
                    ';

                    return $btn;
                })

                ->rawColumns(['action','status'])

                ->make(true);
        }

        return view('admin.employee_tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $goals = Goal::with('objectives')->get();
        $kpas = KeyPerformanceArea::all();

        return view('admin.employee_tasks.create', compact('goals','kpas'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    try {
        $employeeId = Auth::user()->employee_id;

        $validated = $request->validate([

            'task_date' => 'required|date',
            'task_title' => 'required|string|max:255',
            'task_description' => 'required',

            'planned_type' => 'required|in:planned,unplanned',
            'planned_start_date' => 'required_if:planned_type,planned|nullable|date',
            'planned_end_date' => 'required_if:planned_type,planned|nullable|date',
            

            'actual_start_time' => 'required',

            'actual_end_time' => 'required',

            'hours_worked' => 'required',
            'nature_of_task' => 'required',
            'priority' => 'required',
            'ownership' => 'required',
            'output_deliverables' => 'required',

            'status' => 'required',

            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,jpg,jpeg,png|max:2048',

        ]);

        $attachmentPath = null;

        // FILE UPLOAD

        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            $filename = time().'_'.$file->getClientOriginalName();

            $attachmentPath = $file->storeAs(
                'employee_tasks',
                $filename,
                'public'
            );
        }

        $task = EmployeeTask::create([

            'task_date' => $request->task_date,

            'task_title' => $request->task_title,

            'task_description' => $request->task_description,

            'planned_type' => $request->planned_type,

            'planned_start_date' => $request->planned_start_date,

            'planned_end_date' => $request->planned_end_date,

            'actual_start_time' => $request->actual_start_time,

            'actual_end_time' => $request->actual_end_time,

            'hours_worked' => $request->hours_worked,

            'estimated_hours' => $request->estimated_hours,

            'location' => $request->location,

            'kpa_id' => $request->kpa_id,

            'kpi_id' => $request->kpi_id,

            'goal_id' => $request->goal_id,

            'self_completion' => $request->self_completion,

            'status' => $request->status,

            'output_deliverables' => $request->output_deliverables,

            'employee_id' => $employeeId,

            'nature_of_task' => $request->nature_of_task,

            'priority' => $request->priority,

            'ownership' => $request->ownership,

            'attachment' => $attachmentPath,

            'created_by' => $employeeId,

            'updated_by' => $employeeId,
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Task Added Successfully',

            'data' => $task

        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([

            'success' => false,

            'errors' => $e->errors()

        ], 422);

    } catch (\Exception $e) {

        return response()->json([

            'success' => false,

            'message' => $e->getMessage()

        ], 500);
    }
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
        $employeeId = Auth::user()->employee_id;
        // Optional security check
        if ($employeeTask->employee_id != $employeeId) {
            abort(403, 'Unauthorized access.');
        }
        $goals = Goal::with('objectives')->get();

        $kpas = KeyPerformanceArea::all();

        return view(
            'admin.employee_tasks.edit',
            compact('employeeTask', 'goals', 'kpas')
        );
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeTask $employeeTask)
    {
        try {

            $employeeId = Auth::user()->employee_id;

            $validated = $request->validate([

                'task_date' => 'required|date',

                'task_title' => 'required|string|max:255',

                'task_description' => 'required',

                'planned_type' => 'required|in:planned,unplanned',

                'planned_start_date' => 'required_if:planned_type,planned|nullable|date',

                'planned_end_date' => 'required_if:planned_type,planned|nullable|date',

                'actual_start_time' => 'required',

                'actual_end_time' => 'required',

                'hours_worked' => 'required',

                'nature_of_task' => 'required',

                'priority' => 'required',

                'ownership' => 'required',

                'output_deliverables' => 'required',

                'status' => 'required',

                'attachment' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,jpg,jpeg,png|max:2048',

            ]);

            // FILE UPLOAD

            if ($request->hasFile('attachment')) {

                // DELETE OLD FILE

                if (
                    $employeeTask->attachment &&
                    Storage::disk('public')->exists($employeeTask->attachment)
                ) {

                    Storage::disk('public')
                        ->delete($employeeTask->attachment);
                }


                $file = $request->file('attachment');

                $filename = time().'_'.$file->getClientOriginalName();

                $attachmentPath = $file->storeAs(
                    'employee_tasks',
                    $filename,
                    'public'
                );

                $employeeTask->attachment = $attachmentPath;
            }

            $employeeTask->update([

                'task_date' => $request->task_date,

                'task_title' => $request->task_title,

                'task_description' => $request->task_description,

                'planned_type' => $request->planned_type,

                'planned_start_date' => $request->planned_start_date,

                'planned_end_date' => $request->planned_end_date,

                'actual_start_time' => $request->actual_start_time,

                'actual_end_time' => $request->actual_end_time,

                'hours_worked' => $request->hours_worked,

                'estimated_hours' => $request->estimated_hours,

                'location' => $request->location,

                'kpa_id' => $request->kpa_id,

                'kpi_id' => $request->kpi_id,

                'goal_id' => $request->goal_id,

                'self_completion' => $request->self_completion,

                'status' => $request->status,

                'output_deliverables' => $request->output_deliverables,

                'nature_of_task' => $request->nature_of_task,

                'priority' => $request->priority,

                'ownership' => $request->ownership,

                'updated_by' => $employeeId,
            ]);

            return response()->json([

                'success' => true,

                'message' => 'Task Updated Successfully',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([

                'success' => false,

                'errors' => $e->errors()

            ], 422);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeTask $employeeTask)
    {
        try {
            $employeeId = Auth::user()->employee_id;
             // Security check
            if ($employeeTask->employee_id != $employeeId) {

                return response()->json([

                    'success' => false,

                    'message' => 'Unauthorized access.'

                ], 403);
            }

            // DELETE FILE
            if (
                    $employeeTask->attachment &&
                    Storage::disk('public')->exists($employeeTask->attachment)
                ) {

                    Storage::disk('public')
                        ->delete($employeeTask->attachment);
                }

            $employeeTask->delete();

            return response()->json([

                'success' => true,

                'message' => 'Task Deleted Successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);
        }
    }

}
