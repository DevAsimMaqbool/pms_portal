@extends('layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top" id="roleTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!--/ Permission Table -->

        <!-- Modal -->
        <!-- Add Permission Modal -->

        <div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                            <h4 class="role-title">Add New Role</h4>
                            <p class="text-body-secondary">Set role permissions</p>
                        </div>
                        <!-- Add role form -->
                        <form id="roleForm" class="row">
                            <input type="hidden" id="role_id">
                            <div class="col-12 form-control-validation mb-3">
                                <label class="form-label" for="user-role">Role Name</label>
                                <input type="text" id="user-role" name="name" class="form-control"
                                    placeholder="Enter a role name" tabindex="-1" />
                                <div class="invalid-feedback" id="user-roleError"></div>
                            </div>
                            <div class="col-12">
                                <!-- Permission table -->
                                <!-- <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody id="permissionsTableBody">
                                                <tr id="AccessId">
                                                    <td class="text-nowrap fw-medium">
                                                        Select Permissions
                                                        <i class="icon-base ti tabler-info-circle icon-xs"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Allows a full access to the system"></i>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-end">
                                                            <div class="form-check mb-0">

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div> -->
                                <!-- Permission table -->
                            </div>
                            <div class="col-12 text-center demo-vertical-spacing">
                                <button type="submit" class="btn btn-primary me-sm-4 me-1">Save</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">Discard</button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Permission Modal -->


        <!-- /Modal -->
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
@endpush
@push('script')
    <script>
        const modal = new bootstrap.Modal(document.getElementById('roleModal'));
        $('#roleModal').on('show.bs.modal', function () {
            $.get('{{ route('roles.permissions.list') }}', function (response) {
                if (response.success) {
                    let rows = '';
                    response.data.forEach(function (permission) {
                        rows += `
                                    <tr>
                                        <td class="text-nowrap fw-medium text-heading">${permission.name.replace(/_/g, ' ').toUpperCase()}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check mb-0 me-4 me-lg-12">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="${permission.name}" id="perm_${permission.id}">
                                                    <label class="form-check-label" for="perm_${permission.id}">Assign</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`;
                    });

                    // Insert AFTER the AccessId row
                    $('#AccessId').after(rows);
                }
            });
        });
        let isEdit = false;

        function fetchRole() {
            $.ajax({
                url: "{{ route('user-role.index') }}",
                method: "GET",
                dataType: "json",
                success: function (data) {

                    const rowData = data.map((s, i) => {
                        const createdAt = new Date(s.created_at);
                        const formattedDate = createdAt.toISOString().split('T')[0];
                        return [
                            i + 1,
                            s.name || 'N/A',
                            formattedDate,
                            `<div class="d-flex align-items-center"><a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="editRole(${s.id})"><i class="icon-base ti tabler-edit icon-22px"></i></a><a class="btn btn-icon btn-text-secondary rounded-pill waves-effect" onclick="deleteRole(${s.id})"><i class="icon-base ti tabler-trash icon-md"></i></a></div>`
                        ];
                    });

                    // Initialize DataTable only once
                    if (!$.fn.DataTable.isDataTable('#roleTable')) {
                        window.roleTable = $('#roleTable').DataTable({
                            processing: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            data: rowData,
                            columns: [
                                { title: "#" },
                                { title: "Name" },
                                { title: "Created Date" },
                                { title: "Actions", orderable: false }
                            ],
                            layout: {
                                topStart: {
                                    rowClass: "row m-3 my-0 justify-content-between",
                                    features: [
                                        {
                                            pageLength: {
                                                menu: [10, 25, 50, 100],
                                                text: "Show _MENU_"
                                            }
                                        },
                                        {
                                            buttons: [
                                                {
                                                    text: '<i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i> <span class="d-none d-sm-inline-block">Add Role</span>',
                                                    className: "btn",
                                                    action: function () {
                                                        openRoleModal();
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                }
                            }
                        });
                    } else {
                        // If already initialized, just refresh data
                        window.roleTable.clear().rows.add(rowData).draw();
                    }
                },
                error: function (xhr) {
                    console.error("Error fetching complaint:", xhr.responseText);
                }
            });
        }

        function openRoleModal() {
            isEdit = false;
            $('#modalTitle').text('Add Role');
            $('#roleForm')[0].reset();
            $('#role_id').val('');
            $('.invalid-feedback').text('');
            modal.show();
        }

        function editRole(id) {
            isEdit = true;
            $.get(`/user-role/${id}/edit`, function (data) {
                $('#role_id').val(data.id);
                $('#user-role').val(data.name);
                $('#modalTitle').text('Edit Role');
                $('.invalid-feedback').text('');
                modal.show();
            });
        }

        $('#roleForm').submit(function (e) {
            e.preventDefault();
            const id = $('#role_id').val();
            const url = isEdit ? `/user-role/${id}` : "{{ route('user-role.store') }}";
            const method = isEdit ? 'PUT' : 'POST';
            const message = isEdit ? 'Updated successfully!' : 'Added successfully!';
            const formData = {
                _token: "{{ csrf_token() }}",
                _method: method,
                name: $('#user-role').val()
            };
            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function (res) {
                    $('#roleForm')[0].reset();
                    $('#role_id').val('');
                    modal.hide();
                    Swal.fire({
                        title: message,
                        icon: "success",
                        customClass: {
                            confirmButton: "btn btn-primary waves-effect waves-light"
                        },
                        buttonsStyling: !1
                    });
                    fetchRole();
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $(`#${key}Error`).text(value[0]).show();
                    });
                }
            });
        });
        function deleteRole(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/user-role/${id}`,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: 'DELETE'
                        },
                        success: function (res) {
                            fetchRole(); // Refresh the table
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Role has been deleted.',
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
            fetchRole();
        });
    </script>
@endpush