@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <style>
        .past-group {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>QEC Audit Rating</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#auditModal">Add
                    Audit</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="auditTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Audit Term</th>
                                <th>Faculty</th>
                                <th>Department</th>
                                <th>Program</th>
                                <th>Total Score</th>
                                <th>Score Obtained</th>
                                <th>Strength</th>
                                <th>Area of Improvement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="auditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-white bg-primary">
                    <h5 class="modal-title">Add/Edit Audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="qecAuditForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="indicator_id" value="{{ $indicatorId }}">
                        <div id="auditContainer">

                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" id="addAuditGroup" class="btn btn-secondary">Add Another Audit</button>
                            <button type="submit" class="btn btn-success">Save Audit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <script>
        let auditIndex = 0;
        let faculties = @json(get_faculties());

        // Initialize Select2
        function initSelect2(context) {
            $(context || document).find('.select2').select2({ width: '100%' });
        }

        // Bind cascading selects
        function bindCascading(group) {
            group.find('.faculty-select').off('change').on('change', function () {
                let facultyId = $(this).val();
                let departmentSelect = $(this).closest('.past-group').find('.department-select');
                let programSelect = $(this).closest('.past-group').find('.program-select');
                departmentSelect.html('<option>Loading...</option>'); programSelect.html('<option>Select Program</option>');
                if (facultyId) {
                    $.get("/get-departments/" + facultyId, function (data) {
                        departmentSelect.html('<option value="">Select Department</option>');
                        data.forEach(d => departmentSelect.append(`<option value="${d.id}">${d.name}</option>`));
                    });
                } else departmentSelect.html('<option value="">Select Department</option>');
            });

            group.find('.department-select').off('change').on('change', function () {
                let deptId = $(this).val();
                let programSelect = $(this).closest('.past-group').find('.program-select');
                programSelect.html('<option>Loading...</option>');
                if (deptId) {
                    $.get("/get-programs/" + deptId, function (data) {
                        programSelect.html('<option value="">Select Program</option>');
                        data.forEach(p => programSelect.append(`<option value="${p.id}">${p.program_name}</option>`));
                    });
                } else programSelect.html('<option value="">Select Program</option>');
            });
        }

        // Add audit group
        function addAuditGroup(audit = null) {
            let group = $(`
                                    <div class="past-group row g-3">
                                        <input type="hidden" name="audits[${auditIndex}][id]" class="audit-id">
                                        <div class="col-md-3">
                                            <label class="form-label">Audit Term</label>
                                            <select name="audits[${auditIndex}][audit_term]" class="form-select audit-term">
                                                <option value="">Select</option>
                                                <option value="2021-2022">2021-2022</option>
                                                <option value="2022-2023">2022-2023</option>
                                                <option value="2023-2024">2023-2024</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Faculty</label>
                                            <select name="audits[${auditIndex}][faculty_id]" class="form-select select2 faculty-select">
                                                <option value="">Select Faculty</option>
                                                ${faculties.map(f => `<option value="${f.id}">${f.name}</option>`).join('')}
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Department</label>
                                            <select name="audits[${auditIndex}][department_id]" class="form-select select2 department-select">
                                                <option value="">Select Department</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Program</label>
                                            <select name="audits[${auditIndex}][program_id]" class="form-select select2 program-select">
                                                <option value="">Select Program</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Total Score</label>
                                            <input type="number" name="audits[${auditIndex}][total_score]" class="form-control total-score">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Score Obtained</label>
                                            <input type="number" name="audits[${auditIndex}][obtained_score]" class="form-control obtained-score">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Strength</label>
                                            <input type="text" name="audits[${auditIndex}][strength]" class="form-control strength">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Area of Improvement</label>
                                            <input type="text" name="audits[${auditIndex}][area_of_improvement]" class="form-control area-of-improvement">
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-danger remove-past">Remove</button>
                                        </div>
                                    </div>
                                `);

            if (audit) {
                group.find('.audit-id').val(audit.id);
                group.find('.audit-term').val(audit.audit_term);
                group.find('.total-score').val(audit.total_score);
                group.find('.obtained-score').val(audit.obtained_score);
                group.find('.strength').val(audit.strength);
                group.find('.area-of-improvement').val(audit.area_of_improvement);
                group.find('.faculty-select').val(audit.faculty_id).trigger('change');

                setTimeout(() => {
                    group.find('.department-select').val(audit.department_id).trigger('change');
                    setTimeout(() => {
                        group.find('.program-select').val(audit.program_id).trigger('change');
                    }, 300);
                }, 300);
            }

            $('#auditContainer').append(group);
            initSelect2(group);
            bindCascading(group);

            auditIndex++;
        }

        $(document).ready(function () {
            fetchAudits();

            $('#addAuditGroup').on('click', function () { addAuditGroup(); });

            $(document).on('click', '.remove-past', function () {
                $(this).closest('.past-group').remove();
            });

            // Edit audit
            $(document).on('click', '.edit-audit-btn', function () {
                let audit = $(this).data('audit');
                $('#auditContainer').html('');
                auditIndex = 0;
                if (audit.details && audit.details.length) {
                    audit.details.forEach(d => addAuditGroup(d));
                } else {
                    addAuditGroup(audit);
                }
                $('#auditModal').modal('show');
            });

            // Delete audit
            $(document).on('click', '.delete-audit-btn', function () {
                let id = $(this).data('id');
                if (!confirm('Are you sure?')) return;
                $.ajax({
                    url: `/qec-audit-rating/${id}`,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    success: function () { fetchAudits(); },
                    error: function () { alert('Failed to delete'); }
                });
            });

            // Submit form
            $('#qecAuditForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                Swal.fire({ title: 'Submitting...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                $.ajax({
                    url: "{{ route('qec-audit-rating.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        Swal.close();
                        Swal.fire('Success', res.message, 'success');
                        $('#auditModal').modal('hide');
                        fetchAudits();
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            });
        });

        // Fetch audits for table
        function fetchAudits() {
            $.get("{{ route('qec-audit-rating.index') }}", function (res) {
                const tableData = res.audits.map((audit, i) => [
                    i + 1,
                    audit.audit_term,
                    audit.faculty_name,
                    audit.department_name,
                    audit.program_name,
                    audit.total_score,
                    audit.obtained_score,
                    audit.strength,
                    audit.area_of_improvement,
                    `<button class="btn btn-outline-primary edit-audit-btn" data-audit='${JSON.stringify(audit)}'>Edit</button>
                                         <button class="btn btn-outline-danger delete-audit-btn" data-id="${audit.id}">Delete</button>`
                ]);

                if (!$.fn.DataTable.isDataTable('#auditTable')) {
                    $('#auditTable').DataTable({ data: tableData });
                } else {
                    $('#auditTable').DataTable().clear().rows.add(tableData).draw();
                }
            });
        }
    </script>
@endpush