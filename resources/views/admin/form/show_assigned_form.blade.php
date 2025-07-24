@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Your Assigned Forms</h5>
            </div>
            <br>
            <div class="card-body">
                <div class="mb-3">
                    <label for="assignedFormSelect">Select Form:</label>
                    <select id="assignedFormSelect" class="form-select select2">
                        <option value="">-- Select a form --</option>
                        @foreach($forms as $form)
                            <option value="{{ $form->title }}">
                                {{ $form->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="formContainer" style="display: none;"></div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#assignedFormSelect').select2({
                placeholder: "Select a form",
                allowClear: true,
                width: '100%'
            });

            $('#assignedFormSelect').on('change', function () {
                let formTitle = $(this).val();
                let userId = 1318; // Replace with dynamic user ID if needed

                if (formTitle) {
                    let url = `/assigned-forms/view/${userId}/${formTitle}`;

                    $('#formContainer')
                        .hide()
                        .html('<p>Loading form...</p>')
                        .fadeIn();

                    $.get(url, function (data) {
                        $('#formContainer').hide().html(data).fadeIn();
                    }).fail(function () {
                        $('#formContainer').html('<p class="text-danger">Failed to load form.</p>');
                    });
                } else {
                    $('#formContainer').fadeOut().empty();
                }
            });
        });
    </script>
@endpush