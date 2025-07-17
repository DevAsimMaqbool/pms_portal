@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-4">
            <h5 class="mb-3">Assign Faculty → Department → User</h5>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="mainForm" method="POST" action="{{ route('assigndepartment.store') }}" class="row g-3">
                @csrf

                <div class="col-md-4">
                    <label class="form-label" for="faculty-dropdown">Faculty</label>
                    <select name="faculty_id" id="faculty-dropdown" class="form-select select2" required>
                        <option value="">Select Faculty</option>
                    </select>
                    @error('faculty_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="department-dropdown">Department</label>
                    <select name="department_id" id="department-dropdown" class="form-select select2" required>
                        <option value="">Select Department</option>
                    </select>
                    @error('department_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="user-dropdown">User</label>
                    <select name="user_id" id="user-dropdown" class="form-select select2" required>
                        <option value="">Select User</option>
                    </select>
                    @error('user_id')
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let facultiesData = [];

        $(document).ready(function () {
            fetchFormData();

            $('#faculty-dropdown').on('change', function () {
                populateDepartmentDropdown();
            });
        });

        function fetchFormData() {
            $.ajax({
                url: "{{ route('assigndepartment.index') }}",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    console.log(response.users);
                    facultiesData = response.faculties || [];
                    let usersData = response.users || [];

                    populateFacultyDropdown(facultiesData);
                    populateUserDropdown(usersData);
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                    alert('Failed to load data. Please try again.');
                }
            });
        }

        function populateFacultyDropdown(faculties) {
            let options = '<option value="">Select Faculty</option>';
            faculties.forEach(function (faculty) {
                options += `<option value="${faculty.id}">${faculty.name}</option>`;
            });
            $('#faculty-dropdown').html(options).trigger('change');
        }

        function populateDepartmentDropdown() {
            const facultyId = $('#faculty-dropdown').val();
            let options = '<option value="">Select Department</option>';

            const selectedFaculty = facultiesData.find(f => String(f.id) === String(facultyId));
            if (selectedFaculty && selectedFaculty.departments && selectedFaculty.departments.length) {
                selectedFaculty.departments.forEach(function (dept) {
                    options += `<option value="${dept.id}">${dept.name}</option>`;
                });
            } else {
                options = '<option value="">No Departments Available</option>';
            }

            $('#department-dropdown').html(options).trigger('change');
        }

        function populateUserDropdown(users) {
            let options = '<option value="">Select User</option>';
            users.forEach(function (user) {
                options += `<option value="${user.id}">${user.name} (${user.email})</option>`;
            });
            $('#user-dropdown').html(options).trigger('change');
        }
    </script>
@endpush