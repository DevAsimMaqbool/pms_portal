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

                <h4>Goal Assignments</h4>

                <a href="{{ route('goals-assign.create') }}" class="btn btn-primary">
                    Assign Goal
                </a>

            </div>

            <div class="card-body">

                <table class="table table-bordered yajra-datatable">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Goal</th>
                            <th>KPA</th>
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

           let table = $('.yajra-datatable').DataTable({
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
                        data: 'goal',
                        name: 'goal'
                    },
                    {
                        data: 'kpa',
                        name: 'kpa'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

          $(document).on('click', '.deleteBtn', function () {

    let url = $(this).data('url');

    if(confirm('Are you sure?')){

        $.ajax({

            url: url,

            type: "DELETE",

            data:{
                _token:"{{ csrf_token() }}"
            },

            success:function(response){

                alert(response.message);

                table.ajax.reload();

            }

        });

    }

});

        });

    </script>
    

@endpush