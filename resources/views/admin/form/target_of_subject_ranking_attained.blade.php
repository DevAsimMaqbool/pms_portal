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
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
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
<h5 class="mb-1">Target of Subject Ranking attained (if applicable)</h5>
<form id="researchForm" enctype="multipart/form-data" class="row">
@csrf
<input type="hidden" id="form_status" name="form_status" value="HOD" required>
<input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
<div class="row g-6 mt-0">
<div id="grant-details-container">
<div class="grant-group row g-3 mb-3 p-3 border border-primary">
<div class="col-md-6">
<label for="academic_year" class="form-label">Academic Year</label>
<select name="academic_year" class="select2 form-select faculty-member"
required>
<option value="">-- Select Year --</option>
<option value="2024-25">2024-25</option>
<option value="2023-24">2023-24</option>
<option value="2022-23">2022-23</option>
<option value="2021-22">2021-22</option>
<option value="2020-21">2020-21</option>
<option value="2019-20">2019-20</option>
</select>
</div>

<div class="col-md-6">
<label for="faculty_id" class="form-label">Faculty / School</label>
<select name="faculty_id" class="select2 form-select faculty-member" required>
<option value="">-- Select Faculty --</option>
<option value="cs">CS</option>
<option value="it">IT</option>
<option value="se">SE</option>
</select>
</div>

<div class="col-md-6">
<label for="department" class="form-label">Department</label>
<select name="department_id" class="select2 form-select faculty-member"
required>
<option value="">-- Select Level --</option>
<option value="cs">CS</option>
<option value="it">IT</option>
<option value="se">SE</option>
</select>
</div>

<div class="col-md-6">
<label for="subject_id" class="form-label">Subject Name</label>
<select name="subject_id" class="select2 form-select faculty-member" required>
<option value="">-- Select Subject--</option>
<option value="subject1">Subject1</option>
<option value="subject2">Subject2</option>
</select>
</div>

<div class="col-md-6">
<label for="ranking_body" class="form-label">Ranking Body</label>
<select name="ranking_body" class="select2 form-select">
<option value="">-- Select Ranking--</option>
<option value="qs_world">QS World University Rankings</option>
<option value="the">Times Higher Education (THE)</option>
<option value="arwu">Academic Ranking of World Universities (ARWU)</option>
<option value="us_news">U.S. News & World Report</option>
<option value="webometrics">Webometrics Ranking of World Universities</option>
<option value="cwts_leiden">CWTS Leiden Ranking</option>
<option value="scimago">SCImago Institutions Rankings</option>
<option value="round_university">Round University Ranking</option>
<option value="unirank">UniRank</option>
<option value="qs_asia">QS Asia University Rankings</option>
<option value="qs_arab">QS Arab Region University Rankings</option>
<option value="the_asia">THE Asia University Rankings</option>
<option value="the_emerging">THE Emerging Economies Rankings</option>
</select>
</div>

<div class="col-md-6">
<label for="targeted_ranking_range" class="form-label">Targeted Ranking Range</label>
<input type="number" name="targeted_ranking_range" class="form-control" required>
</div>

<div class="col-md-6">
<label for="actual_ranking_achieved" class="form-label">Actual Ranking Achieved</label>
<select name="actual_ranking_achieved" class="select2 form-select faculty-member" required>
<option value="">-- Select Subject--</option>
<option value="numeric">Numeric</option>
<option value="not_ranked">Not Ranked</option>
</select>
</div>

<div class="col-md-6">
<label for="ranking_status" class="form-label">Ranking Status</label>
<select name="ranking_status" class="select2 form-select faculty-member" required>
<option value="">-- Select Subject--</option>
<option value="achieved">Achieved</option>
<option value="partially_achieved">Partially Achieved</option>
<option value="not_achieved">Not Achieved</option>
</select>
</div>

<div class="col-md-12">
<label class="form-label d-block">Evidence Upload</label>
<div>
<input class="form-control" name="evidence_upload" type="file" id="formFile">
</div>
</div>
<div class="col-md-12">
<label class="form-label d-block">Remarks</label>
<div>
<textarea class="form-control" id="TitleOfActivity"
name="remarks"
rows="4"></textarea>
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
<script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
@endpush
@push('script')
<script>

document.addEventListener("DOMContentLoaded", function () {

// SVG stars
const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

// Employer Rating
const employerRaty = new Raty(document.getElementById("employerRating"), {
number: 5,
half: true,
starOn: starOn,
starHalf: starHalf,
starOff: starOff,
click: function (score) {
document.getElementById("employer_satisfaction").value = score;
}
}).init();

// Graduate Rating
const graduateRaty = new Raty(document.getElementById("graduateRating"), {
number: 5,
half: true,
starOn: starOn,
starHalf: starHalf,
starOff: starOff,
click: function (score) {
document.getElementById("graduate_satisfaction").value = score;
}
}).init();

});




</script>
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
url: "{{ route('employability.store') }}",
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

document.getElementById("employer_satisfaction").value = "";
document.getElementById("graduate_satisfaction").value = "";

// Reset stars
employerRaty.setScore(0);
graduateRaty.setScore(0);
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