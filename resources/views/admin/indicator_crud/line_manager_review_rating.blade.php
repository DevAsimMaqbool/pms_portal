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
             <h5 class="card-header">Line Manager's Review & Rating on Tasks</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="intellectualTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Year</th>
                                                        <th>Remarks</th>
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
                                    
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-language">Name of Faculty Member</label>
                                        <select name="employee_id" id="employee_id" class="select2 form-select" required>
                                        <option value="">-- Select Faculty Member --</option>
                                        @foreach(get_faculty_members() as $member)
                                            <option value="{{ $member->id }}" 
                                                data-department="{{ $member->department }}"
                                                data-job_title="{{ $member->job_title }}"
                                                {{ request('employee_id') == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-language">Year</label>
                                        <select name="year" id="year" class="select2 form-select" required>
                                            <option value="">-- Select Year --</option>
                                            <option value="2025-2026">2025-2026</option>
                                        </select>
                                    </div>
                                    <div id="author-past-container">
                                        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

                                            <div class="col-md-6">
                                                <label class="form-label">Task</label>
                                                <input type="text" name="linemanager[0][task]" id="task" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Rating</label>
                                                <div id="linemanager_raty_0" class="raty"></div>
                                                <input type="hidden" name="linemanager[0][linemanager_rating]" id="linemanager_rating_0" value="">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            id="add-coauthor"><i class="icon-base ti tabler-plus me-1"></i> <span
                                                class="align-middle">Add</span></button>
                                    </div>
                                    <div class="col-md-12">
                                                <label class="form-label d-block">Remarks</label>
                                                <div>
                                                    <textarea class="form-control" id="remarks" name="remarks" rows="4"></textarea>
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
    @if(auth()->user()->hasRole(['HOD']))
        <script>
                    function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('line-manager-review-rating.index') }}",
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
                                form.remarks|| 'N/A',
                                editButton+ ' ' + deleteBtn
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#intellectualTable')) {
                            $('#intellectualTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Year" },
                                    { title: "Remarks" },
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



                const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";


/* ⭐⭐⭐⭐⭐ YOUR REQUIRED FUNCTION */
function initRaty(id, inputId, score = 0) {

    const ratyInstance = new Raty(document.getElementById(id), {
        number: 5,
        half: true,
        score: score,        // ⭐ set initial score
        starOn: starOn,
        starHalf: starHalf,
        starOff: starOff,

        click: function(newScore) {
            document.getElementById(inputId).value = newScore;
        }
    });

    ratyInstance.init();

    // Sync hidden input
    document.getElementById(inputId).value = score;

    return ratyInstance;   // ⭐ IMPORTANT
}



let index = 1;

$(document).ready(function(){

    fetchCommercialForms();

    /* Init first row */
    initRaty("linemanager_raty_0", "linemanager_rating_0");


    /* ================= ADD ROW ================= */

    $('#add-coauthor').click(function(){

        let html = `
        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

            <div class="col-md-6">
                <label class="form-label">Task</label>
                <input type="text" name="linemanager[${index}][task]" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Rating</label>
                <div id="linemanager_raty_${index}" class="raty"></div>
                <input type="hidden"
                    name="linemanager[${index}][linemanager_rating]"
                    id="linemanager_rating_${index}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-past"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
            </div>

        </div>`;

        $('#author-past-container').append(html);

        initRaty(`linemanager_raty_${index}`, `linemanager_rating_${index}`);

        index++;
    });


    /* ================= EDIT LOAD ================= */

    $(document).on('click','.edit-form-btn',function(){

        const form = $(this).data('form');

        $('#record_id').val(form.id);
        $('#employee_id').val(form.employee_id).trigger('change');
        $('#year').val(form.year).trigger('change');
        $('#remarks').val(form.remarks);
        

        // 🔥 Clear previous tasks
    $('#author-past-container').html('');

    // 🔥 Loop tasks
    form.tasks.forEach(task => {

        let html = `
        <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

            <div class="col-md-6">
                <label class="form-label">Task</label>
                <input type="text"
                    name="linemanager[${index}][task]"
                    class="form-control"
                    value="${task.task}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Rating</label>
                <div id="linemanager_raty_${index}" class="raty"></div>

                <input type="hidden"
                    name="linemanager[${index}][linemanager_rating]"
                    id="linemanager_rating_${index}"
                    value="${task.linemanager_rating}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-past"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
            </div>

        </div>
        `;

        $('#author-past-container').append(html);

        // ⭐ INIT STAR
         let employerRaty = initRaty(
        'linemanager_raty_'+index,
        'linemanager_rating_'+index,
        task.linemanager_rating
    );

        // ⭐ SET SCORE
        document.getElementById('linemanager_rating_'+index).value = task.linemanager_rating;
        // Optional explicit set
    employerRaty.setScore(task.linemanager_rating);

        index++;
    });



        $('#multidisciplinaryProjectFormModal').modal('show');
    });
    $(document).on('click', '.remove-past', function () {

    if ($('.past-group').length === 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Cannot delete',
            text: 'At least one task is required'
        });
        return;
    }

    $(this).closest('.past-group').remove();
});


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
            url: "{{ route('line-manager-review-rating.update', '') }}/" + recordId,
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