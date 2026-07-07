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

        /* Filters */

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
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #dbe4ee;
            height: 44px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 .15rem rgba(91, 141, 239, .15);
            border-color: #5b8def;
        }

        /* Buttons */

        .btn-primary {
            border: none;
            border-radius: 10px;
            background: #5b8def;
            height: 44px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(91, 141, 239, .25);
        }

        .btn-light {
            border-radius: 10px;
            height: 44px;
            border: 1px solid #dee6ef;
        }

        /* Table */

        /* ---------- DataTable ---------- */

        .yajra-datatable {
            border: 1px solid #e8edf4;
            border-radius: 14px;
            overflow: hidden;
        }

        .yajra-datatable thead th {
            background: #f8fafc;
            color: #495057;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .3px;
            padding: 16px 12px;
            border-bottom: 2px solid #e8edf4 !important;
            vertical-align: middle;
        }

        .yajra-datatable tbody td {
            padding: 15px 12px;
            font-size: 14px;
            color: #4b5563;
            border-color: #edf2f7 !important;
            vertical-align: middle;
        }

        .yajra-datatable tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        .yajra-datatable tbody tr:hover {
            background: #eef6ff !important;
            transition: .2s;
        }

        .yajra-datatable tbody tr:hover td {
            background: transparent !important;
        }

        /* Employee column */

        .yajra-datatable tbody td:nth-child(2) {
            text-align: left;
            font-weight: 400;
            color: #1f2937;
        }

        /* Activities & Hours */

        .yajra-datatable tbody td:nth-child(3) {
            font-weight: 400;
            color: #2563eb;
        }

        .yajra-datatable tbody td:nth-child(4) {
            font-weight: 400;
            color: #059669;
        }

        /* Percentage columns */

        .yajra-datatable tbody td:nth-child(n+5):nth-child(-n+11) {
            font-weight: 400;
        }

        /* Match column */

        .yajra-datatable tbody td:last-child {
            font-weight: 400;
        }

        .yajra-datatable thead th,
        .yajra-datatable tbody td {
            border: 1px solid #edf2f7 !important;
        }

        .yajra-datatable thead th {
            border-bottom: 2px solid #dfe7ef !important;
        }

        /* Scroll */

        .dataTables_wrapper {
            overflow-x: auto;
        }

        /* Small badges */

        .metric-blue {
            background: #eaf2ff;
            color: #3568c9;
        }

        .metric-green {
            background: #ebfbf3;
            color: #16835e;
        }

        .metric-yellow {
            background: #fff8e5;
            color: #b67800;
        }

        .metric-red {
            background: #fdeeee;
            color: #cf3d3d;
        }

        .metric-gray {
            background: #f2f4f7;
            color: #57606f;
        }

        .metric-blue,
        .metric-green,
        .metric-yellow,
        .metric-red,
        .metric-gray {
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 12px;
        }
    </style>
@endpush

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h3 class="mb-1 fw-bold">
                        Daily Team Productivity
                    </h3>

                    <small class="text-muted">
                        Monitor employee productivity, execution and manager verification.
                    </small>
                </div>

                <i class="fas fa-tasks text-primary fs-1"></i>

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
                <table class="table table-bordered table-hover yajra-datatable align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Activities</th>
                            <th>Hours</th>
                            <th>Self Exec</th>
                            <th>Self Score</th>
                            <th>Self Rating</th>
                            <th>Mgr Exec</th>
                            <th>Mgr Score</th>
                            <th>Mgr Rating</th>
                            <th>Variance</th>
                            <th>Match</th>
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
        $(function () {

            var table = $('.yajra-datatable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('manager-view-tasks.index') }}",
                    data: function (d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },

                columns: [
                    { data: 'DT_RowIndex', searchable: false, orderable: false },
                    { data: 'name' },
                    { data: 'activities' },
                    { data: 'hours' },
                    { data: 'self_exec' },
                    { data: 'self_score' },
                    { data: 'self_rating' },
                    { data: 'mgr_exec' },
                    { data: 'mgr_score' },
                    { data: 'mgr_rating' },
                    { data: 'variance' },
                    { data: 'match' }
                ]
            });

            $('#filter').click(function () {
                table.draw();
            });

            $('#reset').click(function () {
                $('#from_date,#to_date').val('');
                table.draw();
            });

        });

    </script>

@endpush