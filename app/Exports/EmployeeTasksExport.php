<?php

namespace App\Exports;

use App\Models\EmployeeTask;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeTasksExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;

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
        // FILTERS
        // =========================================

        if ($request->filled('task_title')) {

            $query->where(
                'task_title',
                'like',
                '%' . $request->task_title . '%'
            );
        }

        if (
            $request->filled('start_date') &&
            $request->filled('end_date')
        ) {

            $query->whereBetween('task_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        if ($request->filled('hours_worked')) {

            $query->where(
                'hours_worked',
                $request->hours_worked
            );
        }

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->filled('goal_id')) {

            $query->where(
                'goal_id',
                $request->goal_id
            );
        }

        if ($request->filled('nature_of_task')) {

            $query->where(
                'nature_of_task',
                $request->nature_of_task
            );
        }

        if ($request->filled('priority')) {

            $query->where(
                'priority',
                $request->priority
            );
        }

        if ($request->filled('planned_type')) {

            $query->where(
                'planned_type',
                $request->planned_type
            );
        }

        if ($request->filled('task_status')) {

            $query->where(
                'task_status',
                $request->task_status
            );
        }

        if ($request->filled('employee_name')) {

            $query->whereHas('employee', function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->employee_name . '%'
                );
            });
        }

        if ($request->filled('kpa_id')) {

            $query->where(
                'kpa_id',
                $request->kpa_id
            );
        }

        // =========================================
        // EXPORT DATA
        // =========================================

        return $query->latest()->get()->map(function ($task) {

            return [

                'Employee Name' =>
                    $task->employee->name ?? 'N/A',

                'Faculty' =>
                    $task->employee->facultyyy->name ?? 'N/A',

                'Department' =>
                    $task->employee->departmentttt->name ?? 'N/A',

                'Task Title' =>
                    $task->task_title,

                'Task Description' =>
                    $task->task_description,

                'Task Date' =>
                    $task->task_date,

                'Hours Worked' =>
                    $task->hours_worked,

                'Estimated Hours' =>
                    $task->estimated_hours,

                'Task Status' =>
                    $task->status,

                'Approval Status' =>
                    $task->task_status == 2
                        ? 'Approved'
                        : ($task->task_status == 3
                            ? 'Rejected'
                            : 'Pending'),

                'Priority' =>
                    $task->priority,

                'Nature Of Task' =>
                    $task->nature_of_task,

                'Planned Type' =>
                    $task->planned_type,

                'KPA' =>
                    $task->kpa->performance_area ?? 'N/A',

                'KPI' =>
                    $task->kpi->indicator_category ?? 'N/A',

                'Indicator' =>
                    $task->indicator->indicator ?? 'N/A',

                'Goal' =>
                    $task->goal->goal_name ?? 'N/A',

                'Location' =>
                    $task->location,

                'Ownership' =>
                    $task->ownership,

                'Deliverables' =>
                    $task->output_deliverables,
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Employee Name',
            'Faculty',
            'Department',
            'Task Title',
            'Task Description',
            'Task Date',
            'Hours Worked',
            'Estimated Hours',
            'Task Status',
            'Approval Status',
            'Priority',
            'Nature Of Task',
            'Planned Type',
            'KPA',
            'KPI',
            'Indicator',
            'Goal',
            'Location',
            'Ownership',
            'Deliverables'
        ];
    }
}
