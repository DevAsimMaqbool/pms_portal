@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
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
                                <small class="mb-0">Total Users</small>
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
                            <option value="{{ $dept->name }}">{{ $dept->complete_name }}</option>
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
                            <select id="user-role" class="form-select" name="role">
                                <option value="">All</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="roleError"></div>
                        </div>
                        <!-- <div class="mb-6">
                                                                                            <label class="form-label" for="user-level">Select Level</label>
                                                                                            <select id="user-level" class="form-select" name="level" required>
                                                                                                <option value="Managerial">Managerial</option>
                                                                                                <option value="Operational">Operational</option>
                                                                                            </select>
                                                                                            <div class="invalid-feedback" id="levelError"></div>
                                                                                        </div> -->
                        <!-- <div class="mb-6">
                                                                                                            <label class="form-label" for="user-manager">Select Manager</label>
                                                                                                            <select id="user-manager" class="form-select" name="manager_id">
                                                                                                            </select>
                                                                                                            <div class="invalid-feedback" id="manager_idError"></div>
                                                                                                        </div> -->
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
    {{--
    <script src="{{ asset('admin/assets/js/app-user-list.js') }}"></script> --}}
@endpush
@push('script')
    <script>
        $('#offcanvasAddUser').on('hidden.bs.offcanvas', function () {
            $('#addNewUserForm')[0].reset();          // Reset form fields
            $('#adminuserId').val('');                // Clear hidden ID
            $('#nameError').hide().text('');          // Clear errors if any
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
        // function fetchUsers() {
        //     $.ajax({
        //         url: "{{ route('users.index') }}", // Your Laravel route
        //         method: "GET",
        //         dataType: "json",
        //         success: function (data) {
        //             const managerial_users = data.managerial_users;
        //             // Step 1: Create a map of employee_id => name
        //             const employeeIdToNameMap = {};
        //             managerial_users.forEach(user => {
        //                 employeeIdToNameMap[user.employee_id] = user.name;
        //             });
        //             // Step 2: Generate manager options using manager_id
        //             let manageruserOptions = '<option value="">Select Manager</option>';
        //             managerial_users.forEach(manageruser => {
        //                 const managerName = employeeIdToNameMap[manageruser.manager_id] || 'Unknown';
        //                 manageruserOptions += `<option value="${manageruser.manager_id}">${managerName}</option>`;
        //             });
        //             // Step 3: Inject into the select element
        //             $('#user-manager').html(manageruserOptions);
        //             const statusMap = {
        //                 pending: { title: "pending", class: "bg-label-warning" },
        //                 active: { title: "active", class: "bg-label-success" },
        //                 inactive: { title: "inactive", class: "bg-label-secondary" }
        //             };

        //             // Prepare rows
        //             const rowData = data.users.map((user, index) => {
        //                 const createdAt = new Date(user.created_at);
        //                 const formattedDate = createdAt.toISOString().split('T')[0];

        //                 // Example roles icons mapping (you can adjust)
        //                 const roleIcons = {
        //                     user: '<i class="icon-base ti tabler-user icon-md text-success me-2"></i>',
        //                     admin: '<i class="icon-base ti tabler-device-desktop icon-md text-danger me-2"></i>'
        //                 };

        //                 return {
        //                     id: user.id,
        //                     checkbox: '', // Checkbox rendered later
        //                     full_name: user.name,
        //                     email: user.email,
        //                     role: user.roles || "user", // default role if missing
        //                     department: user.department, // example, change as needed
        //                     level: user.level || "N/A", // example, change as needed
        //                     status: user.status || 2, // default Active if missing
        //                     created_at: formattedDate,
        //                     actions: '' // Actions rendered later
        //                 };
        //             });

        //             if ($.fn.DataTable.isDataTable('#userTable')) {
        //                 // If table exists, reload data
        //                 $('#userTable').DataTable().clear().rows.add(rowData).draw();
        //             } else {
        //                 // Initialize DataTable
        //                 $('#userTable').DataTable({
        //                     data: rowData,
        //                     columns: [
        //                         {
        //                             data: 'id',
        //                             orderable: false,
        //                             searchable: false,
        //                             className: 'control',
        //                             render: function () {
        //                                 return '';
        //                             }
        //                         },
        //                         {
        //                             data: null,
        //                             orderable: false,
        //                             searchable: false,
        //                             render: function (data) {
        //                                 return `<input type="checkbox" class="dt-checkboxes form-check-input" data-user-id="${data.id}">`;
        //                             }
        //                         },
        //                         {
        //                             data: null,
        //                             render: function (data) {
        //                                 return `<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar avatar-sm me-4"><span class="avatar-initial rounded-circle bg-label-primary">${data.full_name.charAt(0).toUpperCase()}</span></div></div><div class="d-flex flex-column"><a href="app-user-view-account.html" class="text-heading text-truncate"><span class="fw-medium">${data.full_name}</span></a><small>${data.email}</small></div></div>`;
        //                             }
        //                         },
        //                         {
        //                             data: 'role',
        //                             render: function (role) {
        //                                 const safeRole = role || 'user';
        //                                 let icon = '';

        //                                 if (safeRole == 'admin') {
        //                                     icon = '<i class="icon-base ti tabler-device-desktop icon-md text-danger me-2"></i>';
        //                                 } else if (safeRole == 'user') {
        //                                     icon = '<i class="icon-base ti tabler-user icon-md text-success me-2"></i>';
        //                                 } else {
        //                                     icon = '<i class="icon-base ti tabler-circle icon-md text-primary me-2"></i>'; // default or other role
        //                                 }

        //                                 return `<span class='text-truncate d-flex align-items-center text-heading'>${icon} ${safeRole}</span>`;
        //                             }
        //                         },
        //                         { data: 'department' },
        //                         { data: 'level' },
        //                         {
        //                             data: 'status',
        //                             render: function (status) {
        //                                 const s = statusMap[status] || statusMap['inactive']; // Default Active
        //                                 return `<span class="badge ${s.class}" text-capitalized>${s.title}</span>`;
        //                             }
        //                         },
        //                         {
        //                             data: null,
        //                             orderable: false,
        //                             searchable: false,
        //                             render: function (data) {
        //                                 return `<div class="d-flex align-items-center"><a href="javascript:;" class="btn btn-text-secondary rounded-pill waves-effect btn-icon" onclick="editUser(${data.id})"><i class="icon-base ti tabler-edit icon-22px"></i></a><a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="deleteUser(${data.id})"><i class="icon-base ti tabler-trash icon-md"></i></a><a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" href="/user_report/${data.id}" target="_blank"><i class="icon-base ti tabler-eye icon-md"></i></a></div>`;
        //                             }
        //                         }
        //                     ],
        //                     order: [[2, 'asc']],

        //                     layout: {
        //                         topStart: {
        //                             rowClass: "row m-3 my-0 justify-content-between",
        //                             features: [
        //                                 {
        //                                     pageLength: {
        //                                         menu: [10, 25, 50, 100],
        //                                         text: "Show _MENU_"
        //                                     }
        //                                 },
        //                                 {
        //                                     buttons: [
        //                                         {
        //                                             text: '<span class="d-flex align-items-center gap-2">' +
        //                                                 '<i class="icon-base ti tabler-plus icon-xs"></i>' +
        //                                                 '<span class="d-none d-sm-inline-block">Add New User</span>' +
        //                                                 '</span>',
        //                                             className: "add-new btn btn-primary",
        //                                             attr: {
        //                                                 "data-bs-toggle": "offcanvas",
        //                                                 "data-bs-target": "#offcanvasAddUser"
        //                                             }
        //                                         }
        //                                     ]
        //                                 }
        //                             ]
        //                         }
        //                     }

        //                 });
        //                 // Append custom department filter manually
        //                 setTimeout(() => {
        //                     const $topStartRow = $('#userTable_wrapper .row.m-3');
        //                     const $firstCol = $topStartRow.children('.col-auto, .col-md-auto').first();

        //                     // Extract unique department names
        //                     const departments = [...new Set(rowData.map(user => user.department).filter(Boolean))].sort();
        //                     let departmentOptions = '<option value="">All Departments</option>';
        //                     departments.forEach(dept => {
        //                         departmentOptions += `<option value="${dept}">${dept}</option>`;
        //                     });

        //                     // Create and insert the dropdown
        //                     const $departmentCol = $(`<div class="col-md-auto mt-2 mt-md-0 align-self-center"><select id="departmentFilter" class="form-select">${departmentOptions}</select></div>`);

        //                     $firstCol.after($departmentCol);

        //                     // Apply filter on change
        //                     $('#departmentFilter').on('change', function () {
        //                         const val = $(this).val();
        //                         $('#userTable').DataTable().column(4).search(val).draw(); // 4 = department column index
        //                     });
        //                 }, 0);


        //             }
        //         },
        //         error: function (xhr) {
        //             console.error("Error fetching user data:", xhr.responseText);
        //         }
        //     });
        // }
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
                if (roles.length > 0) {
                    $('#user-role').val(roles[0]);
                } else {
                    $('#user-role').val('');
                }
                //$('#user-level').val(user.level);
                //$('#user-manager').val(user.manager_id);
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