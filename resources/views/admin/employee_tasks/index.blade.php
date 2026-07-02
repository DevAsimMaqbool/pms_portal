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

            <h4>Enterprise Task Management & Performance Monitoring System</h4>
            <a href="{{ route('employee-tasks.create') }}"
               class="btn btn-sm btn-primary">
                Add Task
            </a>
            

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
$(function () {

    var table = $('.yajra-datatable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('employee-tasks.index') }}",

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

    // DELETE
    $(document).on('click', '.deleteBtn', function(){

    let id = $(this).data('id');

    Swal.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: '/employee-tasks/' + id,

                type: 'POST',

                data: {

                    _token: '{{ csrf_token() }}',

                    _method: 'DELETE'
                },

                success: function(response){

                    $('.yajra-datatable')
                        .DataTable()
                        .ajax
                        .reload();

                    Swal.fire({

                        icon:'success',

                        title:response.message
                    });
                }
            });
        }
    });
});

});

</script>

@endpush