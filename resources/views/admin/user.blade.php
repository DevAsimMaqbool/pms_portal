@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/tagify/tagify.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6 mb-6">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <!-- <span class="text-heading">Total</span> -->
                                <div class="d-flex align-items-center my-1">
                                    <h4 class="text-success mb-0 me-2">{{ $totalUsers }}</h4>
                                    <!-- <p class="text-success mb-0">(+29%)</p> -->
                                </div>
                                <small class="mb-0">Team Members</small>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="icon-base ti tabler-user icon-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Users</h5>
                {{-- Department Filter --}}
                <div class="mb-3">
                    <label for="departmentFilter">Filter by Department:</label>
                    <select id="departmentFilter" class="form-select w-auto d-inline-block ms-2">
                        <option value="">All</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-datatable">
                <table class="table" id="userTable">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Job Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Offcanvas to add new user -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
                aria-labelledby="offcanvasAddUserLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                    <form class="add-new-user pt-0" id="addNewUserForm">
                        <input type="hidden" id="adminuserId">
                        <div class="mb-6 form-control-validation">
                            <label class="form-label" for="add-user-fullname">Full Name</label>
                            <input type="text" class="form-control" id="add-user-fullname" placeholder="Add Name"
                                name="name" required readonly />
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="mb-6 form-control-validation">
                            <label class="form-label" for="add-user-email">Email</label>
                            <input type="text" id="add-user-email" class="form-control" placeholder="example@gmail.com"
                                name="email" required readonly />
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="add-user-employee-code">Employee Code</label>
                            <input type="text" id="add-user-employee-code" class="form-control" placeholder="12345"
                                name="employee_code" required readonly />
                            <div class="invalid-feedback" id="employee_codeError"></div>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="add-user-department">Department</label>
                            <input type="text" id="add-user-department" class="form-control" placeholder="MIS"
                                aria-label="jdoe1" name="department" required readonly />
                            <div class="invalid-feedback" id="departmentError"></div>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="user-role">User Role</label>
                            <select id="user-role" class="form-select select2" name="role[]" multiple>
                                <option value="">All</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="roleError"></div>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="user-status">Select Status</label>
                            <select id="user-status" class="form-select" name="status" required readonly>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback" id="statusError"></div>
                        </div>
                        <button type="submit" class="btn btn-primary me-3 data-submit">Submit</button>
                        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
@push('script')

    <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/%40form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/tagify/tagify.js') }}"></script>
    {{--
    <script src="{{ asset('admin/assets/js/app-user-list.js') }}"></script> --}}
@endpush
@push('script')
    <script>
        $('#offcanvasAddUser').on('hidden.bs.offcanvas', function () {
            $('#addNewUserForm')[0].reset();          // Reset form fields
            $('#adminuserId').val('');                // Clear hidden ID
            $('#nameError').hide().text('');          // Clear errors if any
            $('#user-role').val(null).trigger('change');
        })
        $(document).ready(function () {
            const table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.index') }}",
                    data: function (d) {
                        d.department = $('#departmentFilter').val();
                    }
                },
                columns: [
                    { data: 'id', orderable: false, searchable: false, className: 'control', render: () => '' },
                    { data: 'checkbox', orderable: false, searchable: false },
                    { data: 'full_name', name: 'name' },
                    { data: 'role', name: 'roles.name' },
                    { data: 'department', name: 'department' },
                    { data: 'job_title', name: 'job_title' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                order: [[2, 'asc']],
            });

            // Re-draw table when department filter changes
            $('#departmentFilter').on('change', function () {
                table.draw();
            });
        });
        $('#addNewUserForm').submit(function (e) {
            e.preventDefault();
            const isEdit = $('#adminuserId').val() !== '';
            const id = $('#adminuserId').val();
            const url = isEdit ? `/users/${id}` : "{{ route('users.store') }}";
            const method = isEdit ? 'PUT' : 'POST';
            const formData = {
                _token: "{{ csrf_token() }}",
                _method: method,
                name: $('#add-user-fullname').val(),
                email: $('#add-user-email').val(),
                employee_code: $('#add-user-employee-code').val(),
                department: $('#add-user-department').val(),
                role: $('#user-role').val(),
                //level: $('#user-level').val(),
                // manager_id: $('#user-manager').val(),
                status: $('#user-status').val()
            };
            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function (res) {
                    Swal.fire({
                        title: "Role Assigned Successfully",
                        icon: "success",
                        customClass: {
                            confirmButton: "btn btn-primary waves-effect waves-light"
                        },
                        buttonsStyling: !1
                    });
                    $('#addNewUserForm')[0].reset();
                    $('#adminuserId').val('');

                    // ✅ Close Bootstrap 5 Offcanvas
                    let offcanvasEl = document.getElementById('offcanvasAddUser');
                    let offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
                    if (offcanvasInstance) {
                        offcanvasInstance.hide();
                    }
                    fetchUsers();
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $(`#${key}Error`).text(value[0]).show();
                    });
                }
            });
        });
        function editUser(id) {
            $.get(`/users/${id}/edit`, function (data) {
                const user = data.user;
                const roles = data.roles;

                $('#adminuserId').val(user.id);
                $('#add-user-fullname').val(user.name);
                $('#add-user-email').val(user.email);
                $('#add-user-employee-code').val(user.barcode);
                $('#add-user-department').val(user.department);

                // ✅ MULTIPLE ROLES SET
                $('#user-role').val(roles).trigger('change');

                $('#user-status').val(user.status);

                $('#offcanvasAddUserLabel').text('Edit User');

                const offcanvas = new bootstrap.Offcanvas('#offcanvasAddUser');
                offcanvas.show();
            });
        }
        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/users/${id}`,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function (res) {
                            fetchUsers(); // Refresh the table
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The user has been deleted.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong while deleting.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }



        $(document).ready(function () {
            fetchUsers();
        });

    </script>
@endpush