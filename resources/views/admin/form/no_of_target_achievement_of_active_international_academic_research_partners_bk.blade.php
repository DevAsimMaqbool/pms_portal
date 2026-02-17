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
<!-- Tab panes -->
<div class="tab-content">
@if(auth()->user()->hasRole(['HOD']))
<div class="tab-pane fade show active" id="form1" role="tabpanel">
<div class="d-flex justify-content-between">
    <div>
    <h5 class="mb-1">% of target achievement of Active International Academic / Research Partners</h5>
    </div>
    <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_target_achievement_of_active_international_academic_research_partners', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
</div> 
<form id="researchForm" enctype="multipart/form-data" class="row">
@csrf
<input type="hidden" id="form_status" name="form_status" value="HOD" required>
<input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
<div class="row g-6 mt-0">
<div id="grant-details-container">
<div class="grant-group row g-3 mb-3 p-3 border border-primary">

 <div class="col-md-6">
    <label class="form-label">University Name</label>
    <select name="co_author[0][univeristy_name]"
        class="univeristy-dropdown select2 form-select">
        <option value="">Select Univeristy</option>
        @foreach(getUniveristyJson() as $uni)
            <option value="{{ $uni['University Name'] }}">
                {{ $uni['University Name'] }}
            </option>
        @endforeach
    </select>
</div>
<div class="col-md-6">
    <label for="country" class="form-label">Country</label>
    <select name="country" id="country" class="country-dropdown select2 form-select">
        <option value="">Select Country</option>
        @foreach(getAllCountries() as $con)
        <option value="{{ $con['code'] }}">
        {{ $con['name'] }}
        </option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label for="city" class="form-label">City</label>
    <input type="text" name="city" id="city" class="form-control" required>
</div>

<div class="col-md-6">
  <label class="form-label">Signing Authorities</label>
  <input type="text" class="form-control" placeholder="Enter signing authorities">
</div>

<div class="col-md-6">
        <label class="form-label">Duration of Agreement</label>
        <input type="text" class="form-control" placeholder="e.g. 2024 – 2027">
</div>

<div class="col-md-6">
                    <label class="form-label">Outcome Timeline</label>
                    <input type="text" class="form-control" placeholder="Expected completion timeline">
</div>


<div class="col-md-6">
       <label class="form-label">Collaboration Scope</label>
       <textarea class="form-control" rows="2" placeholder="Research, Exchange Program, Joint Degree etc."></textarea>
</div>

<div class="col-md-6">
   <label class="form-label">Contact Details (Point of Communication)</label>
   <textarea class="form-control" rows="2" placeholder="Name, Email, Phone"></textarea>
</div>

<div class="col-md-6">
   <label class="form-label">Projects / Activities Planned</label>
    <textarea class="form-control" rows="3" placeholder="Describe planned activities"></textarea>
</div>

</div>
</div>
</div>
<div class="mt-3 text-end" style="margin-left: -16px !important;">
<button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
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
@endpush
@push('script')
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            $(document).ready(function () {

                $('#researchForm').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);
                    // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('international-research-partners.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            form.find('.invalid-feedback').remove();
                            form.find('.is-invalid').removeClass('is-invalid');
                            $('.select2').val(null).trigger('change');
                            // Remove all extra grant groups and keep only the first one
                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;
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

                            } else if (xhr.status === 409) {
                                // 🔥 Duplicate record message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Duplicate Entry',
                                    text: xhr.responseJSON.message
                                });

                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                            }
                        }
                    });
                });

            });
        </script>
    @endif
@endpush