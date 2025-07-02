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
                            <th>#</th>
                            <th>Name</th>
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
                            <p class="text-body-secondary">Key Performance Area you may use and assign to your users.</p>
                        </div>

                        <form id="keyPerformanceForm" class="row">
                            <input type="hidden" id="keyPerformanceId">
                            <div class="col-12 form-control-validation mb-4">
                                <label class="form-label" for="key-performance-area">Name</label>
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
                url: "{{ route('departments.index') }}",
                method: "GET",
                dataType: "json",
                success: function (data) {

                    const rowData = data.map((s, i) => {
                        const createdAt = new Date(s.created_at);
                        const formattedDate = createdAt.toISOString().split('T')[0];
                        return [
                            i + 1,
                            s.name || 'N/A',
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
                                { title: "#" },
                                { title: "Name" }
                            ],
                            layout: {
                                topStart: {
                                    rowClass: "row m-6 my-0 justify-content-between",
                                    features: [
                                        {
                                            pageLength: {
                                                menu: [10, 25, 50, 100],
                                                text: "Show _MENU_"
                                            }
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
                    console.error("Error fetching complaint:", xhr.responseText);
                }
            });
        }


        $(document).ready(function () {
            fetchKeyperformance();
        });
    </script>
@endpush