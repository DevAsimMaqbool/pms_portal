@extends('layouts.app')
@push('style')
    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
   
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>Enterprise Task Management & Performance Monitoring System 1111</h4>

        </div>

        <div class="card-body">

            <table class="table table-bordered yajra-datatable">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Task Title</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th width="150px">Action</th>

                    </tr>

                </thead>

            </table>

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
                            <th>Status</th>
                            <td>
                               <div class="mt-3">

                        <label class="me-4">
                            <input type="radio"
                                name="task_action"
                                value="approve">
                            Approve
                        </label>

                        <label>
                            <input type="radio"
                                name="task_action"
                                value="reject">
                            Reject
                        </label>

                    </div>
                            </td>
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
                            <th>Status</th>
                            <td id="task_status"></td>
                        </tr>

                        <tr>
                            <th>Priority</th>
                            <td id="task_priority"></td>
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

let table;

$(function () {

    table = $('.yajra-datatable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('manage-employee-tasks.index') }}",

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },

            {
                data: 'task_title',
                name: 'task_title'
            },

            {
                data: 'status',
                name: 'status'
            },

            {
                data: 'planned_type',
                name: 'planned_type'
            },

            {
                data: 'task_date',
                name: 'task_date'
            },

            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            },
        ]
    });

});



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
    let taskStatus = $(this).data('taskstatus');
    // Approved 
    if (taskStatus == 2) { $('input[name="task_action"][value="approve"]') .prop('checked', true); } 
    // Rejected
     else if (taskStatus == 3) { $('input[name="task_action"][value="reject"]') .prop('checked', true); }
    
    let update_history = $(this).attr('data-updatehistory');

    $('#modalExtraFieldsHistory').find('.optional-field').remove();

    if (update_history && update_history !== 'null') {

        try {

            let history = JSON.parse(update_history);

            if (Array.isArray(history) && history.length > 0) {

                let historyHtml = '';

                history.forEach(update => {

                    let remarksBadge = '';
                    let statusClass = 'bg-secondary'; if (update.status === 'approve') { statusClass = 'bg-success'; } else if (update.status === 'reject') { statusClass = 'bg-danger'; }

                    if (update.remarks) {

                        remarksBadge = `
                            <div class="d-flex align-items-center mb-1">
                                <div class="badge bg-danger rounded-3 ms-2">
                                    <span class="text-white">
                                        ${update.remarks}
                                    </span>
                                </div>
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

                $('#modalExtraFieldsHistory').append(historyHtml);

            } else {

                $('#modalExtraFieldsHistory').append(`
                    <li class="optional-field">
                        No History Available
                    </li>
                `);
            }

        } catch (e) {

            console.log(e);

            $('#modalExtraFieldsHistory').append(`
                <li class="optional-field text-danger">
                    Invalid History Data
                </li>
            `);
        }

    } else {

        $('#modalExtraFieldsHistory').append(`
            <li class="optional-field">
                No History Available
            </li>
        `);
    }

});


$(document).on('change', 'input[name="task_action"]', function () {

    let value = $(this).val();

    let taskId = $('#task_id').val();

    const bootstrapModal = bootstrap.Modal.getInstance(
        document.getElementById('viewFormModal')
    );

    bootstrapModal.hide();

    // APPROVE
    if (value === 'approve') {

        Swal.fire({

            title: 'Approve Task',

            html: `

                <div class="text-start">

                    <label class="form-label">
                        Self Completion % <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        id="approve_self_completion"
                        class="swal2-input"
                        placeholder="Enter completion %"
                        min="0"
                        max="100"
                        required>

                </div>

            `,

            showCancelButton: true,

            confirmButtonText: 'Approve',

            cancelButtonText: 'Cancel',

            focusConfirm: false,

            preConfirm: () => {

                let selfCompletion = $('#approve_self_completion')
                    .val()
                    .trim();

                if (
                    selfCompletion === '' ||
                    selfCompletion === null
                ) {

                    Swal.showValidationMessage(
                        'Self completion is required'
                    );

                    return false;
                }

                if (
                    selfCompletion < 0 ||
                    selfCompletion > 100
                ) {

                    Swal.showValidationMessage(
                        'Completion must be between 0 and 100'
                    );

                    return false;
                }

                return {
                    self_completion: selfCompletion
                };
            }

        }).then((result) => {

            if (result.isConfirmed) {

                updateTask(
                    taskId,
                    'approve',
                    null,
                    result.value.self_completion
                );

            } else {

                bootstrapModal.show();
            }
        });

    }

    // REJECT
    else {

        Swal.fire({

            title: 'Reject Task',

            html: `

                <div class="mb-3 text-start">

                    <label class="form-label">
                        Rejection Remarks
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="reject_remarks"
                        class=""
                        placeholder="Enter remarks..."
                        style="display:flex;width:100%;height:120px;"
                        required>
                    </textarea>

                </div>

                <div class="text-start">

                    <label class="form-label">
                        Self Completion %
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="number"
                        id="reject_self_completion"
                        class="swal2-input"
                        placeholder="Enter completion %"
                        min="0"
                        max="100"
                        required>

                </div>

            `,

            showCancelButton: true,

            confirmButtonText: 'Reject',

            cancelButtonText: 'Cancel',

            focusConfirm: false,

            preConfirm: () => {

                let remarks = $('#reject_remarks')
                    .val()
                    .trim();

                let selfCompletion = $('#reject_self_completion')
                    .val()
                    .trim();

                if (remarks === '') {

                    Swal.showValidationMessage(
                        'Remarks are required'
                    );

                    return false;
                }

                if (
                    selfCompletion === '' ||
                    selfCompletion === null
                ) {

                    Swal.showValidationMessage(
                        'Self completion is required'
                    );

                    return false;
                }

                if (
                    selfCompletion < 0 ||
                    selfCompletion > 100
                ) {

                    Swal.showValidationMessage(
                        'Completion must be between 0 and 100'
                    );

                    return false;
                }

                return {

                    remarks: remarks,

                    self_completion: selfCompletion
                };
            }

        }).then((result) => {

            if (result.isConfirmed) {

                updateTask(
                    taskId,
                    'reject',
                    result.value.remarks,
                    result.value.self_completion
                );

            } else {

                bootstrapModal.show();
            }
        });
    }
});



function updateTask(
    taskId,
    actionType,
    remarks = null,
    selfCompletion = null
)
{

    $.ajax({

        url: '/manage-employee-tasks/' + taskId,

        type: 'PUT',

        data: {

            _token: $('meta[name="csrf-token"]').attr('content'),

            action_type: actionType,

            reject_remarks: remarks,

            self_completion: selfCompletion
        },

        success: function (response) {

            Swal.fire({

                icon: 'success',

                title: 'Success',

                text: response.message,

                timer: 1500,

                showConfirmButton: false
            });

            let modal = bootstrap.Modal.getInstance(
                document.getElementById('viewFormModal')
            );

            modal.hide();

            $('input[name="task_action"]').prop('checked', false);

            table.ajax.reload(null, false);
        },

        error: function (xhr) {

            let errors = xhr.responseJSON.errors;

            let errorMessage = 'Something went wrong';

            if (errors) {

                errorMessage = Object.values(errors)
                    .map(err => err[0])
                    .join('<br>');
            }

            Swal.fire({

                icon: 'error',

                title: 'Validation Error',

                html: errorMessage
            });
        }
    });
}

</script>

@endpush