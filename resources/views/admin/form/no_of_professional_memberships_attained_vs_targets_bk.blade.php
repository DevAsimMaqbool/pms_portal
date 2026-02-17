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
    <h5 class="mb-1">No of Professional Memberships attained vs targets</h5>
    </div>
    <a href="{{ route('indicators_crud.index', ['slug' => 'no_of_professional_memberships_attained_vs_targets', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
</div> 
<form id="researchForm" enctype="multipart/form-data" class="row">
@csrf
<input type="hidden" id="form_status" name="form_status" value="HOD" required>
<input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
<div class="row g-6 mt-0">
<div id="grant-details-container">
<div class="grant-group row g-3 mb-3 p-3 border border-primary">
<div class="col-md-6">
<label for="type_of_membership" class="form-label">Type of Membership</label>
<select name="type_of_membership" id="type_of_membership" class="select2 form-select faculty-member"
required>
<option value="">-- Select Type --</option>
<option value="individual_faculty">Individual Faculty</option>
<option value="institutional">Institutional</option>
</select>
</div>

<div class="col-md-6">
<label for="name_of_professional_body" class="form-label">Name of Professional
Body</label>
<input type="text" name="name_of_professional_body" id="name_of_professional_body" class="form-control"
required>
</div>

<div class="col-md-6">
<label for="category_of_body" class="form-label">Category of Body</label>
<select name="category_of_body" id="category_of_body" class="select2 form-select faculty-member"
required>
<option value="">-- Select Program --</option>
<option value="academic">Academic</option>
<option value="professional">Professional</option>
<option value="accreditation">Accreditation</option>
<option value="research">Research</option>
</select>
</div>

<div class="col-md-6">
<label for="discipline" class="form-label">Discipline / Area</label>
<select name="discipline" id="discipline" class="select2 form-select faculty-member" required>
<option value="">-- Select Level --</option>
<option value="business_management">Business & Management</option>
<option value="economics_finance">Economics & Finance</option>
<option value="accounting_auditing">Accounting & Auditing</option>
<option value="engineering">Engineering</option>
<option value="computer_science_it">Computer Science & Information
Technology</option>
<option value="ai_data_science">Artificial Intelligence & Data Science
</option>
<option value="natural_applied_sciences">Natural & Applied Sciences</option>
<option value="social_sciences">Social Sciences</option>
<option value="law_legal_studies">Law & Legal Studies</option>
<option value="education">Education</option>
<option value="health_life_sciences">Health & Life Sciences</option>
<option value="arts_humanities">Arts & Humanities</option>
<option value="islamic_studies_finance">Islamic Studies & Islamic Finance
</option>
<option value="media_communication_studies">Media & Communication Studies
</option>
<option value="environment_sustainability_studies">Environmental &
Sustainability Studies</option>
<option value="public_policy_governance">Public Policy & Governance</option>
<option value="research_development">Research & Development</option>
<option value="quality_assurance_accreditation">Quality Assurance &
Accreditation</option>
<option value="innovation_entrepreneurship">Innovation & Entrepreneurship
</option>
<option value="interdisciplinary_studies">Interdisciplinary Studies</option>
</select>
</div>

<div class="col-md-6">
<label for="level" class="form-label">Level</label>
<select name="level" id="level" class="select2 form-select faculty-member" required>
<option value="">-- Select Level--</option>
<option value="national">National</option>
<option value="international">International</option>
</select>
</div>

<div class="col-md-6">
<label for="country" class="form-label">Country (If International)</label>
<select name="country" id="country"
class="country-dropdown select2 form-select">
<option value="">Select Country</option>
@foreach(getAllCountries() as $con)
<option value="{{ $con['code'] }}">
{{ $con['name'] }}
</option>
@endforeach
</select>
</div>

<div class="col-md-6">
<label for="membership_status" class="form-label">Membership Status</label>
<select name="membership_status" id="membership_status" class="select2 form-select faculty-member" required>
<option value="">-- Select Scope --</option>
<option value="new">New</option>
<option value="renewed">Renewed</option>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Membership Start Date</label>
<input type="date" name="membership_start_date" id="membership_start_date" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Membership Valid Until</label>
<input type="date" name="membership_valid_until" id="membership_valid_until" class="form-control" required>
</div>

<div class="col-md-6">
<label class="fw-medium d-block form-label">Evidence Type</label>
<div class="form-check form-check-inline mt-4">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="certificate" checked>
<label for="certificate">Certificate</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="email_confirmation">
<label for="email_confirmation">Email Confirmation</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="invoice">
<label for="invoice">Invoice</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="checkbox" id="evidence_type" name="evidence_type[]" value="mou">
<label for="mou">MOU</label>
</div>
</div>

<div class="col-md-12">
<label class="form-label d-block">Upload Supporting Document</label>
<div>
<input class="form-control" name="document_link" type="file" id="document_link">
</div>
</div>

<div class="col-12 mt-4">
<h6>Declaration</h6>
<div class="form-check">
<input class="form-check-input" type="checkbox" name="declaration"  id="declaration"  value="1">
<label class="form-check-label">I confirm that the information provided is accurate and supported by valid evidence.</label>
</div>
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
                        url: "{{ route('professional-membership.store') }}",
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