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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Multi Column with Form Separator -->
        <div class="card">
             <h5 class="card-header">% Employability</h5>
            <div class="card-datatable table-responsive card-body">
                    @if(auth()->user()->hasRole(['HOD']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                           <div class="table-responsive text-nowrap">
                             <table id="internationalSectionTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title of Activity</th>
                                                        <th>Total Number of Faculty in Department</th>
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
<div class="modal fade" id="employabilityFormModal" tabindex="-1" aria-labelledby="commericaGainFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commericaGainFormModalLabel">Edit % Employability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="researchForm1" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="record_id" name="record_id">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row g-3">
                       
                        <div class="card mb-6" style="padding:20px; font-family:Arial;">
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
                                                    class="form-check-input sitara-checkbox" name="stakeholder_category[]" id="stakeholder_category" 
                                                    value="faculty" {{ in_array('faculty', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Faculty</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="stakeholder_category[]" id="stakeholder_category" 
                                                    value="staff" {{ in_array('staff', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Staff</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="stakeholder_category[]" id="stakeholder_category" 
                                                    value="students" {{ in_array('students', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Students</label></div>
                                        </div>
                                    </div>

                                    <!-- Nature of Activity -->
                                    <div class="form-row-block">
                                        <h5 class="card-header">Nature of Activity</h5>
                                        <div class="card-body">
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="nature_of_activity[]" id="nature_of_activity"
                                                    value="social_responsibility" {{ in_array('social_responsibility', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Social
                                                    Responsibility</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="nature_of_activity[]" id="nature_of_activity"
                                                    value="sustainability" {{ in_array('sustainability', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Sustainability</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="nature_of_activity[]" id="nature_of_activity"
                                                    value="both" {{ in_array('both', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Both</label></div>
                                        </div>
                                    </div>

                                    <!-- Activity Location -->
                                    <div class="form-row-block">
                                        <h5 class="card-header">Activity Location</h5>
                                        <div class="card-body">
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="activity_location[]" id="activity_location"
                                                    value="within_campus" {{ in_array('within_campus', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Within Campus</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="activity_location[]" id="activity_location"
                                                    value="outside_campus" {{ in_array('outside_campus', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Outside Campus</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="activity_location[]" id="activity_location"
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
                                        <div class="card-body"><input class="form-control" name="date_of_activity" id="date_of_activity"
                                                type="date" value="{{ $submission->date_of_activity ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Partner Organization (if any)</h5>
                                        <div class="card-body"><textarea class="form-control" id="partner_organization"
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
                                                name="total_number_of_faculty_in_department" id="total_number_of_faculty_in_department"
                                                value="{{ $submission->total_number_of_faculty_in_department ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Number of Faculty Participated</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="number_of_faculty_participated" id="number_of_faculty_participated"
                                                value="{{ $submission->number_of_faculty_participated ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Total Number of Staff in Office</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="total_number_of_staff_in_office" id="total_number_of_staff_in_office"
                                                value="{{ $submission->total_number_of_staff_in_office ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Number of Staff Participated</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="number_of_staff_participated" id="number_of_staff_participated"
                                                value="{{ $submission->number_of_staff_participated ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Total Number of Students in Program / Society</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="total_number_of_students_in_program" id="total_number_of_students_in_program"
                                                value="{{ $submission->total_number_of_students_in_program ?? '' }}"></div>
                                    </div>

                                    <div class="form-row-block">
                                        <h5 class="card-header">Number of Students Participated</h5>
                                        <div class="card-body"><input type="number" class="form-control"
                                                name="number_of_students_participated" id="number_of_students_participated"
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
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]" id="typ_of_impact_achieved"
                                                    value="community_benefited" {{ in_array('community_benefited', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Community
                                                    benefited</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]" id="typ_of_impact_achieved"
                                                    value="environmental_improvement" {{ in_array('environmental_improvement', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Environmental improvement</label>
                                            </div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]" id="typ_of_impact_achieved"
                                                    value="awareness_created" {{ in_array('awareness_created', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Awareness
                                                    created</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]" id="typ_of_impact_achieved"
                                                    value="policy_practice_change" {{ in_array('policy_practice_change', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Policy/practice change</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]" id="typ_of_impact_achieved"
                                                    value="skill_development" {{ in_array('skill_development', $chaudhry) ? 'checked' : '' }}><label class="form-check-label">Skill
                                                    development</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox" name="typ_of_impact_achieved[]" id="typ_of_impact_achieved"
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
                                                    name="evidence_of_impact_available[]" id="evidence_of_impact_available" value="photos" {{ in_array('photos', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Photos</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" id="evidence_of_impact_available" value="attendance_sheets" {{ in_array('attendance_sheets', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Attendance sheets</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]"  id="evidence_of_impact_available" value="certificates" {{ in_array('certificates', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Certificates</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" id="evidence_of_impact_available" value="reports" {{ in_array('reports', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Reports</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]"  id="evidence_of_impact_available" value="media_coverage" {{ in_array('media_coverage', $chaudhry) ? 'checked' : '' }}><label
                                                    class="form-check-label">Media coverage</label></div>
                                            <div class="form-check"><input type="checkbox"
                                                    class="form-check-input sitara-checkbox"
                                                    name="evidence_of_impact_available[]" id="evidence_of_impact_available"  value="none" {{ in_array('none', $chaudhry) ? 'checked' : '' }}><label
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
                                            <input class="form-check-input" type="checkbox" name="declaration" id="declaration" value="1" {{ isset($submission->declaration) && $submission->declaration ? 'checked' : '' }}>
                                            <label class="form-check-label">I confirm that the information provided is
                                                accurate and verifiable.</label>
                                        </div>
                                    </div>
                                </div>

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
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    @if(auth()->user()->hasRole(['HOD']))
        <script>
        var indicatorId = @json($indicatorId ?? null);
            function fetchCommercialForms() {
                $.ajax({
                    url: "{{ route('internationalization-section.index') }}",
                    method: "GET",
                    data: {
                        status: "HOD", // you can send more values
                        indicatorId: indicatorId
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
                                form.title_of_activity || 'N/A',
                                form.total_number_of_faculty_in_department || 'N/A',
                                editButton
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#internationalSectionTable')) {
                            $('#internationalSectionTable').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "Title of Activity" },
                                    { title: "Total Number of Faculty in Department" },
                                    { title: "Actions" }
                                ]
                            });
                        } else {
                            $('#internationalSectionTable').DataTable().clear().rows.add(rowData).draw();
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
        // ✅ Multi-select checkboxes
        function setCheckboxes(fieldName, values) {
            $(`#researchForm1 input[name="${fieldName}[]"]`).each(function(){
                $(this).prop('checked', values.includes($(this).val()));
            });
        }

        setCheckboxes('stakeholder_category', form.stakeholder_category ?? []);
        setCheckboxes('nature_of_activity', form.nature_of_activity ?? []);
        setCheckboxes('activity_location', form.activity_location ?? []);
        setCheckboxes('typ_of_impact_achieved', form.typ_of_impact_achieved ?? []);
        setCheckboxes('evidence_of_impact_available', form.evidence_of_impact_available ?? []);
         // ✅ Textareas / Text / Number / Date
        $('#researchForm1 #TitleOfActivity').val(form.title_of_activity);
        $('#researchForm1 #BriefDescription').val(form.brief_description_of_activity);
        $('#researchForm1 #date_of_activity').val(form.date_of_activity);
        $('#researchForm1 #partner_organization').val(form.partner_organization);
        $('#researchForm1 #total_number_of_faculty_in_department').val(form.total_number_of_faculty_in_department);
        $('#researchForm1 #number_of_faculty_participated').val(form.number_of_faculty_participated);
        $('#researchForm1 #total_number_of_staff_in_office').val(form.total_number_of_staff_in_office);
        $('#researchForm1 #number_of_staff_participated').val(form.number_of_staff_participated);
        $('#researchForm1 #total_number_of_students_in_program').val(form.total_number_of_students_in_program);
        $('#researchForm1 #number_of_students_participated').val(form.number_of_students_participated);   

        // ✅ Declaration checkbox
        $('#researchForm1 #declaration').prop('checked', form.declaration ? true : false);     
            
        
        

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
            url: "{{ route('internationalization-section.update', '') }}/" + recordId,
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