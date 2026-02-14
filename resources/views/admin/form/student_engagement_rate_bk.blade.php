@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.css') }}" />
    

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

<style>
    .form-check {
        margin-bottom: 4px;
    }

    .row-bordered>[class*="col-"] {
        border: none !important;
    }

    .form-row-block {
        min-height: 100px;
        margin-bottom: 4px;
    }

    .form-row-block .card-header {
        min-height: 36px;
        display: flex;
        align-items: center;
        padding: 4px 8px;
        font-size: 0.95rem;
    }

    .form-row-block .card-title {
        min-height: 36px;
        display: flex;
        align-items: center;
        padding: 4px 8px;
        font-size: 1.4rem;
    }

    .form-row-block .card-body {
        padding: 4px 8px;
    }

    .form-control {
        min-height: 34px;
        font-size: 0.95rem;
        padding: 4px 8px;
    }

    textarea.form-control {
        resize: none;
    }
</style>

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-3">
            <div class="card-datatable table-responsive card-body">
            <div class="d-flex justify-content-between">
                               <div>
                                <h5 class="mb-1">Student Engagement Rate </h5>
                                </div>
                                <a href="{{ route('indicators_crud.index', ['slug' => 'Internationalization_section', 'id' => $indicatorId]) }}" class="btn rounded-pill btn-outline-primary waves-effect"> View</a>
                            </div> 
                <form id="researchForm" method="POST" action="{{ route('nomination.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" id="employeeId" name="employee_id" value="{{ Auth::user()->employee_id }}"
                        class="form-control" /> --}}
                    <input type="hidden" id="form_status" name="form_status" value="HOD" required>
                    <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">    

                    <div class="row g-3" style="padding-top:20px; font-family:Arial;">
                        <div class="card mb-6">
                            <div class="row row-bordered g-0 mt-2">

                                {{-- Column 1 --}}
                                <div class="col-md-4">
                                    <!-- Stakeholder Category -->
                                    <div class="form-row-block">
                                        <h3 class="card-title">Type of Engagement</h3>
                                        <h5 class="card-header">Stakeholder Category</h5>
                                        <div class="card-body">
                                            @php $chaudhry = $submission->chaudhry_akram_awards ?? []; @endphp
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="stakeholder_category[]"
                                                    value="faculty" {{ in_array('faculty', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Faculty</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="stakeholder_category[]"
                                                    value="staff" {{ in_array('staff', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Staff</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="stakeholder_category[]"
                                                    value="students" {{ in_array('students', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Students</label></div>
                                        </div>
                                    </div>

                                    <!-- Nature of Activity -->
                                    <div class="form-row-block">
                                        <h5 class="card-header">Nature of Activity</h5>
                                        <div class="card-body"><input type="text" class="form-control"
                                                name="nature_of_activity">
                                        </div>
                                    </div>

                                    <!-- Activity Location -->
                                    <div class="form-row-block">
                                        <h5 class="card-header">Activity Location</h5>
                                        <div class="card-body">
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="activity_location[]"
                                                    value="within_campus" {{ in_array('within_campus', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Within Campus</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="activity_location[]"
                                                    value="outside_campus" {{ in_array('outside_campus', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Outside Campus</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="activity_location[]"
                                                    value="both" {{ in_array('both', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Both</label></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Column 2 --}}
                                <div class="col-md-4">
                                    <div class="form-row-block">
                                        <h3 class="card-title">Activity Details</h3>
                                        <h5 class="card-header">Title of Activity / Program</h5>
                                        <div class="card-body"><textarea class="form-control" id="TitleOfActivity"
                                                name="title_of_activity"
                                                rows="2">{{ $submission->title_of_activity ?? '' }}</textarea></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Brief Description of Activity</h5>
                                        <div class="card-body"><textarea class="form-control" id="BriefDescription"
                                                name="brief_description_of_activity"
                                                rows="2">{{ $submission->sitara_qiyadat_why ?? '' }}</textarea></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Date(s) of Activity</h5>
                                        <div class="card-body"><input class="form-control" name="date_of_activity"
                                                type="date" value="{{ $submission->date_of_activity ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Partner Organization (if any)</h5>
                                        <div class="card-body"><textarea class="form-control" id="PartnerOrganization"
                                                name="partner_organization"
                                                rows="2">{{ $submission->partner_organization ?? '' }}</textarea></div>
                                    </div>
                                </div>

                                {{-- Column 3 --}}
                                <div class="col-md-4">
                                    <div class="form-row-block">
                                        <h3 class="card-title">Participation Data</h3>
                                        <h5 class="card-header">Total Number of Faculty in Department</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="total_number_of_faculty_in_department"
                                                value="{{ $submission->total_number_of_faculty_in_department ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Number of Faculty Participated</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="number_of_faculty_participated"
                                                value="{{ $submission->number_of_faculty_participated ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Total Number of Staff in Office</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="total_number_of_staff_in_office"
                                                value="{{ $submission->total_number_of_staff_in_office ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Number of Staff Participated</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="number_of_staff_participated"
                                                value="{{ $submission->number_of_staff_participated ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Total Number of Students in Program / Society</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="total_number_of_students_in_program"
                                                value="{{ $submission->total_number_of_students_in_program ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Number of Students Participated</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="number_of_students_participated"
                                                value="{{ $submission->number_of_students_participated ?? '' }}"></div>
                                    </div>
                                </div>

                                {{-- Impact Measurement / Verification --}}
                                <div class="col-md-4">
                                    <div class="form-row-block">
                                        <h3 class="card-title">Impact Measurement</h3>
                                        <h5 class="card-header">Type of Impact Achieved (Multiple choice)</h5>
                                        <div class="card-body">
                                            @php $chaudhry = $submission->chaudhry_akram_awards ?? []; @endphp
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]"
                                                    value="community_benefited" {{ in_array('community_benefited', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Community
                                                    benefited</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]"
                                                    value="environmental_improvement" {{ in_array('environmental_improvement', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Environmental improvement</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]"
                                                    value="awareness_created" {{ in_array('awareness_created', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Awareness
                                                    created</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]"
                                                    value="policy_practice_change" {{ in_array('policy_practice_change', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Policy/practice change</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]"
                                                    value="skill_development" {{ in_array('skill_development', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Skill
                                                    development</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]"
                                                    value="other" {{ in_array('other', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Other (specify)</label></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-row-block">
                                        <h3 class="card-title">Impact Description (Mandatory)</h3>
                                        <div class="card-body">
                                            <p>Paragraph (Quantify where possible: number of beneficiaries, trees planted,
                                                funds raised, waste reduced, hours served, etc.)</p>
                                        </div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Evidence of Impact Available (File upload)</h5>
                                        <div class="card-body">
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" value="photos" {{ in_array('photos', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Photos</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" value="attendance_sheets" {{ in_array('attendance_sheets', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Attendance sheets</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" value="certificates" {{ in_array('certificates', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Certificates</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" value="reports" {{ in_array('reports', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Reports</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" value="media_coverage" {{ in_array('media_coverage', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Media coverage</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" value="none" {{ in_array('none', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">None</label></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-row-block">
                                        <h3 class="card-title">Verification & Declaration</h3>
                                        <div class="card-body">
                                            <h6>Verified By:</h6>
                                            <p>Name & Designation</p>
                                        </div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Declaration</h5>
                                        <div class="card-body">
                                            <input class="form-check-input" type="checkbox" name="declaration" value="1" {{ isset($submission->declaration) && $submission->declaration ? 'checked' : '' }}>
                                            <label class="form-check-label">I confirm that the information provided is
                                                accurate and verifiable.</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row-block">
                                        <h5 class="card-header">Student Satisfaction Rate / Happiness of students</h5>
                                        <div class="card-body">
                                        <div id="employerRating" class="raty"></div>
                                        <input type="hidden" name="employer_satisfaction" id="employer_satisfaction" value="">
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-file-upload.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    {{-- <script>
        document.getElementById('researchForm').addEventListener('submit', function (e) {
            if (!document.querySelectorAll('.sitara-checkbox:checked').length) {
                alert('Please select at least one award.');
                e.preventDefault(); return false;
            }
            if (!Array.from(document.querySelectorAll('.description-area')).some(t => t.value.trim() !== '')) {
                alert('Please fill out at least one justification.');
                e.preventDefault(); return false;
            }
        });
    </script> --}}

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

    <script>
     document.addEventListener("DOMContentLoaded", function () {

        // SVG stars
        const starOn = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23FFD700' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
        const starHalf = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cdefs%3E%3ClinearGradient id='halfStarGradient'%3E%3Cstop offset='50%25' style='stop-color:%23FFD700' /%3E%3Cstop offset='50%25' style='stop-color:%239e9e9e' /%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath fill='url(%23halfStarGradient)' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";
        const starOff = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239e9e9e' d='m8.243 7.34l-6.38.925l-.113.023a1 1 0 0 0-.44 1.684l4.622 4.499l-1.09 6.355l-.013.11a1 1 0 0 0 1.464.944l5.706-3l5.693 3l.1.046a1 1 0 0 0 1.352-1.1l-1.091-6.355l4.624-4.5l.078-.085a1 1 0 0 0-.633-1.62l-6.38-.926l-2.852-5.78a1 1 0 0 0-1.794 0z'/%3E%3C/svg%3E";

        // Employer Rating
        const employerRaty = new Raty(document.getElementById("employerRating"), {
            number: 5,
            half: true,
            starOn: starOn,
            starHalf: starHalf,
            starOff: starOff,
            click: function(score) {
                document.getElementById("employer_satisfaction").value = score;
            }
        }).init();

        // Graduate Rating
        const graduateRaty = new Raty(document.getElementById("graduateRating"), {
            number: 5,
            half: true,
            starOn: starOn,
            starHalf: starHalf,
            starOff: starOff,
            click: function(score) {
                document.getElementById("graduate_satisfaction").value = score;
            }
        }).init();

    });

    </script>
    @if(auth()->user()->hasRole(['HOD']))
        <script>
            $(document).ready(function () {
              
              

                 $('#researchForm').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(this);
                     // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                     
                    $.ajax({
                        url: "{{ route('student-engagement-rate.store') }}",
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
                            $('.select2').val(null).trigger('change');
                              // Remove all extra grant groups and keep only the first one
                            $('#grant-details-container .grant-group:not(:first)').remove();

                            // Reset the proof container of the first group
                            $('#grant-details-container .grant-group:first .proof-container').hide();

                            // Reset index to 1
                            grantIndex = 1;
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

                        } else if (xhr.status === 409) {
                            // 🔥 Duplicate record message
                            Swal.fire({
                                icon: 'error',
                                title: 'Duplicate Entry',
                                text: xhr.responseJSON.message
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
    @endpush