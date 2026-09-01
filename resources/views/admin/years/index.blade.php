@extends('layouts.app')
@push('style')

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
@endpush
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">Years</h4>

            <button type="button"
                    class="btn btn-primary"
                    id="addYearBtn">
                <i class="fa fa-plus"></i>
                Add Year
            </button>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped"
                   id="yearsTable">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($years as $key => $year)

                        <tr id="yearRow{{ $year->id }}">

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $year->year }}</td>

                            <td>

                                @if($year->active)

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </td>
                            <td>

                                 @if($year->active)
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch" disabled
                                            checked
                                        >
                                    </div>
                                @else
                                     <div class="form-check form-switch">
                                        <input
                                            class="form-check-input yearStatus"
                                            type="checkbox"
                                            role="switch"
                                            data-id="{{ $year->id }}"
                                            
                                        >
                                    </div>
                                @endif
                            </td>

                            <td>

                                <button type="button"
                                        class="btn btn-icon editYear"
                                        data-id="{{ $year->id }}">
                                    <i class="icon-base ti tabler-edit icon-md"></i>
                                </button>


                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Add/Edit Modal --}}

<div class="modal fade"
     id="yearModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="yearForm">

                @csrf

                <input type="hidden"
                       id="year_id"
                       name="year_id">

                <div class="modal-header">

                    <h5 class="modal-title"
                        id="yearModalTitle">
                        Add Year
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Year
                        </label>

                        <input type="number"
                               name="year"
                               id="year"
                               class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>


                   

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="saveYearBtn">
                        Save
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
@push('script')

<script>

$(document).ready(function () {

    let modal = new bootstrap.Modal(
        document.getElementById('yearModal')
    );


    // ==========================
    // Add
    // ==========================

    $('#addYearBtn').click(function () {
        $('#yearForm')[0].reset();

        $('#year_id').val('');

        $('#yearModalTitle').text('Add Year');

        $('.is-invalid').removeClass('is-invalid');

        $('.invalid-feedback').text('');

        modal.show();

    });


    // ==========================
    // Store / Update
    // ==========================

    $('#yearForm').submit(function (e) {

        e.preventDefault();

        let id = $('#year_id').val();

        let url = id
            ? "{{ url('years-data') }}/" + id
            : "{{ route('years-data.store') }}";

        let method = id ? 'PUT' : 'POST';

        let formData = {
            _token: "{{ csrf_token() }}",
            _method: method,
            year: $('#year').val()
        };

        $('.is-invalid').removeClass('is-invalid');

        $('.invalid-feedback').text('');

        $.ajax({

            url: url,

            type: 'POST',

            data: formData,

            success: function (response) {

                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {

                    location.reload();

                });

            },

            error: function (xhr) {

                if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {

                        let input = $('#' + field);

                        input.addClass('is-invalid');

                        input.next('.invalid-feedback')
                             .text(messages[0]);

                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong.'
                    });

                }

            }

        });

    });


    // ==========================
    // Edit
    // ==========================

    $(document).on('click', '.editYear', function () {

        let id = $(this).data('id');

        $.ajax({

            url: "{{ url('years-data') }}/" + id + "/edit",

            type: 'GET',

            success: function (response) {

                let year = response.data;

                $('#year_id').val(year.id);

                $('#year').val(year.year);

                //$('#active').val(year.active ? 1 : 0);

                $('#yearModalTitle').text('Edit Year');

                $('.is-invalid').removeClass('is-invalid');

                $('.invalid-feedback').text('');

                modal.show();

            }

        });

    });


    // ==========================
    // Delete
    // ==========================

    $(document).on('change', '.yearStatus', function () {

    let checkbox = $(this);
    let id = checkbox.data('id');

    let active = checkbox.is(':checked') ? 1 : 0;

    $.ajax({

        url: "{{ url('years') }}/" + id + "/status",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            active: active
        },

        success: function (response) {

            let label = checkbox
                .closest('.form-check')
                .find('.statusLabel');

            if (response.active) {
                label.text('Active');
            } else {
                label.text('Inactive');
            }


            Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => {

                    location.reload();

                });
        },

        error: function (xhr) {

            // Revert checkbox if update failed
            checkbox.prop('checked', !active);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message ?? 'Unable to update status.'
            });
            
        }

    });

});

    

});

</script>

@endpush