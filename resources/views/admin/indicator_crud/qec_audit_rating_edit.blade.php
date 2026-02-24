@extends('layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
     @if(in_array(getRoleName(activeRole()), ['QEC']))
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h5>Edit QEC Audit Rating</h5>
                    <a href="{{ route('qec-audit-rating.index') }}" 
                       class="btn btn-outline-primary rounded-pill">
                        Back
                    </a>
                </div>

                <form id="editForm" class="row">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="indicator_id" value="{{ $audit->indicator_id }}">
                    <input type="hidden" name="form_status" value="{{ $audit->form_status }}">

                    <div id="author-past-container">

                        @foreach($audit->details as $index => $detail)
                            <div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

                                <div class="col-md-4">
                                    <label class="form-label">Audit Term</label>
                                    <select name="audits[{{ $index }}][audit_term]" class="form-select">
                                        <option value="">Select Audit Term</option>
                                        @php
                                            $currentYear = date('Y');
                                            $selectedTerm = $detail->audit_term ?? '';
                                        @endphp

                                        @for ($year = $currentYear - 2; $year <= $currentYear + 3; $year++)
                                            @php
                                                $nextYear = $year + 1;
                                                $range = $year . '-' . $nextYear;
                                            @endphp

                                            <option value="{{ $range }}" {{ $selectedTerm == $range ? 'selected' : '' }}>
                                                {{ $range }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Faculty</label>
                                    <select name="audits[{{ $index }}][faculty_id]" class="select2 form-select faculty-select">
                                        <option value="">Select Faculty</option>
                                        @foreach(get_faculties() as $faculty)
                                            <option value="{{ $faculty->id }}" 
                                                {{ $detail->faculty_id == $faculty->id ? 'selected' : '' }}>
                                                {{ $faculty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Department</label>
                                    <select name="audits[{{ $index }}][department_id]" class="select2 form-select department-select">
                                        <option value="">Select Department</option>
                                        @if($detail->department)
                                            <option value="{{ $detail->department->id }}" selected>
                                                {{ $detail->department->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Program</label>
                                    <select name="audits[{{ $index }}][program_id]" class="select2 form-select program-select">
                                        <option value="">Select Program</option>
                                        @if($detail->program)
                                            <option value="{{ $detail->program->id }}" selected>
                                                {{ $detail->program->program_name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Program Level</label>
                                    <select name="audits[{{ $index }}][program_level]" class="form-select">
                                        <option value="">Select Level</option>
                                        <option value="UG" {{ $detail->program_level == 'UG' ? 'selected' : '' }}>UG</option>
                                        <option value="PG" {{ $detail->program_level == 'PG' ? 'selected' : '' }}>PG</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Total QEC Audit Rating Score</label>
                                    <input type="number" name="audits[{{ $index }}][total_score]" 
                                           class="form-control"
                                           value="{{ $detail->total_score }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Score Obtained</label>
                                    <input type="number" name="audits[{{ $index }}][obtained_score]" 
                                           class="form-control"
                                           value="{{ $detail->obtained_score }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Strength</label>
                                    <input type="text" name="audits[{{ $index }}][strenght]" 
                                           class="form-control"
                                           value="{{ $detail->strenght }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Area of Improvement</label>
                                    <input type="text" name="audits[{{ $index }}][area_of_improvement]" 
                                           class="form-control"
                                           value="{{ $detail->area_of_improvement }}">
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger remove-group">Remove</button>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-primary" id="addAudit">
                            Add More
                        </button>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control" 
                            style="height:120px;">{{ $audit->remarks }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            UPDATE
                        </button>
                    </div>

                </form>

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
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script>
    let index = {{ $audit->details->count() }};
    let faculties = @json(get_faculties());

    $(document).ready(function() {

        initSelect2();

        // ADD MORE FUNCTION
        $('#addAudit').click(function() {
            addAuditGroup();
        });

        // REMOVE GROUP
        $(document).on('click', '.remove-group', function() {
            $(this).closest('.past-group').remove();
        });

        // CASCADING: Faculty → Department
        $(document).on('change', '.faculty-select', function() {
            let facultyId = $(this).val();
            let group = $(this).closest('.past-group');
            let deptSelect = group.find('.department-select');
            let progSelect = group.find('.program-select');

            deptSelect.html('<option value="">Loading...</option>');
            progSelect.html('<option value="">Select Program</option>');

            if (facultyId) {
                $.ajax({
                    url: '/get-departments/' + facultyId,
                    type: 'GET',
                    success: function(data) {
                        let options = '<option value="">Select Department</option>';
                        data.forEach(function(dept) {
                            options += `<option value="${dept.id}">${dept.name}</option>`;
                        });
                        deptSelect.html(options);
                    }
                });
            } else {
                deptSelect.html('<option value="">Select Department</option>');
            }
        });

        // CASCADING: Department → Program
        $(document).on('change', '.department-select', function() {
            let deptId = $(this).val();
            let group = $(this).closest('.past-group');
            let progSelect = group.find('.program-select');

            progSelect.html('<option value="">Loading...</option>');

            if (deptId) {
                $.ajax({
                    url: '/get-programs/' + deptId,
                    type: 'GET',
                    success: function(data) {
                        let options = '<option value="">Select Program</option>';
                        data.forEach(function(prog) {
                            options += `<option value="${prog.id}">${prog.program_name}</option>`;
                        });
                        progSelect.html(options);
                    }
                });
            } else {
                progSelect.html('<option value="">Select Program</option>');
            }
        });

        // SUBMIT UPDATE FORM
        $('#editForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('qec-audit-rating.update', $audit->id) }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    Swal.fire('Success', res.message, 'success')
                        .then(() => {
                            window.location.href = "{{ route('qec-audit-rating.index') }}";
                        });
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            });
        });

    });

    // ===============================
    // ADD AUDIT GROUP FUNCTION
    // ===============================
    function addAuditGroup(audit = null) {

        let facultyOptions = '<option value="">Select Faculty</option>';
        faculties.forEach(function(fac) {
            facultyOptions += `<option value="${fac.id}">${fac.name}</option>`;
        });
        let currentYear = new Date().getFullYear();
        let auditTermOptions = '<option value="">Select Audit Term</option>';

        for (let year = currentYear - 2; year <= currentYear + 3; year++) {
            let nextYear = year + 1;
            let range = `${year}-${nextYear}`;
            auditTermOptions += `<option value="${range}">${range}</option>`;
        }

        let group = `
<div class="past-group row g-3 mb-3 border p-3 mt-3 rounded">

<div class="col-md-4">
<label class="form-label">Audit Term</label>
<select name="audits[${index}][audit_term]" class="form-select">
${auditTermOptions}
</select>
</div>

<div class="col-md-4">
<label class="form-label">Faculty</label>
<select name="audits[${index}][faculty_id]" class="select2 form-select faculty-select">
${facultyOptions}
</select>
</div>

<div class="col-md-4">
<label class="form-label">Department</label>
<select name="audits[${index}][department_id]" class="select2 form-select department-select">
<option value="">Select Department</option>
</select>
</div>

<div class="col-md-4">
<label class="form-label">Program</label>
<select name="audits[${index}][program_id]" class="select2 form-select program-select">
<option value="">Select Program</option>
</select>
</div>

<div class="col-md-4">
<label class="form-label">Program Level</label>
<select name="audits[${index}][program_level]" class="form-select">
<option value="">Select Level</option>
<option value="UG">UG</option>
<option value="PG">PG</option>
</select>
</div>

<div class="col-md-4">
<label class="form-label">Total QEC Audit Rating Score</label>
<input type="number" name="audits[${index}][total_score]" class="form-control" value="${audit?.total_score ?? ''}">
</div>

<div class="col-md-4">
<label class="form-label">Score Obtained</label>
<input type="number" name="audits[${index}][obtained_score]" class="form-control" value="${audit?.obtained_score ?? ''}">
</div>

<div class="col-md-4">
<label class="form-label">Strength</label>
<input type="text" name="audits[${index}][strenght]" class="form-control" value="${audit?.strenght ?? ''}">
</div>

<div class="col-md-4">
<label class="form-label">Area of Improvement</label>
<input type="text" name="audits[${index}][area_of_improvement]" class="form-control" value="${audit?.area_of_improvement ?? ''}">
</div>

<div class="col-md-12">
<button type="button" class="btn btn-danger remove-group">Remove</button>
</div>
</div>`;

        $('#author-past-container').append(group);

        initSelect2();

        if (audit) {

            $(`[name="audits[${index}][audit_term]"]`).val(auditTerm).trigger('change');
            $(`[name="audits[${index}][faculty_id]"]`).val(audit.faculty_id).trigger('change');

            setTimeout(function() {
                $(`[name="audits[${index}][department_id]"]`).val(audit.department_id).trigger('change');

                setTimeout(function() {
                    $(`[name="audits[${index}][program_id]"]`).val(audit.program_id).trigger('change');
                }, 500);

            }, 500);

            $(`[name="audits[${index}][program_level]"]`).val(audit.program_level);
            $(`[name="audits[${index}][strenght]"]`).val(audit.strenght);
            $(`[name="audits[${index}][area_of_improvement]"]`).val(audit.area_of_improvement);
        }

        index++;
    }

    // ===============================
    // INIT SELECT2
    // ===============================
    function initSelect2() {
        $('.select2').select2({ width: '100%' });
    }
    </script>
@endpush

