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

        <!-- Multi Column with Form Separator -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <div class="tab-content">
                     @if(in_array(getRoleName(activeRole()), ['HOD','Dean']))
                        <div class="tab-pane fade show active" id="form1" role="tabpanel">
                            
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                                <div class="d-flex flex-column justify-content-center">
                                    <h4 class="mb-1">Line Manager's Review & Rating on Tasks</h4>
                                </div>
                                <div class="d-flex align-content-center flex-wrap gap-4">
                                    <div class="d-flex gap-4">
                                    <a class="btn btn-label-primary" href="{{ route('indicators_crud.index', ['slug' => 'line_manager_review_rating', 'id' => $indicatorId]) }}">View</a></div>
                                    
                                </div>
                            </div>
                            <form id="researchForm1" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                                <input type="hidden" id="form_status" name="form_status" value="HOD">

                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-language">Name of Faculty Member</label>
                                        <select name="employee_id" id="select2Success" class="select2 form-select" required>
                                            <option value="">-- Select Faculty Member --</option>
                                            @foreach($facultyMembers as $member)
                                                <option value="{{ $member->id }}" data-department="{{ $member->department }}"
                                                    data-job_title="{{ $member->job_title }}" {{ request('employee_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $startYear = 2020; // you can change this
                                        $currentYear = now()->year;
                                        $endYear = $currentYear + 5; // how many years ahead you want
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label" for="multicol-language">Year</label>
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
                                                <label class="form-label">Task</label>
                                                <input type="text" name="linemanager[0][task]" class="form-control" required>
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
                                <div class="mt-3 text-end" style="margin-left: -19px !important;">
                                    <button class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                                </div>
                            </form>
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
 
     @if(in_array(getRoleName(activeRole()), ['HOD','Dean']))
        <script>
        // SVG stars
    const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
    const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
    const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

            
            $(document).ready(function () {
                
                let faculties = @json(get_faculties());
                let pastIndex = 1;
                function initRaty(id, inputId) {
                    new Raty(document.getElementById(id), {
                        number: 5,
                        half: true,
                        starOn: starOn,
                        starHalf: starHalf,
                        starOff: starOff,
                        click: function(score) {
                            document.getElementById(inputId).value = score;
                        }
                    }).init();
                }

                // Initialize first row
                initRaty('linemanager_raty_0', 'linemanager_rating_0');

                // Add new author group
                $('#add-coauthor').click(function () {
                    let newGroup = `
            <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

                <div class="col-md-6">
                    <label class="form-label">Task</label>
                    <input type="text" name="linemanager[${pastIndex}][task]" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Rating</label>
                    <div id="linemanager_raty_${pastIndex}" class="raty"></div>
                    <input type="hidden" name="linemanager[${pastIndex}][linemanager_rating]" id="linemanager_rating_${pastIndex}" value="">
                </div>

            <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-label-danger mt-xl-6 waves-effect remove-past"><i class="icon-base ti tabler-x me-1"></i><span class="align-middle">Delete</span></button>
            </div>
            </div>`;

                    // Convert string → jQuery object
                    let $newBlock = $(newGroup);

                    // Append
                    $('#author-past-container').append($newBlock);

                  initRaty(`linemanager_raty_${pastIndex}`, `linemanager_rating_${pastIndex}`);
                    pastIndex++;
                });
                

                // Remove a past group
                $(document).on('click', '.remove-past', function () {
                    $(this).closest('.past-group').remove();
                });
                $('#researchForm1').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('line-manager-review-rating.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                            form[0].reset();
                            // Remove added groups
                            $('#author-past-container .past-group').not(':first').remove();

                            // Reset Select2
                            $('#author-past-container select.select2')
                                .val(null)
                                .trigger('change');

                            // Reset dependent dropdowns
                            $('.department-select').html('<option value="">Select Department</option>');
                            $('.program-select').html('<option value="">Select Program</option>');

                            // Reset index
                            pastIndex = 1;
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
@endpush