@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(in_array(getRoleName(activeRole()), ['Teacher','Assistant Professor','Professor','Associate Professor']))
        <div class="card">
            <!-- Header with Add Feedback Button -->
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-title mb-0">Completion of Course Folder</h5>
                <a href="{{ url('kpa/1/category/3/indicator/120') }}" class="btn btn-success">Add</a>
            </div>

            <div class="card-datatable table-responsive card-body">
                <table class="table" id="userTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Class Code</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $key)
                            @php
                                if ($key->completion_of_Course_folder == 100) {
                                    $color = '#6EA8FE';
                                    $status = 'Completed';
                                } elseif ($key->completion_of_Course_folder == 70) {
                                    $color = '#ffcb9a';
                                    $status = 'Partially Completed';
                                } elseif ($key->completion_of_Course_folder == 25) {
                                    $color = '#ff4c51';
                                    $status = 'Not Completed';
                                } else {
                                    $color = '#000000';
                                    $status = 'NA';
                                }
                                
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $key->facultyClass->class_name ?? 'N/A' }}</td>
                                <td>{{ $key->facultyClass->code ?? 'N/A' }}</td>
                                <td style="color: {{ $color }}">{{ $status }}</td>
                                <td>{{ $key->completion_of_Course_folder ?? 'N/A' }}</td>
                                <td>  @if($key->status == 1)
                                        @if($key->reject_status == 1)
                                            <span class="badge bg-label-danger"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top" 
                                                data-bs-custom-class="tooltip-danger" 
                                                title="{{ $key->reject_status_remarks }}">
                                                Reject by HOD
                                            </span>
                                        @else
                                            <span class="badge bg-label-warning">Unverified</span>
                                        @endif
                                    @elseif($key->status == 2)
                                        <span class="badge bg-label-success">Verified by HOD</span>
                                    @else
                                        N/A
                                    @endif</td>
                                <td>
                                @if($key->status == 1)
                                    <a href="{{ route('completion-of-course-folder.edit', $key->id) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                @endif
                                    
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn rounded-pill btn-outline-primary waves-effect view-form-btn"
                                        data-form='@json($key)'>
                                        <span class="icon-xs icon-base ti tabler-eye me-2"></span>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>



                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewFormModalLabel">Form Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                           
                            <tr>
                                <th>Created Date</th>
                                <td id="modalCreatedDate"></td>
                            </tr>
                            <tbody id="modalExtraFields"></tbody>
                        </table>
                        <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center"><i class="icon-base ti tabler-history me-3"></i>History</h5>
                        <ul class="timeline mb-0" id="modalExtraFieldsHistory">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->
        @else
             <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
                <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
                <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
                <div class="mt-12">
                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}" alt="page-misc-not-authorized" width="170" class="img-fluid" />
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables-responsive/dataTables.responsive.js') }}"></script>
@if(in_array(getRoleName(activeRole()), ['Teacher','Assistant Professor','Professor','Associate Professor']))
<script>
  const CURRENT_FACULTY_ID = @json(auth()->user()->faculty_id);
         window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
        window.activeUserRole = "{{ getRoleName(activeRole()) }}";
    $(document).ready(function () {
        let table = $('#userTable');

        if (table.length) {
            // Destroy existing instance if any
            if ($.fn.DataTable.isDataTable('#userTable')) {
                table.DataTable().destroy();
            }

            // Initialize DataTable
            table.DataTable({
                responsive: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                autoWidth: true
            });
        }

        $(document).on('click', '.view-form-btn', function () {
                    const form = $(this).data('form');
                    $('#modalExtraFields').find('.optional-field').remove();
                    $('#modalExtraFieldsHistory').find('.optional-field').remove();
                    $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
                    $('#modalStatus').text(form.status || 'Pending');
                    $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
                      
                    if (form.faculty_class.class_name) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Class Name</th><td>${form.faculty_class.class_name}</td></tr>`);
                    }

                    if ( form.faculty_class.code) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Class Cod</th><td>${ form.faculty_class.code}</td></tr>`);
                    }
                    if ( form.document_url) {
                        $('#modalExtraFields').append(`<tr class="optional-field"><th>Details</th><td>${ form.document_url}</td></tr>`);
                    }
                    if (form.completion_of_Course_folder !== undefined && form.completion_of_Course_folder !== null) {

                        let folderStatus = '';

                        if (form.completion_of_Course_folder == 100) {
                            folderStatus = 'Completed';
                        } else if (form.completion_of_Course_folder == 70) {
                            folderStatus = 'Partially Completed';
                        } else if (form.completion_of_Course_folder == 25) {
                            folderStatus = 'Not Completed';
                        } else {
                            folderStatus = form.completion_of_Course_folder + '%';
                        }

                        $('#modalExtraFields').append(`
                            <tr class="optional-field">
                                <th>Course Folder Status</th>
                                <td>${folderStatus}</td>
                            </tr>
                        `);
                    }
                   
                    
                    if (form.update_history) {
                            // Parse JSON string if it's a string
                            let history = typeof form.update_history === 'string' ? JSON.parse(form.update_history) : form.update_history;

                            if (history.length > 0) {
                                
                                let historyHtml = '';

                                history.forEach(update => {
                                    let histortText = 'N/A';

                                    // Role-based status mapping
                                    if (update.role === 'HOD') {
                                        if (update.status == '0') histortText = 'Reject';
                                        else if (update.status == '1') histortText = 'unapproved';
                                            else if (update.status == '2') histortText = 'Approved';
                                    } else if (update.role === 'ORIC') {
                                        if (update.status == '0') histortText = 'Reject';
                                        else if (update.status == '2') histortText = 'unapproved';
                                        else if (update.status == '3') histortText = 'Approved';
                                    } else {
                                        histortText = update.status; // fallback
                                    }
                                    historyHtml += `
                                        <li class="timeline-item timeline-item-transparent optional-field">
                                            <span class="timeline-point timeline-point-primary"></span>
                                            <div class="timeline-event">
                                                <div class="timeline-header mb-3">
                                                    <h6 class="mb-0">${update.user_name}</h6><small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                                </div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="badge bg-lighter rounded-3">
                                                     <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                                    </div>
                                                    <div class="badge bg-lighter rounded-3 ms-2">
                                                     <span class="h6 mb-0 text-body">${histortText}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="badge bg-danger rounded-3 ms-2">
                                                    <span class="h6 mb-0 text-white">${update.remarks || ''}<span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    `;
                                });

                                $('#modalExtraFieldsHistory').append(historyHtml);
                            }
                        }
                        else {
                            $('#modalExtraFieldsHistory').append(`
                                <li class="optional-field">
                                    <th>No History Avalable</th>
                                </li>
                            `);
                        }
                    $('#viewFormModal').modal('show');
                });
    });
</script>
 @endif
@endpush