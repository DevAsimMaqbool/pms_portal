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
                 @if(auth()->user()->hasRole(['HOD']))
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Intellectual Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Research Target Setting</a>
                        </li>
                    </ul>
                @endif

                <!-- Tab panes -->
                <div class="tab-content">
                    {{-- ================= FORM 1 ================= --}}
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                                    <form id="researchForm1" enctype="multipart/form-data"class="row">
                                        @csrf
                                        <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                        <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                        <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                        <input type="hidden"  id="form_status" name="form_status" value="RESEARCHER" required>
                                        
                                        <div class="row g-6">
                                            <div class="col-md-6">
                                                <label for="no_of_ip_disclosed" class="form-label">No of IP disclosed</label>
                                                <input type="text" id="no_of_ip_disclosed" name="no_of_ip_disclosed" class="form-control" >
                                            </div>

                                            <div class="col-md-6">
                                                <label for="no_of_ip_filed" class="form-label">No of IP filled</label>
                                                <input type="text" id="no_of_ip_filed" name="no_of_ip_filed" class="form-control" >
                                            </div>

                                            <div class="col-md-6">
                                                <label for="name_of_ip_filed" class="form-label">Name of IP filled</label>
                                                <input type="text" id="name_of_ip_filed" name="name_of_ip_filed" class="form-control" >
                                            </div>

                                        
                                        </div>
                                        <div class="col-4 text-center demo-vertical-spacing">
                                            <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                        </div>
                                    </form>
                        </div>
                    @endif
                      {{-- ================= FORM 2 ================= --}}
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade" id="form2" role="tabpanel">
                                   <form id="researchForm2" enctype="multipart/form-data"class="row">
                                        @csrf
                                        <input type="hidden" id="kpa_id" name="kpa_id" value="{{ $areaId }}">
                                        <input type="hidden" id="sp_category_id" name="sp_category_id" value="{{ $categoryId }}">
                                        <input type="hidden"  id="indicator_id" name="indicator_id" value="{{ $indicatorId }}">
                                        <input type="hidden"  id="form_status" name="form_status" value="HOD" required>
                                        
                                        <div class="row g-6">
                                            <div class="col-md-6">
                                                <label for="target_of_ip_disclosures" class="form-label">Target of ip disclosures</label>
                                                <input type="text" id="target_of_ip_disclosures" name="target_of_ip_disclosures" class="form-control" >
                                            </div>

                                            <div class="col-md-6">
                                                <label for="target_of_ip_filed" class="form-label">Target of ip filled</label>
                                                <input type="text" id="target_of_ip_filed" name="target_of_ip_filed" class="form-control" >
                                            </div>

                                        
                                        </div>
                                        <div class="col-4 text-center demo-vertical-spacing">
                                            <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                                        </div>
                                    </form>
                        </div>
                    @endif
                </div>
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

        // Extra fields for Form 1

        $('#researchForm1').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('intellectual-properties.store') }}",
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
    @if(auth()->user()->hasRole(['HOD']))
    <script>
    $(document).ready(function () {

        // Extra fields for Form 2
         $('#researchForm2').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('intellectual-properties.store') }}",
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
