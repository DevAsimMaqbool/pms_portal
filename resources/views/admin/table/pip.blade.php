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
                <table class="table border-top" id="pipTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Action Plan</th>
                            <th>Document</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!--/ Permission Table -->

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
    $(document).ready(function () {
        loadPipData();

        // 🔹 Event delegation for status dropdown change
        $(document).on("change", ".status-select", function () {
            updateStatus($(this).data("id"), $(this).val());
        });

        // 🔹 SweetAlert2 Image Preview
        $(document).on("click", ".doc-preview", function () {
            Swal.fire({
                title: "Document Preview",
                imageUrl: $(this).data("src"),
                imageWidth: 400,
                imageAlt: "Document",
                customClass: { confirmButton: "btn btn-primary" },
                buttonsStyling: false
            });
        });
    });

    // 🔹 Load Data into DataTable
    function loadPipData() {
        $.get("{{ route('pip.index') }}", function (data) {
            const rowData = data.map((s, i) => ([
                i + 1,
                s.description || 'N/A',
                renderDocument(s.document),
                renderStatusDropdown(s.id, s.status),
                formatDate(s.created_at)
            ]));

            $('#pipTable').DataTable({
                data: rowData,
                columns: [
                    { title: "#" },
                    { title: "Description" },
                    { title: "Document" },
                    { title: "Status" },
                    { title: "Created At" }
                ],
                destroy: true
            });
        }).fail(xhr => console.error("Error:", xhr.responseText));
    }

    // 🔹 Render Document Cell
    function renderDocument(documentPath) {
        if (!documentPath) return 'N/A';
        const ext = documentPath.split('.').pop().toLowerCase();
        const fileUrl = "/storage/" + documentPath;

        return ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)
            ? `<img src="${fileUrl}" alt="Document" width="60" height="60"
                     class="img-thumbnail doc-preview" style="cursor:pointer"
                     data-src="${fileUrl}">`
            : `<a href="${fileUrl}" target="_blank">View File</a>`;
    }

    // 🔹 Render Status Dropdown
    function renderStatusDropdown(id, status) {
        const options = {
            not_started: "Not Started",
            inprogress: "In Progress",
            completed: "Completed"
        };

        return `
            <select class="form-select form-select-sm status-select" data-id="${id}" id="status_${id}" name="status_${id}" >
                ${Object.entries(options).map(([value, label]) =>
                    `<option value="${value}" ${status === value ? "selected" : ""}>${label}</option>`
                ).join('')}
            </select>
        `;
    }

    // 🔹 Format Date
    function formatDate(dateStr) {
        return dateStr ? new Date(dateStr).toISOString().split('T')[0] : "N/A";
    }

    // 🔹 Update Status AJAX
    function updateStatus(id, newStatus) {
        $.ajax({
            url: "/pip/" + id + "/update-status", // custom route or use PUT /pip/{id}
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },
            success: function () {
                Swal.fire({
                    icon: "success",
                    title: "Status Updated",
                    text: "The status has been updated successfully.",
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                Swal.fire("Error", "Something went wrong!", "error");
                console.error(xhr.responseText);
            }
        });
    }
</script>

@endpush