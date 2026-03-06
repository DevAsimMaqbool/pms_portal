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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
              <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Rating on Impact of Research Conferences Organized</h5>
                </div>
                <div class="">
                    <a href="{{ url('kpa/2/category/9/indicator/140') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Created By</th>
                                                        <th>Conference Name</th>
                                                        <th>Conference Theme</th>
                                                        <th>Created Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                            </div>    
                        </div>
                    @endif
                   
            </div>
        </div>
        <!-- Update Intellectual Property Modal -->
           <!-- Modal -->
       <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="viewFormModalLabel">
                <i class="icon-base ti tabler-history me-3"></i>History
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered mb-3"> 
                <tr>
                    <td>
                        <div class="d-flex justify-content-left align-items-center">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-info">🙍🏻‍♂️</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-50">
                                <span class="text-truncate fw-medium text-heading" id="modalCreatedBy">Website SEO</span>
                                <small class="text-truncate" id="modalCreatedDate"></small>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <h5 class="card-title mb-2 me-2 pt-1 mb-2 d-flex align-items-center">
                <i class="icon-base ti tabler-history me-3"></i>History
            </h5>
            <ul class="timeline mb-0" id="modalExtraFieldsHistory"></ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

        <!--/ Add Permission Modal -->
 <!-- Update commercial gain Modal -->
