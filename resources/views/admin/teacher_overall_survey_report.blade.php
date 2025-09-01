@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="keyPerformanceTable">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Campus</th>
                            <th>Faculty Code</th>
                            <th>Faculty Name</th>
                            <th>Total Courses</th>
                            <th>Total Respondents</th>
                            <th>Obtained Score</th>
                            <th>Max Score</th>
                            <th>Percentage Score</th>
                            <th>Avg Score</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!--/ Permission Table -->

        <!-- Modal -->
        <!-- Add Permission Modal -->
        <div class="modal fade" id="keyPerformanceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="text-center mb-6">
                            <h3 class="modal-title" id="modalTitle">Add Key Performance Area</h3>
                            <!-- <p class="text-body-secondary">Key Performance Area you may use and assign to your users.</p> -->
                        </div>

                        <form id="keyPerformanceForm" class="row">
                            <input type="hidden" id="keyPerformanceId">
                            <div class="col-12 form-control-validation mb-4">
                                <label class="form-label" for="key-performance-area">KPA Name</label>
                                <input type="text" id="key-performance-area" name="key_performance_area" required
                                    class="form-control" />
                                <div class="invalid-feedback" id="key-performance-areaError"></div>
                            </div>
                            <div class="col-12 text-center demo-vertical-spacing">
                                <button type="submit" class="btn btn-primary me-sm-4 me-1">Save</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">Discard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->


        <!-- /Modal -->
    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
@endpush
@push('script')
    <script>
        const modal = new bootstrap.Modal(document.getElementById('keyPerformanceModal'));
        let isEdit = false;

        function fetchKeyperformance() {
            $.ajax({
                url: "{{ route('survey.report') }}",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    const rowData = data.map((s, i) => {
                        return [
                            i + 1,                         // #
                            s.campus || 'N/A',        // Campus
                            s.faculty_code || 'N/A',       // Program
                            s.faculty_name || 'N/A',         // Batch
                            s.total_courses || 'N/A',      // Class Section
                            s.total_respondents || 'N/A',         // Student ID
                            s.obtained_score || 'N/A',         // Student ID
                            s.max_score || 'N/A',         // Student ID
                            s.percentage_score || 'N/A',         // Student ID
                            s.avg_score || 'N/A',         // Student ID
                            `<div class="d-flex align-items-center">
                                                            <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" href="survey/${s.id}">
                                                                <i class="icon-base ti tabler-eye icon-md"></i>
                                                            </a>
                                                        </div>`
                        ];
                    });

                    // Initialize DataTable only once
                    if (!$.fn.DataTable.isDataTable('#keyPerformanceTable')) {
                        window.keyPerformanceTable = $('#keyPerformanceTable').DataTable({
                            processing: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            data: rowData,
                            columns: [
                                { title: "Rank" },
                                { title: "Campus" },
                                { title: "Faculty Code" },
                                { title: "Faculty Name" },
                                { title: "Total Courses" },
                                { title: "Total Respondents" },
                                { title: "Obtained Score" },
                                { title: "Max Score" },
                                { title: "Percentage Score" },
                                { title: "Avg Score" },
                                { title: "View Report", orderable: false, searchable: false }
                            ],
                            layout: {
                                topStart: {
                                    rowClass: "row m-3 my-0 justify-content-between",
                                    features: [
                                        {
                                            pageLength: {
                                                menu: [10, 25, 50, 100],
                                                text: "Show _MENU_"
                                            }
                                        },
                                        {
                                            buttons: [
                                                {
                                                    text: '<i class="icon-base ti tabler-file-download icon-xs me-0 me-sm-2"></i> <span class="d-none d-sm-inline-block">Download Report as PDF</span>',
                                                    className: "btn btn-danger",
                                                    action: function () {
                                                        window.location.href = "{{ route('survey.report.pdf') }}";
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            }
                        });
                    } else {
                        // If already initialized, just refresh data
                        window.keyPerformanceTable.clear().rows.add(rowData).draw();
                    }
                },
                error: function (xhr) {
                    console.error("Error fetching survey:", xhr.responseText);
                }
            });
        }


        function openAddKeyPerformanceModal() {
            isEdit = false;
            $('#modalTitle').text('Add Key Performance Area');
            $('#keyPerformanceForm')[0].reset();
            $('#keyPerformanceId').val('');
            $('.invalid-feedback').text('');
            modal.show();
        }

        function editKeyperformance(id) {
            isEdit = true;
            $.get(`/survey/${id}/edit`, function (data) {
                $('#keyPerformanceId').val(data.id);
                $('#key-performance-area').val(data.performance_area);
                $('#modalTitle').text('Edit Key Performance Area');
                $('.invalid-feedback').text('');
                modal.show();
            });
        }

        $('#keyPerformanceForm').submit(function (e) {
            e.preventDefault();
            const id = $('#keyPerformanceId').val();
            const url = isEdit ? `/survey/${id}` : "{{ route('survey.store') }}";
            const method = isEdit ? 'PUT' : 'POST';
            const message = isEdit ? 'Updated successfully!' : 'Added successfully!';
            const formData = {
                _token: "{{ csrf_token() }}",
                _method: method,
                key_performance_area: $('#key-performance-area').val()
            };
            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function (res) {
                    $('#keyPerformanceForm')[0].reset();
                    $('#keyPerformanceId').val('');
                    modal.hide();
                    Swal.fire({
                        title: message,
                        icon: "success",
                        customClass: {
                            confirmButton: "btn btn-primary waves-effect waves-light"
                        },
                        buttonsStyling: !1
                    });
                    fetchKeyperformance();
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $(`#${key}Error`).text(value[0]).show();
                    });
                }
            });
        });
        function deleteKeyperformance(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/survey/${id}`,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function (res) {
                            fetchKeyperformance(); // Refresh the table
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The Key Performance Area has been deleted.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong while deleting.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }


        $(document).ready(function () {
            fetchKeyperformance();
        });
    </script>
@endpush