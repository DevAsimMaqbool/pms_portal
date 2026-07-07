@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

        <h4>
            Enterprise Task Management &
            Performance Monitoring System
        </h4>

        <a href="{{ route('employee.tasks.export', request()->query()) }}"
        class="btn btn-success">

            Export Excel

        </a>

    </div>

        <div class="card-body">

            <!-- FILTER FORM -->

            <form method="GET"
                  action="{{ route('alltask.get') }}">

                <div class="row mb-4">

                    <div class="col-md-3">
                       <label class="form-label">Task Title</label>
                        <input type="text"
                               name="task_title"
                               class="form-control"
                               placeholder="Task Title"
                               value="{{ request('task_title') }}">
                    </div>
                    <div class="col-md-2">

                        <label class="form-label">
                            Start Date
                        </label>

                        <input type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ request('start_date') }}">

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">
                            End Date
                        </label>

                        <input type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ request('end_date') }}">

                    </div>

                    <div class="col-md-2">
                    <label class="form-label">Hours Worked</label>
                        <input type="number"
                               name="hours_worked"
                               class="form-control"
                               placeholder="Hours Worked"
                               value="{{ request('hours_worked') }}">
                    </div>

                    <div class="col-md-3">
                     <label class="form-label">Status</label>
                        <select name="status"
                                class="form-select">

                            <option value="">
                                Select Status
                            </option>

                            <option value="Planned"
                                {{ request('status') == 'Planned' ? 'selected' : '' }}>
                                Planned
                            </option>

                            <option value="In Progress"
                                {{ request('status') == 'In Progress' ? 'selected' : '' }}>
                                In Progress
                            </option>

                            <option value="Completed"
                                {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                            <option value="Pending Verification"
                                {{ request('status') == 'Pending Verification' ? 'selected' : '' }}>
                                Pending Verification
                            </option>
                            <option value="Rejected"
                                {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                        </select>
                    </div>


                     <div class="col-md-3">
                        <label class="form-label">Goals</label>
                        <select id="goal_id" class="form-select" name="goal_id">
                         <option value="">
                                Select Goals
                            </option>
                            @foreach($goals as $goal)
                                <option value="{{ $goal->id }}">{{ $goal->goal_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="nature_of_task" class="form-label">Nature of Task</label>
                        <select name="nature_of_task" class="select2 form-select nature_of_task">
                            <option value="">-- Select Nature of Task --</option>
                            <option value="Strategic">Strategic</option>
                            <option value="Managerial">Managerial</option>
                            <option value="Operational">Operational</option>
                            <option value="Project-Based">Project-Based</option>
                            <option value="Compliance">Compliance</option>
                            <option value="Analytical">Analytical</option>
                            <option value="Communication">Communication</option>
                            <option value="Service Delivery">Service Delivery</option>
                            <option value="Improvement & Innovation">Improvement & Innovation</option>
                            <option value="Monitoring & Control">Learning & Development</option>
                            <option value="Administrative">Administrative</option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" class="form-select priority"
                            >
                            <option value="">-- Select Priority --</option>
                            <option value="Critical">Critical</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="sector" class="form-label">Planned / Unplanned </label>
                        <select name="planned_type" id="planned_type" class="form-select"
                            >
                            <option value="">Select</option>
                                <option value="planned">Planned</option>
                            <option value="unplanned">Unplanned</option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="task_status" class="form-label">A/UP/P Status</label>
                        <select name="task_status" class="form-select task_status"
                            >
                            <option value="">-- Select --</option>
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Rejected</option>

                        </select>
                    </div>
                    <div class="col-md-3">
                       <label class="form-label">Employee Name</label>
                        <input type="text"
                               name="employee_name"
                               class="form-control"
                               placeholder="Employee Name"
                               value="{{ request('employee_name') }}">
                    </div>
                     <div class="col-md-3">
                        <label class="form-label">Select KPA</label>
                        <select id="kpa_id" name="kpa_id" class="select2 form-select">
                            <option value="">Select KPA</option>
                            @foreach($kpas as $kpa)
                                <option value="{{ $kpa->id }}">{{ $kpa->performance_area }}</option>
                            @endforeach
                        </select>
                    </div>  


                    
                    <div class="col-md-1 col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>

                </div>

            </form>


            <!-- TABLE -->

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Task Title</th>
                            <th>A/UP/P Status</th>
                            <th>Date</th>
                            <th>Hours Worked</th>
                            <th>Task Status</th>
                            <th>KPA</th>
                            <th width="120">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($tasks as $task)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $task->employee->name ?? 'N/A' }}</td>
                                <td>
                                    {{ $task->task_title }}
                                </td>

                                <td>

                                    @if($task->task_status == 2)

                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($task->task_status == 3)

                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-warning">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $task->task_date }}
                                </td>

                                <td>
                                    {{ $task->hours_worked }}
                                </td>
                                <td>
                                    {{ $task->status }}
                                </td>
                                <td> {{ $task->kpa->performance_area ?? 'N/A' }} </td>

                                <td>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary view-form-btn"

                                        data-id="{{ $task->id }}"
                                        data-title="{{ $task->task_title }}"
                                        data-username="{{ $task->employee->name }}"
                                        data-description="{{ $task->task_description }}"
                                        data-date="{{ $task->task_date }}"
                                        data-priority="{{ $task->priority }}"
                                        data-location="{{ $task->location }}"
                                        data-status="{{ $task->status }}"
                                        data-ownership="{{ $task->ownership }}"
                                        data-task_nature="{{ $task->nature_of_task }}"
                                        data-hours="{{ $task->hours_worked }}"
                                        data-estimated="{{ $task->estimated_hours }}"
                                        data-deliverables="{{ $task->output_deliverables }}"
                                        data-manager_completion="{{ $task->manager_completion }}"
                                        data-kpa="{{ $task->kpa->performance_area }}"
                                        data-kpi="{{ $task->kpi->indicator_category }}"
                                        data-indicator="{{ $task->indicator->indicator }}"
                                        data-goal="{{ $task->goal?->goal_name }}"
                                        data-faculty="{{ $task->employee->facultyyy->name }}"
                                        data-department="{{ $task->employee->departmentttt->name }}"
                                        data-updatehistory='@json(json_decode($task->update_history, true))'

                                        data-bs-toggle="modal"
                                        data-bs-target="#viewFormModal"
                                    >

                                        View

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center">

                                    No Data Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- PAGINATION -->

            <div class="mt-3">

                {{ $tasks->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="viewFormModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Task Details</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="task_id">

                    <table class="table table-bordered">
                        <tr>
                            <th>Username</th>
                            <td id="username"></td>
                        </tr>
                        <tr>
                            <th>Task Title</th>
                            <td id="task_title"></td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td id="task_description"></td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td id="task_date"></td>
                        </tr>

                        <tr>
                            <th>Status Planned / Unplanned</th>
                            <td id="task_status"></td>
                        </tr>

                        <tr>
                            <th>Location</th>
                            <td id="task_location"></td>
                        </tr>

                        <tr>
                            <th>Hours Worked</th>
                            <td id="task_hours"></td>
                        </tr>

                        <tr>
                            <th>Estimated Hours</th>
                            <td id="task_estimated"></td>
                        </tr>
                         <tr>
                            <th>Faculty</th>
                            <td id="faculty"></td>
                        </tr>
                         <tr>
                            <th>department</th>
                            <td id="department"></td>
                        </tr>
                        <tr>
                            <th>KPA</th>
                            <td id="kpa"></td>
                        </tr>
                        <tr>
                            <th>indicator Category"</th>
                            <td id="kpi"></td>
                        </tr>
                        <tr>
                            <th>INDICATOR</th>
                            <td id="indicator"></td>
                        </tr>
                        <tr>
                            <th>Goal</th>
                            <td id="goal"></td>
                        </tr>
                        <tr>
                            <th>Nature of Task</th>
                            <td id="task_nature"></td>
                        </tr>
                        <tr>
                            <th>Ownership</th>
                            <td id="task_ownership"></td>
                        </tr>
                        <tr>
                            <th>Priority</th>
                            <td id="task_priority"></td>
                        </tr>
                         <tr>
                            <th>Deliverables</th>
                            <td id="task_deliverables"></td>
                        </tr>

                    </table>
                    <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center"><i
                                    class="icon-base ti tabler-history me-3"></i>History</h5>
                            <ul class="timeline mb-0" id="modalExtraFieldsHistory">
                            </ul>


                </div>

            </div>
        </div>
    </div>
<!-- end Modal -->
</div>

@endsection
@push('script')
<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

<script>
$(document).on('click', '.view-form-btn', function () {

    $('input[name="task_action"]').prop('checked', false);

    $('#task_id').val($(this).data('id'));

    $('#task_title').text($(this).data('title'));
    $('#task_description').text($(this).data('description'));
    $('#task_date').text($(this).data('date'));
    $('#task_status').text($(this).data('status'));
    $('#task_priority').text($(this).data('priority'));
    $('#task_location').text($(this).data('location'));
    $('#task_hours').text($(this).data('hours'));
    $('#task_estimated').text($(this).data('estimated'));
    $('#task_deliverables').text($(this).data('deliverables'));
    $('#kpa').text($(this).data('kpa'));
    $('#kpi').text($(this).data('kpi'));
    $('#indicator').text($(this).data('indicator'));
    $('#goal').text($(this).data('goal'));
    $('#username').text($(this).data('username'));
    $('#faculty').text($(this).data('faculty'));
    $('#department').text($(this).data('department'));
    

    $('#task_ownership').text($(this).data('ownership'));
    $('#task_nature').text($(this).data('task_nature'));
    let taskStatus = $(this).data('taskstatus');
    // Approved 
    if (taskStatus == 2) { $('input[name="task_action"][value="approve"]') .prop('checked', true); } 
    // Rejected
     else if (taskStatus == 3) { $('input[name="task_action"][value="reject"]') .prop('checked', true); }
    
let historys = $(this).attr('data-updatehistory');

$('#modalExtraFieldsHistory').find('.optional-field').remove();

if (historys && historys !== 'null') {

    try {

        // PARSE ONLY ONE TIME
        let history = JSON.parse(historys);

        if (Array.isArray(history) && history.length > 0) {

            let historyHtml = '';

            history.forEach(update => {

                let remarksBadge = '';
                let statusClass = 'bg-secondary';

                if (update.status === 'approve') {

                    statusClass = 'bg-success';

                } else if (update.status === 'reject') {

                    statusClass = 'bg-danger';
                }

                if (update.remarks) {

                    remarksBadge = `
                        <div class="d-flex align-items-center mb-1">
                            <p class="mb-2">
                                Remarks: ${update.remarks}
                            </p>
                        </div>
                    `;
                }

                historyHtml += `
                    <li class="timeline-item timeline-item-transparent optional-field">

                        <span class="timeline-point timeline-point-primary"></span>

                        <div class="timeline-event">

                            <div class="timeline-header mb-2">

                                <h6 class="mb-0">
                                    ${update.user_name ?? 'N/A'}
                                </h6>

                                <small class="text-body-secondary">
                                    ${new Date(update.updated_at).toLocaleString()}
                                </small>

                            </div>

                            <div class="d-flex align-items-center mb-2">

                                <div class="badge bg-primary rounded-3">
                                    ${update.role ?? 'N/A'}
                                </div>

                                <div class="badge ${statusClass} rounded-3 ms-2">
                                    ${update.status ?? 'N/A'}
                                </div>

                            </div>

                            ${remarksBadge}

                        </div>

                    </li>
                `;
            });

            $('#modalExtraFieldsHistory').html(historyHtml);

        } else {

            $('#modalExtraFieldsHistory').html(`
                <li class="optional-field">
                    No History Available
                </li>
            `);
        }

    } catch (e) {

        console.log(e);

        $('#modalExtraFieldsHistory').html(`
            <li class="optional-field text-danger">
                Invalid History Data
            </li>
        `);
    }

} else {

    $('#modalExtraFieldsHistory').html(`
        <li class="optional-field">
            No History Available
        </li>
    `);
}


});

</script>

@endpush