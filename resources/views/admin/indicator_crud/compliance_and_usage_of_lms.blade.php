@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <!-- Header with Add Feedback Button -->
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-title mb-0">Compliance and Usage of LMS</h5>
                <a href="{{ url('kpa/1/category/3/indicator/121') }}" class="btn btn-primary">Add</a>
            </div>

            <div class="card-datatable">
                <table class="table" id="userTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Class Code</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $key)
                            @php
                                if ($key->compliance_and_usage_of_lms == 100) {
                                    $color = '#6EA8FE';
                                    $status = 'Completed';
                                } elseif ($key->compliance_and_usage_of_lms == 70) {
                                    $color = '#ffcb9a';
                                    $status = 'Partially Completed';
                                } elseif ($key->compliance_and_usage_of_lms == 25) {
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
                                <td>{{ $key->compliance_and_usage_of_lms ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('compliance-usage-of-lms.edit', $key->id) }}"
                                        class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No Records Found</td>
                            </tr>
                        @endforelse
                    </tbody>



                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-responsive/dataTables.responsive.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(function () {

                let table = $('#userTable');

                if (table.length) {

                    if ($.fn.DataTable.isDataTable('#userTable')) {
                        table.DataTable().destroy();
                    }

                    table.DataTable({
                        responsive: true,
                        ordering: true,
                        paging: true,
                        searching: true,
                        info: true,
                        autoWidth: false
                    });

                }

            });
    </script>
@endpush