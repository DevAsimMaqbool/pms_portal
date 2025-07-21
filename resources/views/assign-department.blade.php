@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Hidden Inputs for restoring selected IDs -->
        <input type="hidden" id="selected-faculty-id" value="{{ $selectedFacultyId ?? '' }}">
        <input type="hidden" id="selected-department-id" value="{{ $selectedDepartmentId ?? '' }}">
        <input type="hidden" id="selected-program-id" value="{{ $selectedProgramId ?? '' }}">

        <div class="card p-4">
            <h5 class="mb-3">Assign Faculty → Department → User</h5>

            <form id="mainForm" method="POST" action="{{ route('faculty.store') }}" class="row g-3">
                @csrf

                <div class="col-md-4">
                    <label class="form-label" for="faculty-dropdown">Faculty</label>
                    <select name="faculty_id" id="faculty-dropdown" class="form-select" required>
                        <option value="">Select Faculty</option>
                    </select>
                    @error('faculty_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="department-dropdown">Department</label>
                    <select name="department_id" id="department-dropdown" class="form-select" required>
                        <option value="">Select Department</option>
                    </select>
                    @error('department_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="program-dropdown">Program</label>
                    <select name="program_id" id="program-dropdown" class="form-select" required>
                        <option value="">Select Program</option>
                    </select>
                    @error('program_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({ width: '100%' });
            fetchFacultyData();
        });

        let facultiesData = [];

        function fetchFacultyData() {
            $.ajax({
                url: "{{ route('faculty.index') }}",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    facultiesData = response.faculties || [];
                    if (!facultiesData.length) return;

                    populateFacultyDropdown(facultiesData);
                    setupCascading('#faculty-dropdown', '#department-dropdown', '#program-dropdown');
                    restoreSelections();
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        }

        function populateFacultyDropdown(faculties) {
            const selectedFacultyId = $('#faculty-dropdown').val();
            let options = '<option value="">Select Faculty</option>';
            faculties.forEach(f => {
                options += `<option value="${f.id}">${f.name}</option>`;
            });
            $('#faculty-dropdown').html(options);

            if (selectedFacultyId) {
                $('#faculty-dropdown').val(selectedFacultyId).trigger('change');
            }
        }

        function setupCascading(facultySelector, deptSelector, programSelector) {
            $(facultySelector).off('change').on('change', function () {
                const facultyId = $(this).val();
                const selectedFaculty = facultiesData.find(f => String(f.id) === String(facultyId));

                let deptOptions = '<option value="">Select Department</option>';
                if (selectedFaculty && selectedFaculty.departments) {
                    selectedFaculty.departments.forEach(d => {
                        deptOptions += `<option value="${d.id}">${d.name}</option>`;
                    });
                } else {
                    deptOptions = '<option value="">No Departments Available</option>';
                }
                $(deptSelector).html(deptOptions).val('').trigger('change');

                $(programSelector).html('<option value="">Select Program</option>');
            });

            $(deptSelector).off('change').on('change', function () {
                const facultyId = $(facultySelector).val();
                const deptId = $(this).val();

                const selectedFaculty = facultiesData.find(f => String(f.id) === String(facultyId));
                const selectedDept = selectedFaculty ? selectedFaculty.departments.find(d => String(d.id) === String(deptId)) : null;

                let programOptions = '<option value="">Select Program</option>';
                if (selectedDept && selectedDept.programs) {
                    selectedDept.programs.forEach(p => {
                        programOptions += `<option value="${p.id}">${p.program_name}</option>`;
                    });
                } else {
                    programOptions = '<option value="">No Programs Available</option>';
                }
                $(programSelector).html(programOptions).val('');
            });
        }

        function restoreSelections() {
            const facultyId = $('#selected-faculty-id').val();
            const deptId = $('#selected-department-id').val();
            const programId = $('#selected-program-id').val();

            if (facultyId) {
                $('#faculty-dropdown').val(facultyId).trigger('change');

                const selectedFaculty = facultiesData.find(f => String(f.id) === String(facultyId));
                if (selectedFaculty && selectedFaculty.departments) {
                    let deptOptions = '<option value="">Select Department</option>';
                    selectedFaculty.departments.forEach(d => {
                        deptOptions += `<option value="${d.id}">${d.name}</option>`;
                    });
                    $('#department-dropdown').html(deptOptions);

                    if (deptId) {
                        $('#department-dropdown').val(deptId).trigger('change');

                        const selectedDept = selectedFaculty.departments.find(d => String(d.id) === String(deptId));
                        if (selectedDept && selectedDept.programs) {
                            let programOptions = '<option value="">Select Program</option>';
                            selectedDept.programs.forEach(p => {
                                programOptions += `<option value="${p.id}">${p.program_name}</option>`;
                            });
                            $('#program-dropdown').html(programOptions);

                            if (programId) {
                                $('#program-dropdown').val(programId).trigger('change');
                            }
                        }
                    }
                }
            }
        }
    </script>
@endpush