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

                <h4>Daily Team Productivity Dashboard</h4>

            </div>

            <div class="card-body">
                <div class="row mb-3">

                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" id="from_date" class="form-control" value="{{ now()->toDateString() }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" id="to_date" class="form-control" value="{{ now()->toDateString() }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary w-100">
                            <i class="fa fa-search"></i> Filter
                        </button>
                    </div>
                </div>
                <table class="table table-bordered table-hover text-center summaryTable">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Employee</th>

                            <th class="bg-primary">Days Logged</th>

                            <th class="bg-success">Days Verified</th>

                            <th class="bg-info">Verification Coverage</th>

                            <th class="bg-warning text-dark">Avg Self %</th>

                            <th class="bg-danger">Avg Mgr %</th>

                            <th class="bg-secondary">Score Variance</th>

                            <th class="bg-success">Days Aligned</th>

                            <th class="bg-danger">Days Mismatch</th>

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