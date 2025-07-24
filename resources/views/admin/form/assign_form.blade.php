@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/@form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Assign Forms to Users</h5><br>

                {{-- User Filter --}}
                <div class="mb-3">
                    <label for="userFilter">Select User:</label>
                    <select id="userFilter" class="select2 select-event-guests form-select" name="eventGuests" multiple>
                        <option value="">All</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-datatable">
                <table class="table" id="formTable">
                    <thead class="border-top">
                        <tr>
                            <th>Sr#</th>
                            <th>User Name</th>
                            <th><input type="checkbox" class="dt-checkboxes form-check-input" id="checkall">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $form)
                            <tr>
                                <td>{{ $form->id }}</td>
                                <td>{{ $form->title }}</td>
                                <td><input type="checkbox" name="check-{{ $form->id }}" class="dt-checkboxes form-check-input"
                                        data-user-id="{{ $form->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-end me-4 mb-2">
                <button class="btn btn-primary" id="saveAssignments">Save Assignments</button>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('admin/assets/js/extended-ui-sweetalert2.js') }}"></script>
@endpush
@push('script')
    <script>
        $(document).ready(function () {
            // Initialize select2
            $('#userFilter').select2({
                placeholder: "Select user(s)",
                allowClear: true
            });

            // Check All functionality
            $('#checkall').on('change', function () {
                $('.dt-checkboxes').prop('checked', $(this).prop('checked'));
            });

            // Save button listener
            $('#saveAssignments').on('click', function () {
                let selectedUsers = $('#userFilter').val(); // array of user IDs
                let selectedForms = [];

                $('.dt-checkboxes:checked').each(function () {
                    selectedForms.push($(this).closest('tr').find('td:first').text().trim());
                });

                if (selectedUsers.length === 0 || selectedForms.length === 0) {
                    alert("Please select at least one user and one form.");
                    return;
                }

                // Send via AJAX (assumes you have route setup)
                $.ajax({
                    url: '{{ route('forms.assign') }}',
                    method: 'POST',
                    data: {
                        users: selectedUsers,
                        forms: selectedForms,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire('Success', response.message, 'success');
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                });
            });
        });
    </script>
@endpush