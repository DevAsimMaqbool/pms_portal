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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(in_array(getRoleName(activeRole()), ['Dean','HOD','Program Leader UG','Program Leader PG']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <h5 class="card-header">No of Professional Memberships attained vs targets</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['Dean','HOD','Program Leader UG','Program Leader PG']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type of Membership</th>
                                                        <th>Name of Professional Body</th>
                                                        <th>Category of Body</th>
                                                        <th>History</th>
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
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit No of Professional Memberships attained vs targets</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">  

                      <div class="col-md-6">
                        <label for="type_of_membership" class="form-label">Type of Membership</label>
                        <select name="type_of_membership" id="type_of_membership" class="select2 form-select faculty-member"
                        required>
                        <option value="">-- Select Type --</option>
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
                        class="country-dropdown select2 form-select" required>
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
                        <div id="intellectual-img"></div>
                        </div>

                        <div class="col-12 mt-4">
                        <h6>Declaration</h6>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="declaration"  id="declaration"  value="1">
                        <label class="form-check-label">I confirm that the information provided is accurate and supported by valid evidence.</label>
                        </div>
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
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    @if(in_array(getRoleName(activeRole()), ['Dean','HOD','Program Leader UG','Program Leader PG']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('professional-membership.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            
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
                                form.type_of_membership || 'N/A',
                                form.name_of_professional_body|| 'N/A',
                                form.category_of_body|| 'N/A',
                                 `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn"
                                    data-history='${JSON.stringify(form.update_history)}'
                                    data-user='${form.creator ? form.creator.name : "N/A"}'
                                    data-created='${form.created_at}'>
                                    <span class="icon-xs icon-base ti tabler-history me-2"></span>History
                                </button>`,
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Type of Membership" },
                                    { title: "Name of Professional Body" },
                                    { title: "Category of Body" },
                                    { title: "History" },
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
                
    
            $(document).ready(function () {
                
                fetchCommercialForms();
                $(document).on('click', '.view-form-btn', function () {
                // Clear modal
                $('#modalExtraFieldsHistory').empty();
                $('#modalCreatedBy').text('');
                $('#modalCreatedDate').text('');

                // Read data-history
                let historyData = $(this).attr('data-history'); // raw string
                let history = [];

                try {
                    // Decode HTML entities first
                    historyData = historyData.replace(/&quot;/g, '"'); // convert &quot; → "
                    // Parse JSON (sometimes it's double-encoded)
                    history = JSON.parse(historyData);
                    if (typeof history === 'string') {
                        history = JSON.parse(history); // decode inner string if needed
                    }
                } catch (e) {
                    console.error('Failed to parse history JSON:', e);
                    history = [];
                }

                // Creator and created date
                let creator = $(this).data('user') || 'N/A';
                let created = $(this).data('created') || 'N/A';
                $('#modalCreatedBy').text(creator);
                $('#modalCreatedDate').text(new Date(created).toLocaleString());

                // Build timeline
                if (Array.isArray(history) && history.length > 0) {
                    let historyHtml = '';
                    history.forEach(update => {
                        let histortText = 'N/A';
                        if (update.role === 'QEC') histortText = update.status == '1' ? 'unapproved' : (update.status == '2' ? 'Approved' : update.status);
                        else histortText = update.status || 'N/A';

                        historyHtml += `
                            <li class="timeline-item timeline-item-transparent optional-field">
                                <span class="timeline-point timeline-point-primary"></span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-3">
                                        <h6 class="mb-0">${update.user_name || 'N/A'}</h6>
                                        <small class="text-body-secondary">${new Date(update.updated_at).toLocaleString()}</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="badge bg-lighter rounded-3">
                                            <span class="h6 mb-0 text-body">${update.role || 'N/A'}</span>
                                        </div>
                                        <div class="badge bg-lighter rounded-3 ms-2">
                                            <span class="h6 mb-0 text-body">${histortText}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                    });
                    $('#modalExtraFieldsHistory').append(historyHtml);
                } else {
                    $('#modalExtraFieldsHistory').append(`<li class="optional-field"><span>No History Available</span></li>`);
                }

                $('#viewFormModal').modal('show');
            });
            $(document).on('click', '.edit-form-btn', function () {
        const form = $(this).data('form');
        $('#researchForm1')[0].reset();
       $('#researchForm1 #intellectual-img').html('');
   
        $('#researchForm1 #record_id').val(form.id);
        $('#researchForm1 #type_of_membership').val(form.type_of_membership).trigger('change');
       
        $('#researchForm1 #name_of_professional_body').val(form.name_of_professional_body);
        $('#researchForm1 #category_of_body').val(form.category_of_body).trigger('change');
        $('#researchForm1 #discipline').val(form.discipline).trigger('change');
        $('#researchForm1 #level').val(form.level).trigger('change');
        $('#researchForm1 #country').val(form.country).trigger('change');
        $('#researchForm1 #membership_status').val(form.membership_status).trigger('change');
        $('#researchForm1 #membership_start_date').val(form.membership_start_date.substring(0,10));
        $('#researchForm1 #membership_valid_until').val(form.membership_valid_until.substring(0,10));
        if (form.evidence_type) {

            // Uncheck all first
            $('#researchForm1 input[name="evidence_type[]"]').prop('checked', false);

            let evidence = form.evidence_type;

            // If stored as JSON/string → convert
            if (typeof evidence === 'string') {
                try {
                    evidence = JSON.parse(evidence);
                } catch (e) {
                    evidence = [evidence];
                }
            }

            evidence.forEach(function(val){
                $('#researchForm1 input[name="evidence_type[]"][value="'+val+'"]')
                    .prop('checked', true);
            });
        }


        // ✅ Declaration checkbox
        $('#researchForm1 #declaration') .prop('checked', form.declaration == 1);


        // Show proof container based on status
       
        if (form.document_link) {
            let fileUrl = form.document_link;
            let fileExt = fileUrl.split('.').pop().toLowerCase();

            let filePreview = '';

            // ✅ If Image → show preview
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                filePreview = `<div class="avatar avatar-xl me-3 mt-2 bg-secondary">
                    <a href="${fileUrl}" target="_blank">
                        <img src="${fileUrl}" alt="Screenshot" class="rounded-circle">
                    </a></div>
                `;
            }
            // ✅ If PDF → show download button
            else if (fileExt === 'pdf') {
                filePreview = `
                    <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-primary mt-3">
                        Download PDF
                    </a>
                `;
            }
            // ✅ Other files → show generic download link
            else {
                filePreview = `
                    <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-secondary">
                        Download File
                    </a>
                `;
            }

            $("#intellectual-img").html(filePreview);
        }
        

        
        

        $('#multidisciplinaryProjectFormModal').modal('show');
    });
   
      // Submit updated data
    $('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        const recordId = $('#record_id').val();
        formData.append('status_update_data', true);
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });


        $.ajax({
            url: "{{ route('professional-membership.update', '') }}/" + recordId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#multidisciplinaryProjectFormModal').modal('hide');
                $('#researchForm1')[0].reset();
                form.find('.invalid-feedback').remove();
                form.find('.is-invalid').removeClass('is-invalid');
                fetchCommercialForms(); // reload table
            },
            error: function (xhr) {
                Swal.close();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = $('#researchForm1').find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            }
        });
    });
    $(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    if(!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
        url: `/professional-membership/${id}`,
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