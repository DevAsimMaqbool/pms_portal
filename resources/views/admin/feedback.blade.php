@extends('layouts.app')


@push('style')

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="">
            <div class="row mb-3">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Feedback Report</h5>

                            <form method="GET" id="getReport">
                                <div class="row g-3 align-items-end">
                                    <!-- Campus -->
                                    <div class="col-md-2">
                                        <label for="apkMultiple" class="form-label">Campus</label>
                                        <select id="apkMultiple" name="campus_id" class="select2 form-select">
                                            <option value="">Select Campus</option>
                                            @foreach($campuses as $campus)
                                                <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Faculty -->
                                    <div class="col-md-4">
                                        <label for="Faculty" class="form-label">Faculty</label>
                                        <select id="Faculty" name="faculty_id" class="select2 form-select">
                                            <option value="">Select Faculty</option>
                                        </select>
                                    </div>

                                    <!-- Department -->
                                    <div class="col-md-4">
                                        <label for="department" class="form-label">Department</label>
                                        <select id="department" name="department_id" class="form-select">
                                            <option value="">Select Department</option>
                                        </select>
                                    </div>

                                    <!-- Go Button -->
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Go</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-datatable table-responsive">
                        <table class="table border-top" id="reportTable">
                            <thead>
                                <tr>
                                    <th>Faculty</th>
                                    <th>Department</th>
                                    <th>Feedback</th>
                                    <th>Response Rate</th>
                                    <th>Attempts</th>
                                    <th>Registered Students</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--  Topic and Instructors  End-->
        <!-- / Content -->
@endsection
    @push('script')
        <script>

            $(document).ready(function () {
                // Initialize all
                $('#apkMultiple, #Faculty, #department').select2({
                    placeholder: 'Select option',
                    allowClear: true
                });

                // On KeyPerformanceArea change
                $('#apkMultiple').on('change', function () {
                    let kpaIds = $(this).val();
                    $.ajax({
                        url: "{{ route('reports.getFaculties') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            kpa_ids: kpaIds
                        },
                        success: function (data) {
                            let $categorySelect = $('#Faculty');
                            $categorySelect.empty();
                            $categorySelect.append('<option value="#">Select Faculty</option>');
                            data.forEach(function (item) {
                                $categorySelect.append(
                                    new Option(item.name, item.id, false, false)
                                );
                            });

                            // $categorySelect.trigger('change');
                        }
                    });
                });

                // On KeyPerformanceArea change
                $('#Faculty').on('change', function () {
                    let kpaIds = $(this).val();
                    $.ajax({
                        url: "{{ route('reports.getDepartments') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            kpa_ids: kpaIds
                        },
                        success: function (data) {
                            let $facultySelect = $('#department');
                            $facultySelect.empty();
                            $facultySelect.append('<option value="#">Select Department</option>');
                            data.forEach(function (item) {
                                $facultySelect.append(
                                    new Option(item.name, item.id, false, false)
                                );
                            });

                            // $categorySelect.trigger('change');
                        }
                    });
                });


                // Submit form and load report data
                $('#getReport').on('submit', function (e) {
                    e.preventDefault();

                    $.get("{{ route('feedback.report') }}", $(this).serialize(), function (data) {
                        const rowData = data.map((item) => ([
                            item.faculty_name || 'N/A',
                            item.department_name || 'N/A',
                            item.feedback_title || 'N/A',
                            item.response_rate ? item.response_rate + '%' : '0%',
                            item.attempts || 0,
                            item.registered_students || 0
                        ]));

                        $('#reportTable').DataTable({
                            data: rowData,
                            columns: [
                                { title: "Faculty" },
                                { title: "Department" },
                                { title: "Feedback" },
                                { title: "Response Rate" },
                                { title: "Attempts" },
                                { title: "Registered Students" }
                            ],
                            destroy: true,
                            responsive: true,
                            pageLength: 10,
                            lengthMenu: [10, 25, 50, 100],
                            language: {
                                search: "_INPUT_",
                                searchPlaceholder: "Search..."
                            }
                        });
                    }).fail(xhr => console.error("Error:", xhr.responseText));
                });

                // Initialize empty table
                $('#reportTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search..."
                    }
                });

            });
        </script>
        <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
        <script src="{{ asset('admin/assets/js/app-user-view-account.js') }}"></script>
        <!-- Vendors JS -->
        <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
        <!-- Page JS -->
        <script src="{{ asset('admin/assets/js/app-academy-dashboard.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
        <script src="{{ asset('admin/assets/js/charts-chartjs-legend.js') }}"></script>
        <script src="{{ asset('admin/assets/js/charts-chartjs.js') }}"></script>

    @endpush