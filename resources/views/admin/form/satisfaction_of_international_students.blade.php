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
@if(auth()->user()->hasRole(['HOD']))
<!-- Nav tabs -->
<ul class="nav nav-tabs mb-3" role="tablist">
<li class="nav-item">
<a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab">Satisfaction of International Students</a>
</li>
<li class="nav-item">
<a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Table</a>
</li>
</ul>
@endif
<div class="tab-content">
@if(auth()->user()->hasRole(['HOD']))
<div class="tab-pane fade show active" id="form1" role="tabpanel">
<form id="indicator1Form" enctype="multipart/form-data" class="row">
@csrf
<input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
<input type="hidden" name="form_status" value="HOD">

<div id="student-satisfaction-container">
<div class="student-group row g-3 mb-3 border p-3 mt-3 rounded">
<div class="col-md-4">
<label class="form-label">Student Name</label>
<input type="text" name="student_name" class="form-control" placeholder="Enter Name">
</div>

<div class="col-md-4">
<label class="form-label">Student Roll No.</label>
<input type="text" name="student_roll_no" class="form-control" placeholder="Enter Roll No">
</div>

<div class="col-md-4">
<label class="form-label">Program / Faculty</label>
<input type="text" name="student_program" class="form-control"
placeholder="Program Name">
</div>

<div class="col-md-4">
<label class="form-label">Country of Origin</label>
<input type="text" name="student_country" class="form-control" placeholder="Country">
</div>

<div class="col-md-4">
<label class="form-label">Semester / Year</label>
<input type="text" name="student_semester" class="form-control"
placeholder="e.g., Fall 2025">
</div>

<div class="col-md-4">
<label class="fw-bold mb-2 d-block">Rating</label>
<div id="ratingBox" class="half-star-ratings raty" data-half="true" data-number="5">
</div>

<input type="hidden" name="student_rating" id="student_rating" value="">
</div>

<div class="col-md-12">
<label class="form-label">Comments / Suggestions</label>
<textarea name="student_comments" class="form-control" rows="2"
placeholder="Optional"></textarea>
</div>
</div>
</div>

