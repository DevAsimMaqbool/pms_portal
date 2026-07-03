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
                <table class="table table-bordered table-hover yajra-datatable align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th class="bg-primary text-white">Activities</th>
                            <th class="bg-info text-white">Hours</th>
                            <th class="bg-warning text-dark">Self Exec %</th>
                            <th class="bg-success text-white">Self Score %</th>
                            <th class="bg-success text-white">Self Rating %</th>
                            <th class="bg-warning text-dark">Mgr Exec %</th>
                            <th class="bg-danger text-white">Mgr Score %</th>
                            <th class="bg-danger text-white">Mgr Rating %</th>
                            <th class="bg-secondary text-white">Variance %</th>
                            <th class="bg-dark text-white">Match</th>
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