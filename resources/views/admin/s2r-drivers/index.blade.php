@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endpush

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">S2R Drivers</h4>

            <button class="btn btn-primary" id="addDriver">
                Add Driver
            </button>

        </div>

        <div class="card-body">

            <table class="table table-bordered" id="driverTable">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Driver Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="driverModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="driverForm">

                @csrf

                <input type="hidden" id="driver_id">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Driver
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Driver Name
                        </label>

                        <input type="text"
                            id="driver_name"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select id="status"
                            class="form-select">

                            <option value="Active">
                                Active
                            </option>

                            <option value="Inactive">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-label-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                        class="btn btn-primary">
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('script')

<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

<script>
$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let modal = new bootstrap.Modal(
        document.getElementById('driverModal')
    );

    let table = $('#driverTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('s2r-drivers.list') }}",

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false},
            {data: 'driver_name', name: 'driver_name'},
            {data: 'slug', name: 'slug'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

    // Add

    $('#addDriver').click(function () {

        $('#driverForm')[0].reset();

        $('#driver_id').val('');

        $('.modal-title').text('Add Driver');

        modal.show();
    });

    // Save

    $('#driverForm').submit(function(e){

        e.preventDefault();

        let id = $('#driver_id').val();

        let url = id
            ? "{{ url('s2r-drivers') }}/" + id
            : "{{ route('s2r-drivers.store') }}";

        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: 'POST', // 🔥 ALWAYS POST

            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: method, // 🔥 THIS IS REQUIRED
                driver_name: $('#driver_name').val(),
                status: $('#status').val()
            },

            success: function(response){

                modal.hide();
                table.ajax.reload();

                Swal.fire({
                    icon:'success',
                    title:'Success',
                    text:response.message
                });

            },

            error: function(xhr){

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;
                    let message = '';

                    $.each(errors, function(key, value){
                        message += value[0] + '<br>';
                    });

                    Swal.fire({
                        icon:'error',
                        title:'Validation Error',
                        html:message
                    });

                }else{

                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text:xhr.responseJSON?.message ?? 'Server Error'
                    });
                }
            }
        });

    });

    // Edit

    $(document).on('click','.editBtn',function(){

        let id = $(this).data('id');

        $.ajax({

            url: "{{ url('s2r-drivers') }}/" + id,
            type: 'GET',

            success:function(response){

                let data = response.data;

                $('#driver_id').val(data.id);
                $('#driver_name').val(data.driver_name);
                $('#status').val(data.status);

                $('.modal-title').text('Edit Driver');

                modal.show();
            }
        });

    });

    // Delete

    $(document).on('click','.deleteBtn',function(){

        let id = $(this).data('id');

        Swal.fire({

            title: 'Are you sure?',
            text: 'This record will be deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes Delete'

        }).then((result) => {

            if(result.isConfirmed){

                $.ajax({

                    url: "{{ url('s2r-drivers') }}/" + id,
                    type: 'DELETE',

                    success:function(response){

                        table.ajax.reload();

                        Swal.fire({
                            icon:'success',
                            title:'Deleted',
                            text:response.message
                        });
                    },

                    error:function(xhr){

                        Swal.fire({
                            icon:'error',
                            title:'Error',
                            text:xhr.responseJSON.message
                        });
                    }

                });
            }
        });
    });

});
</script>

@endpush