<div class="modal fade" id="multidisciplinaryProjectFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit Line Manager's Review & Rating on Tasks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">
                     <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">
                     {{-- ================= Conference Detail ================= --}}
                <h5 class="card-tile mb-0">Conference Detail</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="conference_name">Conference Name</label>
                        <input type="text" class="form-control" id="conference_name" name="conference_name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="conference_theme">Conference Theme</label>
                        <input type="text" class="form-control" id="conference_theme" name="conference_theme">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="conference_date">Conference Date</label>
                        <input type="date" class="form-control" id="conference_date" name="conference_date">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="conference_venue">Conference Venue</label>
                        <input type="text" class="form-control" id="conference_venue" name="conference_venue" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Conference Scope</label>
                        <select name="conference_scope" id="conference_scope" class="select2 form-select" required>
                            <option value="">Select</option>
                            <option value="national">National</option>
                            <option value="international">International</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Scopus Indexing</label>
                        <select name="scopus_indexing" id="scopus_indexing" class="select2 form-select" required>
                            <option value="">Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>

                {{-- ================= Participants’ Detail ================= --}}
                <h5 class="card-tile mb-0 mt-3">Participants’ Detail</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">National Participants</label>
                        <input type="number" class="form-control" name="national_participants" id="national_participants">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">International Participants</label>
                        <input type="number" class="form-control" name="international_participants" id="international_participants">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Industry Participants</label>
                        <input type="number" class="form-control" name="industry_participants" id="industry_participants">
                    </div>
                </div>

                {{-- ================= Scholarly & Industry Remarks ================= --}}
                <h5 class="card-tile mb-0 mt-3">Scholarly & Industry Impact Remarks</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Scholarly Impact</label>
                        <textarea class="form-control" name="scholarly_impact" id="scholarly_impact"  rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Industry Engagement</label>
                        <textarea class="form-control" name="industry_engagement" id="industry_engagement" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">International Participation</label>
                        <textarea class="form-control" name="international_participation" id="international_participation" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Indexing & Recognition</label>
                        <textarea class="form-control" name="indexing_recognition" id="indexing_recognition" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Overall Remarks</label>
                        <textarea class="form-control" name="overall_remarks" id="overall_remarks" rows="2"></textarea>
                    </div>
                </div>

                {{-- ================= Dynamic International Participants ================= --}}
                <h5 class="card-title mb-0 mt-3">International Participants’ Detail</h5>
                <!-- Participants Detail -->
                <div id="author-past-container">
                    <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="intrtnationpart[0][name]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <input type="text" name="intrtnationpart[0][designation]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">University / Organization</label>
                            <input type="text" name="intrtnationpart[0][participant_university]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <select name="intrtnationpart[0][participant_country]" class=" form-select participant_country" required>
                                <option value="">Select Country</option>
                                @foreach(getAllCountries() as $con)
                                    <option value="{{ $con['code'] }}">{{ $con['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Participated As</label>
                            <select name="intrtnationpart[0][participated_as][]" class="select2 form-select participated_as" multiple required>
                                <option value="Guest Speaker">Guest Speaker</option>
                                <option value="Participant">Participant</option>
                                <option value="Presenter">Presenter</option>
                                <option value="Moderator">Moderator</option>
                                <option value="Session Chair">Session Chair</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-label-danger remove-past">
                                <i class="icon-base ti tabler-x me-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="add-coauthor">
                        <i class="icon-base ti tabler-plus me-1"></i> Add
                    </button>
                </div>

                {{-- ================= Research Partners ================= --}}
                <h5 class="card-title mb-0 mt-3">Research Partners</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nature of Partner</label>
                        <select name="nature_of_partner" id="nature_of_partner" class="form-select" required>
                            <option value="">-- Select Partner --</option>
                            <option value="academia">Academia</option>
                            <option value="industry">Industry</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Partner Institute / Organization Name</label>
                        <input type="text" name="partner_institute" id="partner_institute" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Partner Country</label>
                        <select name="partner_country" id="partner_country" class=" form-select" required>
                            <option value="">Select Country</option>
                            @foreach(getAllCountries() as $con)
                                <option value="{{ $con['code'] }}">{{ $con['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        @else
             <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
                <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
                <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
                <div class="mt-12">
                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}" alt="page-misc-not-authorized" width="170" class="img-fluid" />
                </div>
            </div>
        @endif

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
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    @if(in_array(getRoleName(activeRole()), ['HOD','Professor','Assistant Professor','Associate Professor']))
        <script>
                    function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('conference-impact.index') }}",
                    method: "GET",
                    data: {
                        status: "Teacher" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';       
                            
                            let editButton = '';
                            if (parseInt(form.status) === 1) {
                                editButton = `
                                    <button class="btn rounded-pill btn-outline-primary waves-effect edit-form-btn" 
                                        data-form='${JSON.stringify(form)}'>
                                        <span class="icon-xs icon-base ti tabler-eye me-2"></span>Edit
                                    </button>`;
                            }  
                            const deleteBtn = `<button class="btn rounded-pill btn-outline-danger delete-btn" data-id="${form.id}">Delete</button>`;      

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.creator ? form.creator.name : 'N/A',
                                form.conference_name || 'N/A',
                                form.conference_theme || 'N/A',
                                createdAt,
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Created By" },
                                    { title: "Conference Name" },
                                    { title: "Conference Theme" },
                                    { title: "Created Date" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#intellectualTable').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
                
let index = $('#author-past-container .past-group').length || 0;

function reinitializeSelect2() {
    $('.select2').select2({
        dropdownParent: $('#multidisciplinaryProjectFormModal'),
        width: '100%'
    });
}

function generateParticipantRow(i, participant = {}) {
    let countryOptions = `
        @foreach(getAllCountries() as $con)
            <option value="{{ $con['code'] }}">{{ $con['name'] }}</option>
        @endforeach
    `;

    let participatedAsOptions = ["Guest Speaker","Participant","Presenter","Moderator","Session Chair"];
    let participatedAsHtml = participatedAsOptions.map(opt => {
        let selected = participant.participated_as && participant.participated_as.includes(opt) ? 'selected' : '';
        return `<option value="${opt}" ${selected}>${opt}</option>`;
    }).join('');

    return `
    <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="intrtnationpart[${i}][name]" class="form-control" value="${participant.name || ''}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="intrtnationpart[${i}][designation]" class="form-control" value="${participant.designation || ''}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">University / Organization</label>
            <input type="text" name="intrtnationpart[${i}][participant_university]" class="form-control" value="${participant.participant_university || ''}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Country</label>
            <select name="intrtnationpart[${i}][participant_country]" class=" form-select participant_country" required>
                ${countryOptions}
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Participated As</label>
            <select name="intrtnationpart[${i}][participated_as][]" class="select2 form-select participated_as" multiple required>
                ${participatedAsHtml}
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-label-danger remove-past">
                <i class="icon-base ti tabler-x me-1"></i> Delete
            </button>
        </div>
    </div>
    `;
}

// ================= Add Row =================
$('#add-coauthor').click(function(){
    $('#author-past-container').append(generateParticipantRow(index));
    reinitializeSelect2();
    index++;
});

// ================= Remove Row =================
$(document).on('click', '.remove-past', function () {
    if ($('.past-group').length === 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Cannot delete',
            text: 'At least one participant is required'
        });
        return;
    }
    $(this).closest('.past-group').remove();
});

// ================= Edit Load =================
$(document).on('click','.edit-form-btn',function(){
    const form = $(this).data('form');
    $('#record_id').val(form.id);
    // Fill basic fields
    $('#conference_name').val(form.conference_name);
    $('#conference_theme').val(form.conference_theme);
    $('#conference_date').val(form.conference_date);
    $('#conference_scope').val(form.conference_scope).trigger('change');
    $('#scopus_indexing').val(form.scopus_indexing).trigger('change');
    $('#national_participants').val(form.national_participants);
    $('#international_participants').val(form.international_participants);
    $('#industry_participants').val(form.industry_participants);
    $('#scholarly_impact').val(form.scholarly_impact);
    $('#industry_engagement').val(form.industry_engagement);
    $('#international_participation').val(form.international_participation);
    $('#indexing_recognition').val(form.indexing_recognition);
    $('#overall_remarks').val(form.overall_remarks);
    $('#nature_of_partner').val(form.nature_of_partner).trigger('change');
    $('#partner_institute').val(form.partner_institute);
    $('#partner_country').val(form.partner_country).trigger('change');
     $('#conference_venue').val(form.conference_venue);

    // Reset participants
    $('#author-past-container').html('');
    index = 0;

    form.participants.forEach(p => {
        $('#author-past-container').append(generateParticipantRow(index, p));
        index++;
    });

    reinitializeSelect2();
    $('#multidisciplinaryProjectFormModal').modal('show');
});

// ================= Initialize on page load =================
            $(document).ready(function () {
                fetchCommercialForms();
                reinitializeSelect2();


   



              
        

   
      // Submit updated data
    $('#researchForm1').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    // Ensure multi-select arrays are appended
    $('.participated_as').each(function(){
        let name = $(this).attr('name');
        let values = $(this).val(); // array of selected
        formData.delete(name); // remove default FormData
        if(values) values.forEach(v => formData.append(name, v));
    });

    Swal.fire({
        title: 'Updating...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    const recordId = $('#record_id').val();

    $.ajax({
        url: "{{ route('conference-impacts.update', '') }}/" + recordId,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(response) {
            Swal.close();
            Swal.fire('Success', response.message, 'success');
            $('#multidisciplinaryProjectFormModal').modal('hide');
            $('#researchForm1')[0].reset();
            fetchCommercialForms();
        },
        error: function(xhr) {
            Swal.close();
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages){
                    let input = $('[name="'+field+'"]');
                    input.addClass('is-invalid');
                    input.after('<div class="invalid-feedback">'+messages[0]+'</div>');
                });
            } else {
                Swal.fire('Error','Something went wrong!','error');
            }
        }
    });
});
    $(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    if(!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: `/line-manager-review-rating/${id}`,
        type: 'DELETE',
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(res) {
            alert(res.message);
            fetchCommercialForms();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Failed to delete record.');
        }
    });
});

     

});

        </script>
    @endif
@endpush