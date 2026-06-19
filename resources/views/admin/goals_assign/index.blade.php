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
        <div class="card-header">
            <h4>Goal Assignments</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered yajra-datatable">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role</th>
                        <th>KPA</th>
                        <th>Dimension</th>
                        <th>Target</th>
                        <th>Weight</th>
                        <th>KPIs</th>
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
$(function () {

    $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('goals-assign.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },

            {
                data: 'role',
                name: 'role'
            },

            {
                data: 'kpa',
                name: 'kpa'
            },

            {
                data: 'dimension',
                name: 'dimension'
            },

            {
                data: 'target',
                name: 'target'
            },

            {
                data: 'weight',
                name: 'weight'
            },

            {
                data: 'kpis',
                name: 'kpis'
            },

            {
                data: 'status',
                name: 'status'
            }
        ]
    });

});

</script>

@endpush