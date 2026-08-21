@extends('layouts.app')

@section('title', 'Daily Task Tracker')

@section('content')

<div class="container-fluid">

    <!-- ============================================
        PAGE HEADER
    ============================================= -->

    <div class="row mb-4">

        <div class="col-md-6">

            <h3 class="fw-bold mb-1">

                <i class="ti ti-calendar-stats text-primary"></i>

                Daily Task Tracker

            </h3>

            <p class="text-muted mb-0">

                Track your daily work against this task.

            </p>

        </div>

        <div class="col-md-6 text-end">

            <a href="#" class="btn btn-light">

                <i class="ti ti-arrow-left"></i>

                Back

            </a>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dailyLogModal">

                <i class="ti ti-plus"></i>

                Add Daily Log

            </button>

            <a href="{{ route('daily-tracker.timeline', $task->id) }}" class="btn btn-dark">

                <i class="ti ti-timeline"></i>

                Timeline

            </a>

        </div>

    </div>

    <!-- ============================================
        BREADCRUMB
    ============================================= -->

    <nav>

        <ol class="breadcrumb">

            <li class="breadcrumb-item">

                <a href="{{ url('/dashboard') }}">

                    Dashboard

                </a>

            </li>

            <li class="breadcrumb-item">

                <a href="#">

                    Employee Tasks

                </a>

            </li>

            <li class="breadcrumb-item active">

                Daily Tracker

            </li>

        </ol>

    </nav>

    <!-- ============================================
        MASTER TASK CARD
    ============================================= -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between">

                <div>

                    <h5 class="mb-1">

                        {{ $task->task_title }}

                    </h5>

                    <small>

                        {{ $task->task_description }}

                    </small>

                </div>

                <div>

                    @if($task->status == "Completed")

                        <span class="badge bg-success">

                            Completed

                        </span>

                    @elseif($task->status == "In Progress")

                        <span class="badge bg-warning text-dark">

                            In Progress

                        </span>

                    @else

                        <span class="badge bg-secondary">

                            Pending

                        </span>

                    @endif

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>

                            <th width="180">

                                KPA

                            </th>

                            <td>

                                {{ optional($task->kpa)->title }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                KPI

                            </th>

                            <td>

                                {{ optional($task->kpi)->title }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Priority

                            </th>

                            <td>

                                <span class="badge bg-danger">

                                    {{ $task->priority }}

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Ownership

                            </th>

                            <td>

                                {{ $task->ownership }}

                            </td>

                        </tr>

                    </table>

                </div>

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>

                            <th width="180">

                                Planned Start

                            </th>

                            <td>

                                {{ $task->planned_start_date }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Planned End

                            </th>

                            <td>

                                {{ $task->planned_end_date }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Estimated Hours

                            </th>

                            <td>

                                {{ number_format($task->estimated_hours, 2) }}

                            </td>

                        </tr>

                        <tr>

                            <th>

                                Created

                            </th>

                            <td>

                                {{ $task->created_at->format('d M Y') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- ============================================
        SUMMARY CARDS
    ============================================= -->

    <div class="row mb-4">

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Estimated Hours

                    </small>

                    <h2 class="mt-2 mb-0">

                        {{ number_format($task->estimated_hours, 2) }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Logged Hours

                    </small>

                    <h2 class="mt-2 mb-0 text-primary">

                        {{ number_format($task->logged_hours, 2) }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Remaining Hours

                    </small>

                    <h2 class="mt-2 mb-0 text-danger">

                        {{ number_format($task->remaining_hours, 2) }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">

                        Completion

                    </small>

                    <h2 class="mt-2">

                        {{ $task->self_completion }}%

                    </h2>

                    <div class="progress mt-3" style="height:10px;">

                        <div class="progress-bar bg-success" style="width: {{ $task->self_completion }}%">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ============================================
        DAILY LOGS SECTION
        (Part 2 starts here)
    ============================================= -->

    <div class="card shadow-sm">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="ti ti-list-details"></i>

                    Daily Work Logs

                </h5>

            </div>

        </div>

        <div class="card-body">
            <div class="row mb-3">

    <div class="col-md-4">

        <input type="text"
               id="search"
               class="form-control"
               placeholder="Search work done...">

    </div>

    <div class="col-md-3">

        <select
            class="form-select"
            id="status_filter">

            <option value="">

                All Status

            </option>

            <option value="Pending">

                Pending

            </option>

            <option value="Approved">

                Approved

            </option>

            <option value="Rejected">

                Rejected

            </option>

            <option value="Revision">

                Revision

            </option>

        </select>

    </div>

    <div class="col-md-5 text-end">

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#dailyLogModal">

            <i class="ti ti-plus"></i>

            Add Daily Log

        </button>

        <a href="{{ route('daily-tracker.timeline',$task->id) }}"
           class="btn btn-dark">

            <i class="ti ti-timeline"></i>

            Timeline

        </a>

        <button
            class="btn btn-success"
            id="reloadTable">

            <i class="ti ti-refresh"></i>

            Refresh

        </button>

    </div>

</div>

<div class="table-responsive">

<table
class="table table-bordered table-hover align-middle"
id="dailyLogsTable">

    <thead class="table-light">

        <tr>

            <th width="60">

                #

            </th>

            <th>

                Date

            </th>

            <th>

                Start

            </th>

            <th>

                End

            </th>

            <th>

                Hours

            </th>

            <th width="180">

                Today's Progress

            </th>

            <th>

                Work Done

            </th>

            <th>

                Manager Status

            </th>

            <th width="170">

                Action

            </th>

        </tr>

    </thead>

    <tbody>

        @forelse($task->logs as $key=>$log)

        <tr>

            <td>

                {{ $key+1 }}

            </td>

            <td>

                {{ \Carbon\Carbon::parse($log->work_date)->format('d M Y') }}

            </td>

            <td>

                {{ $log->start_time }}

            </td>

            <td>

                {{ $log->end_time }}

            </td>

            <td>

                {{ number_format($log->hours_worked,2) }}

            </td>

            <td>

                <div class="progress"
                     style="height:18px">

                    <div
                        class="progress-bar bg-success"

                        style="width:{{ $log->progress_today }}%">

                        {{ $log->progress_today }}%

                    </div>

                </div>

            </td>

            <td>

                {{ Str::limit($log->work_done,80) }}

            </td>

            <td>

                @switch($log->manager_status)

                    @case('Approved')

                        <span class="badge bg-success">

                            Approved

                        </span>

                        @break

                    @case('Rejected')

                        <span class="badge bg-danger">

                            Rejected

                        </span>

                        @break

                    @case('Revision')

                        <span class="badge bg-warning">

                            Revision

                        </span>

                        @break

                    @default

                        <span class="badge bg-secondary">

                            Pending

                        </span>

                @endswitch

            </td>

            <td>

                <button

                    class="btn btn-sm btn-info viewLog"

                    data-id="{{ $log->id }}">

                    <i class="ti ti-eye"></i>

                </button>

                @if($log->manager_status!='Approved')

                <button

                    class="btn btn-sm btn-primary editLog"

                    data-id="{{ $log->id }}">

                    <i class="ti ti-pencil"></i>

                </button>

                <button

                    class="btn btn-sm btn-danger deleteLog"

                    data-id="{{ $log->id }}">

                    <i class="ti ti-trash"></i>

                </button>

                @endif

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="9"
                class="text-center text-muted">

                No Daily Logs Found

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

</div>

</div>
<!-- ===========================================================
    ADD DAILY LOG MODAL
============================================================ -->

<div class="modal fade"
     id="dailyLogModal"
     tabindex="-1"
     aria-labelledby="dailyLogModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <!-- =======================================
                FORM START
            ======================================== -->

            <form id="dailyLogForm"
                  enctype="multipart/form-data">

                @csrf

                <!-- Master Task -->

                <input
                    type="hidden"
                    name="employee_task_id"
                    value="{{ $task->id }}">

                <!-- Remaining Progress -->

                <input
                    type="hidden"
                    id="remaining_progress"
                    value="{{ 100-$task->self_completion }}">

                <!-- Remaining Hours -->

                <input
                    type="hidden"
                    id="remaining_hours"
                    value="{{ $task->remaining_hours }}">

                <!-- =======================================
                    MODAL HEADER
                ======================================== -->

                <div class="modal-header bg-primary text-white">

                    <div>

                        <h4
                            class="modal-title"
                            id="dailyLogModalLabel">

                            <i class="ti ti-calendar-plus"></i>

                            Add Daily Work

                        </h4>

                        <small>

                            {{ $task->task_title }}

                        </small>

                    </div>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">

                    </button>

                </div>

                <!-- =======================================
                    MODAL BODY
                ======================================== -->

                <div class="modal-body">

                    <!-- Summary -->

                    <div class="alert alert-info mb-4">

                        <div class="row">

                            <div class="col-md-3">

                                <strong>

                                    Estimated Hours

                                </strong>

                                <br>

                                {{ number_format($task->estimated_hours,2) }}

                            </div>

                            <div class="col-md-3">

                                <strong>

                                    Logged Hours

                                </strong>

                                <br>

                                {{ number_format($task->logged_hours,2) }}

                            </div>

                            <div class="col-md-3">

                                <strong>

                                    Remaining Hours

                                </strong>

                                <br>

                                <span id="remainingHoursText">

                                    {{ number_format($task->remaining_hours,2) }}

                                </span>

                            </div>

                            <div class="col-md-3">

                                <strong>

                                    Remaining Progress

                                </strong>

                                <br>

                                <span
                                    class="badge bg-danger fs-6"
                                    id="remainingProgressText">

                                    {{ 100-$task->self_completion }}%

                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- ===================================================
                        FORM FIELDS START HERE
                        (Part 2)
                    ==================================================== -->

                    <div class="row">
                        <!-- ============================================
    WORK DATE
============================================= -->

<div class="col-md-4 mb-3">

    <label class="form-label fw-semibold">

        Today's Work Date
        <span class="text-danger">*</span>

    </label>

    <input
        type="date"
        class="form-control"
        id="work_date"
        name="work_date"
        value="{{ date('Y-m-d') }}"
        max="{{ date('Y-m-d') }}">

    <small
        class="text-danger validation-error"
        data-field="work_date">
    </small>

</div>

<!-- ============================================
    START TIME
============================================= -->

<div class="col-md-4 mb-3">

    <label class="form-label fw-semibold">

        Start Time
        <span class="text-danger">*</span>

    </label>

    <input
        type="datetime-local"
        class="form-control"
        id="start_time"
        name="start_time">

    <small
        class="text-danger validation-error"
        data-field="start_time">
    </small>

</div>

<!-- ============================================
    END TIME
============================================= -->

<div class="col-md-4 mb-3">

    <label class="form-label fw-semibold">

        End Time
        <span class="text-danger">*</span>

    </label>

    <input
        type="datetime-local"
        class="form-control"
        id="end_time"
        name="end_time">

    <small
        class="text-danger validation-error"
        data-field="end_time">
    </small>

</div>

<!-- ============================================
    HOURS WORKED
============================================= -->

<div class="col-md-4 mb-3">

    <label class="form-label fw-semibold">

        Hours Worked

    </label>

    <input
        type="text"
        class="form-control bg-light"
        id="hours_worked"
        name="hours_worked"
        value="0.00"
        readonly>

    <small class="text-muted">

        Automatically calculated

    </small>

</div>

<!-- ============================================
    TODAY'S PROGRESS
============================================= -->

<div class="col-md-4 mb-3">

    <label class="form-label fw-semibold">

        Today's Progress (%)
        <span class="text-danger">*</span>

    </label>

    <input
        type="number"
        class="form-control"
        id="progress_today"
        name="progress_today"
        min="1"
        max="{{ 100-$task->self_completion }}"
        placeholder="Enter progress">

    <small
        class="text-danger validation-error"
        data-field="progress_today">
    </small>

</div>

<!-- ============================================
    REMAINING PROGRESS
============================================= -->

<div class="col-md-4 mb-3">

    <label class="form-label fw-semibold">

        Remaining Progress

    </label>

    <div class="border rounded p-3 bg-light">

        <div class="d-flex justify-content-between">

            <span>

                Available

            </span>

            <strong
                class="text-primary"
                id="availableProgress">

                {{ 100-$task->self_completion }}%

            </strong>

        </div>

        <hr class="my-2">

        <div class="d-flex justify-content-between">

            <span>

                After Entry

            </span>

            <strong
                class="text-success"
                id="remainingAfterEntry">

                {{ 100-$task->self_completion }}%

            </strong>

        </div>

    </div>

</div>
<!-- ============================================
    WORK DONE
============================================= -->

<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">

        Work Done
        <span class="text-danger">*</span>

    </label>

    <textarea
        class="form-control"
        id="work_done"
        name="work_done"
        rows="5"
        placeholder="Describe today's completed work in detail..."></textarea>

    <small
        class="text-danger validation-error"
        data-field="work_done">
    </small>

</div>

<!-- ============================================
    BLOCKERS
============================================= -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Blockers / Issues

    </label>

    <textarea
        class="form-control"
        id="blockers"
        name="blockers"
        rows="4"
        placeholder="Mention any issues, dependencies or blockers..."></textarea>

    <small
        class="text-danger validation-error"
        data-field="blockers">
    </small>

</div>

<!-- ============================================
    TOMORROW PLAN
============================================= -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Tomorrow Plan

    </label>

    <textarea
        class="form-control"
        id="tomorrow_plan"
        name="tomorrow_plan"
        rows="4"
        placeholder="What will you work on tomorrow?"></textarea>

    <small
        class="text-danger validation-error"
        data-field="tomorrow_plan">
    </small>

</div>

<!-- ============================================
    ATTACHMENT
============================================= -->

<div class="col-md-12 mb-4">

    <label class="form-label fw-semibold">

        Attachment

    </label>

    <input
        type="file"
        class="form-control"
        id="attachment"
        name="attachment"
        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">

    <small class="text-muted">

        Allowed:
        PDF,
        DOC,
        DOCX,
        XLS,
        XLSX,
        JPG,
        JPEG,
        PNG
        (Max 5 MB)

    </small>

    <br>

    <small
        class="text-danger validation-error"
        data-field="attachment">
    </small>

</div>

</div>

<!-- ============================================
    MODAL FOOTER
============================================= -->

<div class="modal-footer">

    <button
        type="button"
        class="btn btn-secondary"
        data-bs-dismiss="modal">

        <i class="ti ti-x"></i>

        Cancel

    </button>

    <button
        type="submit"
        id="saveDailyLogBtn"
        class="btn btn-primary">

        <span
            class="spinner-border spinner-border-sm d-none"
            id="saveSpinner">
        </span>

        <i class="ti ti-device-floppy"></i>

        Save Daily Log

    </button>

</div>

</form>

</div>

</div>

</div>
@push('script')
<script>

$(function () {

    //--------------------------------------------------
    // Cached Elements
    //--------------------------------------------------

    const startInput = $('#start_time');
    const endInput = $('#end_time');
    const hoursWorked = $('#hours_worked');

    const progressInput = $('#progress_today');

    const availableProgress = $('#availableProgress');
    const remainingAfter = $('#remainingAfterEntry');

    const remainingProgress = parseFloat($('#remaining_progress').val()) || 0;

    //--------------------------------------------------
    // Calculate Hours
    //--------------------------------------------------

    function calculateWorkingHours()
    {

        let start = startInput.val();
        let end = endInput.val();

        if(start=='' || end=='')
        {
            hoursWorked.val('0.00');
            return;
        }

        let startDate = new Date(start);
        let endDate = new Date(end);

        if(endDate<=startDate)
        {
            hoursWorked.val('0.00');
            return;
        }

        let totalHours = calculateBusinessHours(startDate,endDate);

        hoursWorked.val(totalHours.toFixed(2));

    }

    //--------------------------------------------------
    // Business Hours Rule
    // Maximum 8 Hours Per Day
    //--------------------------------------------------

    function calculateBusinessHours(start,end)
    {

        let total=0;

        let current=new Date(start);

        while(current.toDateString()!=end.toDateString())
        {

            total += 8;

            current.setDate(current.getDate()+1);

            current.setHours(0,0,0,0);

        }

        let sameDayHours=(end-current)/(1000*60*60);

        if(sameDayHours>8)
        {
            sameDayHours=8;
        }

        if(sameDayHours<0)
        {
            sameDayHours=0;
        }

        total += sameDayHours;

        return total;

    }

    //--------------------------------------------------
    // Calculate Remaining Progress
    //--------------------------------------------------

    function updateProgress()
    {

        let today=parseFloat(progressInput.val());

        if(isNaN(today))
        {
            today=0;
        }

        if(today>remainingProgress)
        {

            Swal.fire({

                icon:'warning',

                title:'Maximum Progress',

                text:'Only '+remainingProgress+'% progress is remaining.'

            });

            progressInput.val(remainingProgress);

            today=remainingProgress;

        }

        let remaining=remainingProgress-today;

        if(remaining<0)
        {
            remaining=0;
        }

        availableProgress.text(remainingProgress+'%');

        remainingAfter.text(remaining+'%');

    }

    //--------------------------------------------------
    // Events
    //--------------------------------------------------

    startInput.on('change',function(){

        calculateWorkingHours();

    });

    endInput.on('change',function(){

        calculateWorkingHours();

    });

    progressInput.on('keyup change',function(){

        updateProgress();

    });

    //--------------------------------------------------
    // Initial Load
    //--------------------------------------------------

    calculateWorkingHours();

    updateProgress();

});

$(function () {

    //----------------------------------------------------
    // Submit Daily Log
    //----------------------------------------------------

    $('#dailyLogForm').on('submit', function (e) {

        e.preventDefault();

        //------------------------------------------------

        $('.validation-error').html('');

        $('#saveDailyLogBtn').prop('disabled', true);

        $('#saveSpinner').removeClass('d-none');

        //------------------------------------------------

        let formData = new FormData(this);

        $.ajax({

            url: "{{ route('daily-tracker.store') }}",

            method: "POST",

            data: formData,

            processData: false,

            contentType: false,

            cache: false,

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            },

            success: function (response) {

                //------------------------------------------------

                $('#saveDailyLogBtn').prop('disabled', false);

                $('#saveSpinner').addClass('d-none');

                //------------------------------------------------

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: response.message,

                    timer: 1800,

                    showConfirmButton: false

                });

                //------------------------------------------------

                $('#dailyLogModal').modal('hide');

                //------------------------------------------------

                $('#dailyLogForm')[0].reset();

                //------------------------------------------------

                $('#hours_worked').val('0.00');

                //------------------------------------------------

                $('#remainingAfterEntry').text(

                    $('#remaining_progress').val()+'%'

                );

                //------------------------------------------------

                if ($.fn.DataTable.isDataTable('#dailyLogsTable')) {

                    $('#dailyLogsTable').DataTable().ajax.reload(null,false);

                }

                //------------------------------------------------
                // Refresh Summary Cards
                //------------------------------------------------

                refreshSummaryCards();

            },

            error: function (xhr) {

                //------------------------------------------------

                $('#saveDailyLogBtn').prop('disabled', false);

                $('#saveSpinner').addClass('d-none');

                //------------------------------------------------

                if(xhr.status===422){

                    $.each(xhr.responseJSON.errors,function(key,value){

                        $('[data-field="'+key+'"]').html(value[0]);

                    });

                    return;

                }

                //------------------------------------------------

                Swal.fire({

                    icon:'error',

                    title:'Error',

                    text:'Something went wrong.'

                });

            }

        });

    });

});
</script>
@endpush