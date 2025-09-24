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
                        <a class="nav-link active" data-bs-toggle="tab" href="#form1" role="tab"># Trainings, seminars & workshop conducted with Impact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#form2" role="tab">Table</a>
                    </li>
                </ul>
                @endif
                <div class="tab-content">
                    @if(auth()->user()->hasRole(['HOD', 'Teacher']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
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
                                        <label for="target_of_ken_knowledge_products" class="form-label">Target of KEN Knowledge products</label>
                                        <input type="text" id="target_of_ken_knowledge_products" name="target_of_ken_knowledge_products" class="form-control" >
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
                        </div>
                    @endif
                    @if(auth()->user()->hasRole(['Dean', 'HOD','ORIC']))
                    <div class="tab-pane fade show {{ auth()->user()->hasRole(['Dean', 'ORIC']) ? 'active' : '' }}" id="form2" role="tabpanel">
                        <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Co Authers</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @endif
                </div>
                
            </div>
        </div>
         <!-- Modal -->
        <div class="modal fade" id="viewFormModal" tabindex="-1" aria-labelledby="viewFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFormModalLabel">Form Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th>Created By</th><td id="modalCreatedBy"></td></tr>
                    <tr><th>Co-Author</th><td id="modalCoAuthers"></td></tr>
                    <tr><th>Author Rank</th><td id="modalAuthorRank"></td></tr>
                    <tr><th>Status</th><td>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="approveCheckbox">
                        <label class="form-check-label" for="approveCheckbox">Approved</label>
                    </div></td></tr>
                    <tr><th>Created Date</th><td id="modalCreatedDate"></td></tr>
                    <tbody id="modalExtraFields"></tbody>
                </table>
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
     @if(auth()->user()->hasRole(['HOD','Teacher']))
    <script>
    $(document).ready(function () {


        $('#researchForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('trainings-seminars-workshops.store') }}",
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
    @if(auth()->user()->hasRole(['Dean','HOD','ORIC']))
<script>
    window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
</script>
<script>
function fetchIndicatorForms() {
    $.ajax({
        url: "{{ route('trainings-seminars-workshops.index') }}",
        method: "GET",
         data: {
            status: "RESEARCHER" // you can send more values
        },
        dataType: "json",
        success: function (data) {
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
                    form.ket_target || 'N/A',
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
                        { title: "Created By" },
                        { title: "Ket target" },
                        { title: "Created Date" },
                        { title: "Actions" }
                    ]
                });
            } else {
                $('#complaintTable2').DataTable().clear().rows.add(rowData).draw();
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('Unable to load data.');
        }
    });
}
    $(document).ready(function () {

      fetchIndicatorForms();
       // Handle click on View button
    $(document).on('click', '.view-form-btn', function() {
        const form = $(this).data('form');
        $('#modalExtraFields').find('.optional-field').remove();

        $('#modalCreatedBy').text(form.creator ? form.creator.name : 'N/A');
        $('#modalStatus').text(form.status || 'Pending');
        $('#modalCreatedDate').text(form.created_at ? new Date(form.created_at).toLocaleString() : 'N/A');
        
        if (window.currentUserRole === 'HOD') {
            let statusLabel = "Review"; 
            if(form.form_status=='RESEARCHER'){
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
             if(form.form_status=='RESEARCHER'){
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
        }else if(window.currentUserRole === 'ORIC'){
            
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
         if (form.ket_target) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>ket target</th><td>${form.ket_target}</td></tr>`);
        }
        
        if (form.target_of_ken_knowledge_products) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>target products</th><td>${form.target_of_ken_knowledge_products}</td></tr>`);
        }
         if (form.event_proposal_forms_submission) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>Eevent proposal forms submission</th><td>${form.event_proposal_forms_submission}</td></tr>`);
        }
         if (form.no_of_knowledge_products_produced) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>knowledge products produced</th><td>${form.no_of_knowledge_products_produced}</td></tr>`);
        }
         if (form.no_of_participants) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>No of participants</th><td>${form.no_of_participants}</td></tr>`);
        } if (form.no_of_participants_from_the_industry) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>participants from the industry</th><td>${form.no_of_participants_from_the_industry}</td></tr>`);
        }
        if (form.no_of_participants_from_the_public_sector) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>participants from public sector</th><td>${form.no_of_participants_from_the_public_sector}</td></tr>`);
        }
        $('#viewFormModal').modal('show');
    });

     $(document).on('change', '#approveCheckbox', function () {
                let id = $(this).data('id');
                let table_status = $(this).data('table_status');
                let status;
                if (window.currentUserRole === "Dean"){
                    if(table_status=="RESEARCHER"){
                       status = $(this).is(':checked') ? 3 : 2;
                    }
                }
                if (window.currentUserRole === "HOD"){
                    if(table_status=="RESEARCHER"){
                       status = $(this).is(':checked') ? 2 : 1;
                    }
                }
                if (window.currentUserRole === "ORIC"){
                    if(table_status=="RESEARCHER"){
                       status = $(this).is(':checked') ? 4 : 3;
                    }
                }

                $.ajax({
                    url: `/trainings-seminars-workshops/${id}`,
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
