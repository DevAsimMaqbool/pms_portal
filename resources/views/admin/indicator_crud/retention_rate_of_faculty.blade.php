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
        @if(in_array(getRoleName(activeRole()), ['Human Resources']))
        <!-- Multi Column with Form Separator -->
        <div class="card">
             <h5 class="card-header">Retention Rate of Faculty</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['Human Resources']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Year</th>
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
                    
                    <div class="row">
                        @php
                            $startYear = 2020;
                            $currentYear = now()->year;
                            $endYear = $currentYear + 5;
                        @endphp

                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <select name="year" id="select2Year" class="select2 form-select" required>
                                <option value="">-- Select Year --</option>
                                @for($year = $startYear; $year <= $endYear; $year++)
                                    <option value="{{ $year }}-{{ $year + 1 }}">
                                        {{ $year }}-{{ $year + 1 }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div id="author-past-container">
                            <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">
                                <div class="col-md-6">
                                    <label class="form-label">Faculty</label>
                                    <select name="retention_rate[0][faculty_id]" class="select2 form-select faculty-select">
                                        <option value="">Select Faculty</option>
                                        @foreach(get_faculties() as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Retention Rate</label>
                                    <div class="input-group">
                                        <span class="input-group-text">%</span>
                                        <input type="number" name="retention_rate[0][no_retention_rate]" class="form-control" min="1" step="1" required>
                                    </div>    
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="retention_rate[0][remarks]" rows="3"></textarea>
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-label-danger remove-past">Delete</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" id="add-coauthor">
                                <i class="icon-base ti tabler-plus me-1"></i> Add
                            </button>
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
        const faculties = @json(get_faculties());
    </script>
@endpush
@push('script')
    @if(in_array(getRoleName(activeRole()), ['Human Resources']))
        <script>
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('faculty-retention.index') }}",
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
                                form.year || 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Year" },
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
            url: "{{ route('faculty-retention.update', '') }}/" + recordId,
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
            url: `/faculty-retention/${id}`,
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
    function initSelect2() {
        $('#author-past-container .select2').select2({
            width: '100%',
            dropdownParent: $('#multidisciplinaryProjectFormModal')
        });
    }
    function generateFacultyOptions(selectedId = '') {
        let options = `<option value="">Select Faculty</option>`;
        faculties.forEach(faculty => {
            options += `<option value="${faculty.id}" ${faculty.id == selectedId ? 'selected' : ''}>${faculty.name}</option>`;
        });
        return options;
    }

   
let index = $('#author-past-container .past-group').length;

$(document).on('click', '#add-coauthor', function () {
    let html = `
    <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

        <div class="col-md-6">
            <label class="form-label">Faculty</label>
            <select name="retention_rate[${index}][faculty_id]" class="form-select select2 faculty-select">
                ${generateFacultyOptions()}
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Retention Rate</label>
            <div class="input-group">
                <span class="input-group-text">%</span>
                <input type="number" name="retention_rate[${index}][no_retention_rate]" class="form-control" min="1" step="1">
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">Remarks</label>
            <textarea name="retention_rate[${index}][remarks]" class="form-control" rows="3"></textarea>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-label-danger remove-past">Delete</button>
        </div>
    </div>`;

    $('#author-past-container').append(html);

    // Re-init Select2 for newly added select
    initSelect2();

    index++;
});

// Remove row
$(document).on('click', '.remove-past', function () {
    $(this).closest('.past-group').remove();
});

$(document).on('click', '.edit-form-btn', function () {
    const form = $(this).data('form');

    $('#record_id').val(form.id);
    $('#select2Year').val(form.year).trigger('change');

    $('#author-past-container').html('');
    index = 0;

    form.remarks.forEach(item => {
        let html = `
        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

            <div class="col-md-6">
                <label class="form-label">Faculty</label>
                <select name="retention_rate[${index}][faculty_id]" class="form-select select2 faculty-select">
                    ${generateFacultyOptions(item.faculty_id)}
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Retention Rate</label>
                <div class="input-group">
                    <span class="input-group-text">%</span>
                    <input type="number" name="retention_rate[${index}][no_retention_rate]" class="form-control" value="${item.no_retention_rate}">
                </div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Remarks</label>
                <textarea name="retention_rate[${index}][remarks]" class="form-control" rows="3">${item.remarks ?? ''}</textarea>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-label-danger remove-past">Delete</button>
            </div>
        </div>`;

        $('#author-past-container').append(html);
        index++;
    });

    // Init Select2 after loading all rows
    initSelect2();

    $('#multidisciplinaryProjectFormModal').modal('show');
});

     

});

        </script>
    @endif
@endpush