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
                <form id="researchForm" enctype="multipart/form-data"class="row">
                    @csrf
                    <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                    <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                    <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                    <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                    
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="ket_target" class="form-label">KET Target</label>
                            <input type="text" id="ket_target" name="ket_target" class="form-control" >
                        </div>
                       
                        <div class="col-md-6">
                            <label for="target_of_ken_Knowledge_products" class="form-label">Target of KEN Knowledge products</label>
                            <input type="text" id="target_of_ken_Knowledge_products" name="target_of_ken_Knowledge_products" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="event_proposal_forms_submission" class="form-label">Event proposal forms submission</label>
                            <input type="text" id="event_proposal_forms_submission" name="event_proposal_forms_submission" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_knowledge_products_produced" class="form-label">No of knowledge products produced</label>
                            <input type="text" id="no_of_knowledge_products_produced" name="no_of_knowledge_products_produced" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_participants" class="form-label">No of participants</label>
                            <input type="text" id="no_of_participants" name="no_of_participants" class="form-control" >
                        </div>

                         <div class="col-md-6">
                            <label for="no_of_participants_from_the_industry" class="form-label">No of participants from the industry</label>
                            <input type="text" id="no_of_participants_from_the_industry" name="no_of_participants_from_the_industry" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_participants_from_the_public_sector" class="form-label">No of participants from the public sector</label>
                            <input type="text" id="no_of_participants_from_the_public_sector" name="no_of_participants_from_the_public_sector" class="form-control" >
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
     @if(auth()->user()->hasRole(['HOD','Teacher']))
    <script>
    $(document).ready(function () {


        $('#researchForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('trainings-seminars-workshops'.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
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
                                let input = form.find('[name="' + field + '"]');

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
