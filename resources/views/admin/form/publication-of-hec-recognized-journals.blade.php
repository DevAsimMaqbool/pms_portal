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
                            <label for="name_of_journal" class="form-label">Name of journal</label>
                            <input type="text" id="name_of_journal" name="name_of_journal" class="form-control" >
                        </div>
                       
                        <div class="col-md-6">
                            <label for="approved_frequency_of_pub" class="form-label">Approved frequency of publication</label>
                            <input type="text" id="approved_frequency_of_pub" name="approved_frequency_of_pub" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_issues_published" class="form-label">No of issues published</label>
                            <input type="text" id="no_of_issues_published" name="no_of_issues_published" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="revenue_generated_under_apc" class="form-label">Revenue generated under APC</label>
                            <input type="text" id="revenue_generated_under_apc" name="revenue_generated_under_apc" class="form-control" >
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_indexing_prior_report" class="form-label">No of indexing prior to this report</label>
                            <input type="text" id="no_of_indexing_prior_report" name="no_of_indexing_prior_report" class="form-control" >
                        </div>

                         <div class="col-md-6">
                            <label for="new_indexing_done_quarter" class="form-label">New indexing done in this quarter</label>
                            <input type="text" id="new_indexing_done_quarter" name="new_indexing_done_quarter" class="form-control" >
                        </div>

                       
                    </div>
                    <div class="col-4 text-center demo-vertical-spacing">
                        <button class="btn btn-primary w-100 waves-effect waves-light">SUBMIT</button>
                    </div>
                </form>
                @endif
                @if(auth()->user()->hasRole(['Dean','ORIC']))
                    <div><div class="d-flex">
                        <select id="bulkAction" class="form-select w-auto me-2">
                            <option value="">-- Select Action --</option>
                            <option value="3">Review</option>
                            <option value="2">UnReview</option>
                        </select>
                        <button id="bulkSubmit" class="btn btn-primary">Submit</button>
                    </div>
                        <table id="complaintTable2" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>#</th>
                                    <th>Created By</th>
                                    <th>Name of Journal</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @endif
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
    <script>
    window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
    @if(auth()->user()->hasRole(['Teacher','HOD']))
     <script>
    $(document).ready(function () {

        $('#researchForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('publication-of-hecRecognized.store') }}",
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
    @if(auth()->user()->hasRole(['Dean','ORIC']))
    <script>
function fetchIndicatorForms() {
    $.ajax({
        url: "{{ route('publication-of-hecRecognized.index') }}",
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
                    form.name_of_journal || 'N/A',
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
                        { title: "Name of journal" },
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
        
        if (window.currentUserRole === 'Dean') {
            let statusLabel = "Review"; 
             if(form.form_status=='RESEARCHER'){
                $('#approveCheckbox').closest('.form-check-input').show();
                $('#approveCheckbox').prop('checked', form.status == 2);
                $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                // Label text for HOD
                    if (form.status == 1) {
                        statusLabel = "Verify";
                    } else if (form.status == 2) {
                        statusLabel = "Verify";
                    }
                }
        
            $('label[for="approveCheckbox"]').text(statusLabel);
        }else if(window.currentUserRole === 'ORIC'){
            $('#approveCheckbox').closest('.form-check-input').show();
                $('#approveCheckbox').prop('checked', form.status == 3);
                $('#approveCheckbox').data('id', form.id).data('table_status', form.form_status);
                // Label text for HOD
                    if (form.status == 2) {
                        statusLabel = "Verify";
                    } else if (form.status == 3) {
                        statusLabel = "Verify";
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
        if (form.name_of_journal) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>name of journale</th><td>${form.name_of_journal}</td></tr>`);
        }
        if (form.approved_frequency_of_pub) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>Approved frequency of pub</th><td>${form.approved_frequency_of_pub}</td></tr>`);
        }if (form.no_of_issues_published) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>No issues published</th><td>${form.no_of_issues_published}</td></tr>`);
        }if (form.revenue_generated_under_apc) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>revenue generated under apc</th><td>${form.revenue_generated_under_apc}</td></tr>`);
        }if (form.no_of_indexing_prior_report) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th>indexing prior report</th><td>${form.no_of_indexing_prior_report}</td></tr>`);
        }if (form.new_indexing_done_quarter) {
            $('#modalExtraFields').append(`<tr class="optional-field"><th> indexing done quarter</th><td>${form.new_indexing_done_quarter}</td></tr>`);
        }
      
        
        $('#viewFormModal').modal('show');
    });

     $(document).on('change', '#approveCheckbox', function () {
                let id = $(this).data('id');
                let table_status = $(this).data('table_status');
                let status;
                if (window.currentUserRole === "Dean"){
                    if(table_status=="RESEARCHER"){
                       status = $(this).is(':checked') ? 2 : 1;
                    }
                }
                if (window.currentUserRole === "ORIC"){
                    if(table_status=="RESEARCHER"){
                       status = $(this).is(':checked') ? 3 : 2;
                    }
                }
                $.ajax({
                    url: `/publication-of-hecRecognized/${id}`,
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
