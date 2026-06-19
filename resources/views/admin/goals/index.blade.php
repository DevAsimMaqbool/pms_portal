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

            <h4>Goals</h4>

            <a href="{{ route('goals.create') }}"
               class="btn btn-primary">
                Add Goal
            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered" id="goalTable">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Goal Name</th>
                        <th>Goal Code</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Action</th>
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

    $('#goalTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('goals.index') }}",

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },

            {
                data: 'goal_name',
                name: 'goal_name'
            },

            {
                data: 'goal_cod',
                name: 'goal_cod'
            },

            {
                data: 'driver_name',
                name: 'driver.driver_name'
            },

            {
                data: 'status',
                name: 'status'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

});

$(document).on('click','.deleteGoal',function(){

    let id = $(this).data('id');

    if(confirm('Are you sure?')){

        $.ajax({

            url: '/goals/' + id,
            type: 'DELETE',

            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function(){

                $('#goalTable').DataTable().ajax.reload();
            }
        });
    }
});

</script>

@endpush