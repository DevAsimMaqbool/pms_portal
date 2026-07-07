@extends('layouts.app')
@push('style')
    {{-- Vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <style>
        body {
            background: #f5f7fb;
        }

        /* Card */

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eef2f7;
            padding: 18px 24px;
        }

        .card-body {
            padding: 24px;
        }

        /* Filter */

        .filter-box {
            background: #f8fafc;
            border: 1px solid #e8edf4;
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 22px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #5c6470;
        }

        .form-control {
            height: 44px;
            border-radius: 10px;
            border: 1px solid #dbe4ee;
        }

        .form-control:focus {
            border-color: #5b8def;
            box-shadow: 0 0 0 .15rem rgba(91, 141, 239, .15);
        }

        .btn-primary {
            background: #5b8def;
            border: none;
            border-radius: 10px;
            height: 44px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #4a7de0;
            box-shadow: 0 8px 18px rgba(91, 141, 239, .25);
        }

        /* Table */

        .summaryTable {
            border: 1px solid #e8edf4;
            border-radius: 14px;
            overflow: hidden;
        }

        .summaryTable thead th {
            background: #f8fafc !important;
            color: #495057 !important;
            font-size: 13px;
            font-weight: 700;
            border-bottom: 2px solid #e8edf4 !important;
            padding: 16px 12px;
            white-space: nowrap;
        }

        .summaryTable tbody td {
            padding: 15px 12px;
            font-size: 14px;
            color: #4b5563;
            border-color: #edf2f7 !important;
            vertical-align: middle;
        }

        .summaryTable tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        .summaryTable tbody tr:hover td {
            background: #eef6ff !important;
        }

        /* Employee */

        .summaryTable td:nth-child(2) {
            text-align: left;
            font-weight: 600;
            color: #1f2937;
        }

        /* Important values */

        .summaryTable td:nth-child(3),
        .summaryTable td:nth-child(4),
        .summaryTable td:nth-child(9),
        .summaryTable td:nth-child(10) {
            font-weight: 700;
        }

        /* Section separators */

        .summaryTable thead th,
        .summaryTable tbody td {
            border: 1px solid #edf2f7 !important;
        }

        .summaryTable thead th {
            border-bottom: 2px solid #dfe7ef !important;
        }

        .dataTables_wrapper {
            overflow-x: auto;
        }
    </style>
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h3 class="mb-1 fw-bold">
                        Manager Verification Summary
                    </h3>

                    <small class="text-muted">
                        Monthly employee verification performance overview.
                    </small>
                </div>

                <i class="fas fa-user-check text-primary fs-1"></i>

            </div>

            <div class="card-body">
                <div class="filter-box mt-3">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" id="from_date" class="form-control" value="{{ now()->toDateString() }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" id="to_date" class="form-control" value="{{ now()->toDateString() }}">
                        </div>

                        <div class="col-md-2">
                            <button id="filter" class="btn btn-primary w-100">
                                <i class="fa fa-search me-1"></i>
                                Apply
                            </button>
                        </div>

                    </div>

                </div>
                <table class="table table-bordered table-hover text-center summaryTable">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Days Logged</th>
                            <th>Verified</th>
                            <th>Coverage</th>
                            <th>Avg Self</th>
                            <th>Avg Manager</th>
                            <th>Variance</th>
                            <th>Aligned</th>
                            <th>Mismatch</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                </table>

            </div>

        </div>

    </div>

@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script>

        let table = $('.summaryTable').DataTable({

            processing: true,

            serverSide: true,

            ajax: {
                url: "{{ route('manager-verification-summary') }}",
                data: function (d) {

                    d.from_date = $('#from_date').val();

                    d.to_date = $('#to_date').val();

                }
            },

            columns: [

                { data: 'DT_RowIndex' },

                { data: 'employee' },

                { data: 'days_logged' },

                { data: 'days_verified' },

                { data: 'coverage' },

                { data: 'avg_self' },

                { data: 'avg_mgr' },

                { data: 'variance' },

                { data: 'aligned' },

                { data: 'mismatch' },

                { data: 'status_badge' }

            ]

        });

        $('#filter').click(function () {

            table.draw();

        });

    </script>

@endpush