<div class="text-end">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
@endif
@if(auth()->user()->hasRole(['Dean', 'HOD', 'ORIC']))
<div class="tab-pane fade show {{ auth()->user()->hasRole(['Dean', 'ORIC']) ? 'active' : '' }}"
id="form2" role="tabpanel">
<table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
<thead>
<tr>
<th>#</th>
<th>Student Name</th>
<th>Program / Faculty</th>
<th>Country</th>
<th>Semester / Year</th>
<th>Rating</th>
<th>Comments</th>
<th>Actions</th>
</tr>
</thead>
</table>
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
@if(auth()->user()->hasRole(['HOD']))
<script>
$(document).ready(function () {
$('#researchForm1').on('submit', function (e) {
e.preventDefault();
let form = $(this);
let formData = new FormData(this);

$.ajax({
url: "{{ route('international-st-satisfaction.store') }}",
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
Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
}
}
});
});

});
</script>
@endif
@if(auth()->user()->hasRole(['Dean', 'HOD', 'ORIC']))
<script>
window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
</script>
<script>
function fetchIndicatorForms() {
$.ajax({
url: "{{ route('international-Coauthored-Paper.index') }}",
method: "GET",
data: {
status: "RESEARCHER" // you can send more values
},
dataType: "json",
success: function (data) {
//alert(data.forms);
const forms = data.forms || [];

const rowData = forms.map((form, i) => {
const createdAt = form.created_at
? new Date(form.created_at).toISOString().split('T')[0]
: 'N/A';

// Pass entire form as JSON in button's data attribute
return [
`<input type="checkbox" class="rowCheckbox" value="${form.id}">`,
i + 1,
form.creator ? form.creator.name : 'N/A',
form.name_of_co_authers || 'N/A',
form.author_rank || 'N/A',
createdAt,
`<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn" data-form='${JSON.stringify(form)}'><span class="icon-xs icon-base ti tabler-eye me-2"></span>View</button>`
];
});

if (!$.fn.DataTable.isDataTable('#complaintTable2')) {
$('#complaintTable2').DataTable({
data: rowData,
columns: [
{ title: "<input type='checkbox' id='selectAll'>" },
{ title: "#" },
{ title: "Student Name" },
{ title: "Program / Faculty" },
{ title: "Country" },
{ title: "Semester / Year" },
{ title: "Rating" },
{ title: "Comments" },
{ title: "Actions" }
]
});
} else {
$('#complaintTable2').DataTable().clear().rows.add(rowData).draw();
}
},
error: function (xhr) {
console.error('Error fetching data:', xhr.responseText);
alert('Unable to load data.');
}
});
}
$(document).ready(function () {

fetchIndicatorForms();
// Handle click on View button
$(document).on('click', '.view-form-btn', function () {
const form = $(this).data('form');
$('#modalExtraFields').find('.optional-field').remove();

$('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
$('#modalCoAuthers').text(form.name_of_co_authers || 'N/A');
$('#modalAuthorRank').text(form.author_rank || 'N/A');
$('#modalStatus').text(form.status || 'Pending');
$('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');

if (window.currentUserRole === 'HOD') {
let statusLabel = "Review";
if (form.form_status == 'RESEARCHER') {
$('#approveCheckbox').prop('checked', form.status == 2);
$('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
// Label text for HOD
if (form.status == 1) {
statusLabel = "Verified";
} else if (form.status == 2) {
statusLabel = "Verified";
}
}

$('label[for="approveCheckbox"]').text(statusLabel);
}
else if (window.currentUserRole === 'Dean') {
let statusLabel = "Review";
if (form.form_status == 'RESEARCHER') {
$('#approveCheckbox').closest('.form-check-input').show();
$('#approveCheckbox').prop('checked', form.status == 3);
$('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
// Label text for HOD
if (form.status == 2) {
statusLabel = "Review";
} else if (form.status == 3) {
statusLabel = "Review";
}
}

$('label[for="approveCheckbox"]').text(statusLabel);
} else if (window.currentUserRole === 'ORIC') {

$('#approveCheckbox').prop('checked', form.status == 4);
$('#approveCheckbox').data('id', form.id);
let statusLabel = "Pending";
if (form.status == 1) {
statusLabel = "Verified";
} else if (form.status == 3) {
statusLabel = "Verified";
} else if (form.status == 4) {
statusLabel = "Verified";
}
$('label[for="approveCheckbox"]').text(statusLabel);
} else {
$('#approveCheckbox').closest('.form-check-input').hide();

let statusLabel = "Pending"; // default
if (form.status == 1) {
statusLabel = "Not Verified";
} else if (form.status == 2) {
statusLabel = "Verified";
} else if (form.status == 3) {
statusLabel = "Approved";
}

// update the label text
$('label[for="approveCheckbox"]').text(statusLabel);
}
if (form.name_of_university_country) {
$('#modalExtraFields').append(`<tr class="optional-field"><th>Name of University & Country</th><td>${form.name_of_university_country}</td></tr>`);
}

if (form.designation) {
$('#modalExtraFields').append(`<tr class="optional-field"><th>Designation</th><td>${form.designation}</td></tr>`);
}
if (form.no_of_papers_past) {
$('#modalExtraFields').append(`<tr class="optional-field"><th>No of Papers Past</th><td>${form.no_of_papers_past}</td></tr>`);
}
$('#viewFormModal').modal('show');
});

$(document).on('change', '#approveCheckbox', function () {
let id = $(this).data('id');
let table_status = $(this).data('table_status');
let status;
if (window.currentUserRole === "Dean") {
if (table_status == "RESEARCHER") {
status = $(this).is(':checked') ? 3 : 2;
}
}
if (window.currentUserRole === "HOD") {
if (table_status == "RESEARCHER") {
status = $(this).is(':checked') ? 2 : 1;
}
}
if (window.currentUserRole === "ORIC") {
if (table_status == "RESEARCHER") {
status = $(this).is(':checked') ? 4 : 3;
}
}

$.ajax({
url: `/international-Coauthored-Paper/${id}`,
type: 'POST',
data: {
_method: 'PUT',
_token: $('meta[name="csrf-token"]').attr('content'),
status: status
},
success: function (response) {
if (response.success) {
alert('Status updated successfully!');
fetchIndicatorForms();
} else {
alert('Failed to update status.');
}
},
error: function () {
alert('Error updating status.');
}
});
});


});
</script>
@endif
@endpush