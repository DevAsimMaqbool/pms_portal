@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />

    <style>
        #complaintTable th,
        #complaintTable td {
            border: 1px solid #333 !important;
            vertical-align: middle;
        }

        #complaintTable input.form-control {
            width: 80px;
            margin: 0 auto;
            text-align: center;
        }

        #complaintTable tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive card-body">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">My Assigned KPAs and Indicators</h5>
                    <div>
                        <label for="roleFilter" class="me-2 fw-bold">Filter by Role:</label>
                        <select id="roleFilter" name="roleFilter" class="form-select d-inline-block w-auto">
                            <option value="">All</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <form id="weightageForm" method="POST" action="{{ route('assignments.weightage.save') }}">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ old('role_id', '') }}" id="selectedRoleId">

                    <table class="table table-bordered table-striped table-hover text-center" id="complaintTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>KPA</th>
                                <th>KPA Weightage</th>
                                <th>Indicator Category</th>
                                <th>Indicator Category Weightage</th>
                                <th>Indicator</th>
                                <th>Indicator Weightage</th>
                            </tr>
                        </thead>
                        <tbody id="assignmentTableBody">
                            {{-- Table rows injected via AJAX --}}
                        </tbody>
                    </table>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Save Weightages</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>

    <script>
        $(document).ready(function () {

            // Fetch assignments on role change
            $('#roleFilter').change(function () {
                let selectedRole = $(this).val();
                $('#selectedRoleId').val(selectedRole); // Update hidden input
                fetchAssignments(selectedRole);
            });

            // Function to fetch assignments via AJAX
            function fetchAssignments(roleName) {
                $.ajax({
                    url: "{{ route('assignments.byRole') }}",
                    type: "GET",
                    data: { role_name: roleName },
                    success: function (response) {
                        $('#assignmentTableBody').empty();
                        let counter = 1;

                        response.forEach(kpa => {
                            kpa.category.forEach(category => {
                                category.indicator.forEach((indicator, index) => {

                                    let tr = '<tr>';
                                    tr += `<td>${counter++}</td>`;

                                    // KPA & Weightage rowspan
                                    if (category === kpa.category[0] && index === 0) {
                                        let kpaRowspan = kpa.category.reduce((sum, c) => sum + c.indicator.length, 0);
                                        tr += `<td rowspan="${kpaRowspan}">${kpa.performance_area}</td>`;
                                        tr += `<td rowspan="${kpaRowspan}">
                            <input type="text" name="kpa_weightage[]" class="form-control" value="${kpa.kpa_weightage ?? ''}" required>
                            <input type="hidden" name="kpa_id[]" value="${kpa.id}">
                            </td>`;
                                    }

                                    // Indicator Category & Weightage rowspan
                                    if (index === 0) {
                                        let catRowspan = category.indicator.length;
                                        tr += `<td rowspan="${catRowspan}">${category.indicator_category}</td>`;
                                        tr += `<td rowspan="${catRowspan}">
                            <input type="text" name="indicator_category_weightage[]" class="form-control" value="${category.indicator_category_weightage ?? ''}" required>
                            <input type="hidden" name="indicator_category_id[]" value="${category.id}">
                            </td>`;
                                    }

                                    // Indicator & Weightage
                                    tr += `<td>${indicator.indicator}</td>`;
                                    tr += `<td>
                            <input type="text" name="indicator_weightage[]" class="form-control" value="${indicator.indicator_weightage ?? ''}" required>
                            <input type="hidden" name="indicator_id[]" value="${indicator.id}">
                            </td>`;

                                    tr += '</tr>';

                                    $('#assignmentTableBody').append(tr);
                                });
                            });
                        });
                    },
                    error: function (err) {
                        console.error(err);
                        //alert('Failed to fetch assignments!');
                    }
                });
            }

            // Initial load: fetch all roles
            fetchAssignments('');
        });
    </script>
@endpush