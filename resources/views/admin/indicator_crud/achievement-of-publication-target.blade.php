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
             <h5 class="card-header">Scopus Publications</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="achievementTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Indicator Category</th>
                                                        <th>Classification</th>
                                                        <th>Na /International</th>
                                                        <th>Created Date</th>
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
          <div class="modal fade" id="updateFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Scopus Publication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="indicator_id" id="update_indicator_id">
                    <input type="hidden" id="form_status" name="form_status" value="RESEARCHER" required>

                    <div class="row g-6 mt-0">
                        <!-- Main Form Fields -->
                        <div class="col-12 col-lg-8">
                            <!-- Target Category -->
                            <div class="card shadow-none bg-transparent border border-primary">
                                <div class="card-body">
                                    <div class="row g-6">
                                        <div class="col-md-6">
                                            <label class="form-label">Target Category</label>
                                            <select name="target_category" id="update_target_category" class="form-select">
                                                <option value="">Select Target Category</option>
                                                <option value="Scopus-Indexed">Scopus Indexed</option>
                                                <option value="HEC">HEC</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Link Of Publications</label>
                                            <input type="url" name="link_of_publications" id="update_link_of_publications" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Rank</label>
                                            <input type="number" name="rank" id="update_rank" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nationality</label>
                                            <input type="text" name="nationality" id="update_nationality" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- As Author Rank -->
                            <div class="card shadow-none bg-transparent border border-primary mt-6">
                                <div class="card-body">
                                    <div class="row g-6">
                                        <div class="col-md-6">
                                            <label class="form-label">As Author Your Rank</label>
                                            <input type="number" name="as_author_your_rank" id="update_as_author_your_rank" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Co-Authors -->
                            <div class="card shadow-none bg-transparent border border-primary mt-6">
                                <div class="card-body">
                                    <div id="grant-details-container">
                                        <!-- Dynamic Co-Authors go here -->
                                    </div>
                                </div>
                                <div class="card-footer text-body-secondary bg-label-secondary">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mt-6" id="add-grant">
                                        <i class="icon-base ti tabler-plus me-1"></i>
                                        <span class="align-middle">Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Scopus / HEC / Medical -->
                        <div class="col-12 col-lg-4">
                            <div class="card shadow-none bg-transparent border border-primary">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Targets</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-6">
                                        <label class="form-label">Scopus</label>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">Q1</span>
                                            <input type="number" class="form-control scopus-q1" name="scopus_q1" id="update_scopus_q1">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">Q2</span>
                                            <input type="number" class="form-control scopus-q2" name="scopus_q2" id="update_scopus_q2">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">Q3</span>
                                            <input type="number" class="form-control scopus-q3" name="scopus_q3" id="update_scopus_q3">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Q4</span>
                                            <input type="number" class="form-control scopus-q4" name="scopus_q4" id="update_scopus_q4">
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label class="form-label">HEC</label>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">W</span>
                                            <input type="number" class="form-control hec-w" name="hec_w" id="update_hec_w">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">X</span>
                                            <input type="number" class="form-control hec-x" name="hec_x" id="update_hec_x">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Y</span>
                                            <input type="number" class="form-control hec-y" name="hec_y" id="update_hec_y">
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label class="form-label">Medical</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Recognized</span>
                                            <input type="number" class="form-control medical-recognized" name="medical_recognized" id="update_medical_recognized">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 mt-3">
                        {{-- <button type="button" class="btn btn-success w-100" id="updateFormBtn">UPDATE</button> --}}
                        <div class="alert alert-danger" role="alert">Update is not allow at this time!</div>
                        <P>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- / model -->
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
    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
        <script>
            function fetchAchievementForms() {
                $.ajax({
                    url: "{{ route('indicator-form.index') }}",
                    method: "GET",
                    data: {
                        status: "Teacher" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
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

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.target_category || 'N/A',
                                form.journal_clasification || 'N/A',
                                form.nationality || 'N/A',
                                createdAt,
                                `<button class="btn rounded-pill btn-outline-primary waves-effect view-form-btn"
                                    data-history='${JSON.stringify(form.update_history)}'
                                    data-user='${form.creator ? form.creator.name : "N/A"}'
                                    data-created='${form.created_at}'>
                                    <span class="icon-xs icon-base ti tabler-history me-2"></span>History
                                </button>`,
                                editButton
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#achievementTable')) {
                            $('#achievementTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Indicator Category" },
                                    { title: "Classification" },
                                    { title: "Na /International" },
                                    { title: "Created Date" },
                                    { title: "History" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#achievementTable').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }
                
    
            $(document).ready(function () {
                fetchAchievementForms();
                let grantIndex = 0; // dynamic co-author counter

// Click Edit Button
$(document).on('click', '.edit-form-btn', function() {
    let form = $(this).data('form');

    // Fill main fields
    $('#update_indicator_id').val(form.indicator_id);
    $('#update_target_category').val(form.target_category);
    $('#update_link_of_publications').val(form.link_of_publications);
    $('#update_rank').val(form.rank);
    $('#update_nationality').val(form.nationality);
    $('#update_as_author_your_rank').val(form.as_author_your_rank);
    $('#update_scopus_q1').val(form.scopus_q1);
    $('#update_scopus_q2').val(form.scopus_q2);
    $('#update_scopus_q3').val(form.scopus_q3);
    $('#update_scopus_q4').val(form.scopus_q4);
    $('#update_hec_w').val(form.hec_w);
    $('#update_hec_x').val(form.hec_x);
    $('#update_hec_y').val(form.hec_y);
    $('#update_medical_recognized').val(form.medical_recognized);

    // Reset co-authors container
    $('#grant-details-container').html('');
    grantIndex = 0;

    if (form.co_author && form.co_author.length > 0) {
        form.co_author.forEach((author, index) => {
            addCoAuthor(author);
        });
    } else {
        addCoAuthor(); // at least 1 blank
    }

    // Show modal
    $('#updateFormModal').modal('show');
});

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
            if (update.role === 'HOD') histortText = update.status == '1' ? 'Unverified' : (update.status == '2' ? 'Verified' : update.status);
            else if (update.role === 'ORIC') histortText = update.status == '2' ? 'Unverified' : (update.status == '3' ? 'Verified' : update.status);
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




// Function to add Co-Author fields dynamically
function addCoAuthor(author = {}) {
    let newGroup = `
    <div class="row g-6 grant-group mt-4">
        <hr>
        <div class="col-md-6">
            <label class="form-label">Co-Author Name</label>
            <input type="text" name="co_author[${grantIndex}][name]" class="form-control" value="${author.name ?? ''}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Rank</label>
            <input type="number" name="co_author[${grantIndex}][rank]" class="form-control" value="${author.rank ?? ''}">
        </div>
        <div class="col-md-6">
            <label class="form-label">University Name</label>
            <input type="text" name="co_author[${grantIndex}][univeristy_name]" class="form-control" value="${author.univeristy_name ?? ''}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Country</label>
            <input type="text" name="co_author[${grantIndex}][country]" class="form-control" value="${author.country ?? ''}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="co_author[${grantIndex}][designation]" class="form-control" value="${author.designation ?? ''}">
        </div>
        <div class="col-md-12">
            <label class="form-label">No Of Papers Co-Authored with this person in the past.</label>
            <input type="number" name="co_author[${grantIndex}][no_paper_past]" class="form-control" value="${author.no_paper_past ?? ''}">
        </div>
        <div class="col-md-6">
            <label class="form-label d-block">First author your superviser?</label>
            <div>
                <input type="radio" name="co_author[${grantIndex}][first_author_superviser]" value="YES" ${author.first_author_superviser === 'YES' ? 'checked' : ''}> Yes
                <input type="radio" name="co_author[${grantIndex}][first_author_superviser]" value="NO" ${author.first_author_superviser !== 'YES' ? 'checked' : ''}> No
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Student Roll Number</label>
            <input type="text" name="co_author[${grantIndex}][student_roll_no]" class="form-control" value="${author.student_roll_no ?? ''}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Career</label>
            <input type="text" name="co_author[${grantIndex}][career]" class="form-control" value="${author.career ?? ''}">
        </div>
        <div class="col-md-12 mt-2">
            <button type="button" class="btn btn-danger remove-grant">Remove</button>
        </div>
    </div>
    `;
    $('#grant-details-container').append(newGroup);
    grantIndex++;
}

// Add new blank Co-Author
$('#add-grant').click(function () {
    addCoAuthor();
});

// Remove Co-Author
$(document).on('click', '.remove-grant', function () {
    $(this).closest('.grant-group').remove();
});




});

        </script>
    @endif
@endpush