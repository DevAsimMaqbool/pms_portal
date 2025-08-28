@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                <h6>International co-Authored Papers</h6>
                <form id="researchForm1" enctype="multipart/form-data" class="row">
                    @csrf
                    <input type="hidden" name="kpa_id" value="{{ $areaId }}">
                    <input type="hidden" name="sp_category_id" value="{{ $categoryId }}">
                    <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                    <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER">

                    <div class="row">
                        <div id="author-past-container">
                            <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded" >
                                <div class="col-md-4">
                                    <label for="name_of_coauthers" class="form-label">Names of co-authers</label>
                                    <input type="text" name="papers[0][name_of_co_authers]" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Author Rank</label>
                                    <input type="text" name="papers[0][author_rank]" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Name of University & Country</label>
                                    <input type="text" name="papers[0][name_of_university_country]" class="form-control">
                                </div>
                                <div class="col-md-4">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" id="designation" class="form-control" name="papers[0][designation]">
                                 </div>
                                 <div class="col-md-4">
                                    <label class="form-label">No of papers co-authored with this person in the past</label>
                                    <input type="text" name="papers[0][no_of_papers_past]" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" id="add-coauthor"><i
                                    class="icon-base ti tabler-plus me-1"></i> <span
                                    class="align-middle">Add</span></button>
                        </div>

                    </div>
                    <div class="col-4 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>
                </form>
                 @endif
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
@endpush
@push('script')
@if(auth()->user()->hasRole(['HOD','Teacher']))
    <script>
        $(document).ready(function () {
            let pastIndex = 1;

            // Add new author group
            $('#add-coauthor').click(function () {
                let newGroup = `
    <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

    <div class="col-md-4">

    <label for="name_of_coauthers" class="form-label">Names of co-authers</label>
    <input type="text" name="papers[${pastIndex}][name_of_co_authers]" class="form-control">
    </div>
    <div class="col-md-4">
    <label class="form-label">Author Rank</label>
    <input type="text" name="papers[${pastIndex}][author_rank]" class="form-control" >
    </div>

    <div class="col-md-4">
    <label class="form-label">Name of University & Country</label>
    <input type="text" name="papers[${pastIndex}][name_of_university_country]" class="form-control">
    </div>
    <div class="col-md-4">
    <label for="designation" class="form-label">Designation</label>
    <input type="text" id="designation" class="form-control" name="papers[${pastIndex}][designation]">
    </div>
     <div class="col-md-4">
    <label class="form-label">No of papers co-authored with this person in the past</label>
    <input type="text" name="papers[${pastIndex}][no_of_papers_past]" class="form-control">
    </div>
    <div class="col-md-2 d-flex align-items-end">
    <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-past"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
    </div>
    </div>`;

                $('#author-past-container').append(newGroup);
                pastIndex++;
            });

            // Remove a past group
            $(document).on('click', '.remove-past', function () {
                $(this).closest('.past-group').remove();
            });
   $('#researchForm1').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('international-Coauthored-Paper.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response)
                    Swal.close();
                    Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                    form[0].reset();
                },
                error: function (xhr) {
                    Swal.close();
                     // Clear previous errors before showing new ones
                        form.find('.invalid-feedback').remove();
                        form.find('.is-invalid').removeClass('is-invalid');
                     if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop through all validation errors
                            $.each(errors, function (field, messages) {
                                 let fieldName = field.replace(/\.(\d+)\./g, '[$1][').replace(/\./g, '][') + ']';
                                fieldName = fieldName.replace('[]]', ']');
                                let input = form.find('[name="' + fieldName + '"]');

                                if (input.length) {
                                    input.addClass('is-invalid');

                                    // Show error message under input
                                    input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                }
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });

});
    </script>
@endif
@endpush