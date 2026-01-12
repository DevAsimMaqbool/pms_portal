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
             <h5 class="card-header">Recovery %</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="recoveryTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Faculty</th>
                                                        <th>Department</th>
                                                        <th>Recovery Target</th>
                                                        <th>Target Achieved</th>
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
         
 <!-- Update commercial gain Modal -->
<div class="modal fade" id="employabilityFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit Recovery %</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">
                       
                        
                       <div class="col-md-6">
                                                <label for="faculty" class="form-label">Faculty</label>
                                                <select name="faculty_id" id="faculty_id" class="select2 form-select faculty-member" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    <option value="11"> Faculty of Business and Management Sciences-KCF</option>
                                                    <option value="171">Faculty of Computer Science and Information Technology-CCL</option>
                                                    <option value="158"> Faculty of  Arts and Humanities-CCL</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="department_id" class="form-label">Department</label>
                                                <select name="department_id" id="department_id" class="select2 form-select department" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                    <option value="11"> Faculty of Business and Management Sciences-KCF</option>
                                                    <option value="171">Faculty of Computer Science and Information Technology-CCL</option>
                                                    <option value="158"> Faculty of  Arts and Humanities-CCL</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="period" class="form-label">Period</label>
                                                <select name="period" id="period" class="select2 form-select period" required>
                                                    <option value="">-- Select Faculty Member --</option>
                                                   <option value="11"> Faculty of Business and Management Sciences-KCF</option>
                                                    <option value="171">Faculty of Computer Science and Information Technology-CCL</option>
                                                    <option value="158"> Faculty of  Arts and Humanities-CCL</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Recovery Target</label>
                                                <input type="number" name="recovery_target" id="recovery_target" class="form-control" min="1"
                                                    step="1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Target Achieved</label>
                                                <input type="number" name="achieved_target" id="achieved_target" class="form-control" min="1"
                                                    step="1" required>
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
    
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('recovery.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD" // you can send more values
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

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.faculty_id || 'N/A',
                                form.department_id || 'N/A',
                                form.recovery_target || 'N/A',
                                form.achieved_target || 'N/A',
                                editButton
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#recoveryTable')) {
                            $('#recoveryTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Faculty" },
                                    { title: "Department" },
                                    { title: "Recovery Target" },
                                    { title: "Target Achieved" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#recoveryTable').DataTable().clear().rows.add(rowData).draw();
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
               
            $(document).on('click', '.edit-form-btn', function () {
        const form = $(this).data('form');
        $('#researchForm1 #record_id').val(form.id);
        $('#researchForm1 #faculty_id').val(form.faculty_id).trigger('change');
        $('#researchForm1 #department_id').val(form.department_id).trigger('change');
        $('#researchForm1 #period').val(form.period).trigger('change');
        $('#researchForm1 #recovery_target').val(form.recovery_target)
        $('#researchForm1 #achieved_target').val(form.achieved_target);
        

        $('#employabilityFormModal').modal('show');
    });
      // Submit updated data
    $('#researchForm1').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        const recordId = $('#record_id').val();
        Swal.fire({
            title: 'Updating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });


        $.ajax({
            url: "{{ route('recovery.update', '') }}/" + recordId,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                Swal.close();
                Swal.fire('Success', response.message, 'success');
                $('#employabilityFormModal').modal('hide');
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
     

});

        </script>
    @endif
@endpush