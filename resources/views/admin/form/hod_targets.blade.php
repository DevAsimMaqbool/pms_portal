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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Permission Table -->
        <div class="card mb-6">
            <h5 class="card-header">Target Assign</h5>
            <form class="card-body" id="researchForm2">
             @csrf
                <input type="hidden"  id="form_status" name="form_status" value="OTHER" required>
                <div class="row g-6">
                    <div class="col-md-4">
                        <label class="form-label" for="indicator_id">Select Indicator</label>
                        <select id="indicator_id" class="select2 form-select" data-allow-clear="true" name="indicator_id[]"
                            multiple required>
                            <option value="135"># of Grant Proposals Submitted</option>
                            <option value="136">Multidisciplinary Projects</option>
                            <option value="137">Commercial Consultancy/Research Income</option>
                            <option value="138">Patents/Intellectual Property (IPR)</option>
                            <option value="198">Industrial Projects</option>
                            <option value="199">Products Delivered to Industry</option>
                            <option value="194">Number of Knowledge Products</option>
                            <option value="155">No of Professional Memberships attained vs targets</option>
                        </select>
                        <div class="invalid-feedback" id="indicatorError"></div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="target">Target</label>
                        <input type="number" id="target" name="target" class="form-control" placeholder="1">
                        <div class="invalid-feedback" id="targetError"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="multicol-language">Name of Faculty Member</label>
                         <select  name="faculty_member_id[]" id="select2Success" class="select2 form-select"  multiple required>
                                <option value="">-- Select Faculty Member --</option>
                                @foreach($facultyMembers as $member)
                                    <option 
                                        value="{{ $member->id }}" 
                                        data-department="{{ $member->department }}" 
                                        data-job_title="{{ $member->job_title }}">
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4 waves-effect waves-light">Submit</button>
                    <button type="reset" class="btn btn-label-secondary waves-effect">Cancel</button>
                </div>
            </form>
        </div>
        <!--/ Permission Table -->
         <div class="card mb-6">
            <div class="table-responsive text-nowrap">
               <table id="complaintTable3" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Indicator</th>
                                        <th>Target</th>
                                    </tr>
                                </thead>
                            </table>
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
    @if(auth()->user()->hasRole(['HOD']))
    <script>
    function fetchTarget() {
                $.ajax({
                    url: "{{ route('faculty-target.index') }}",
                    method: "GET",
                    data: {
                        status: "OTHER" // you can send more values
                    },
                    dataType: "json",
                    success: function (data) {
                        //alert(data.forms);
                        const forms = data.forms || [];

                        const rowData = forms.map((form, i) => {
                            const createdAt = form.created_at
                                ? new Date(form.created_at).toISOString().split('T')[0]
                                : 'N/A';

                            // Pass entire form as JSON in button's data attribute
                            return [
                                i + 1,
                                form.user ? form.user.name : 'N/A',
                                form.indicator ? form.indicator.indicator : 'N/A',
                                form.target || 'N/A'
                            ];
                        });

                        if (!$.fn.DataTable.isDataTable('#complaintTable3')) {
                            $('#complaintTable3').DataTable({
                                data: rowData,
                                columns: [
                                    { title: "#" },
                                    { title: "User" },
                                    { title: "Indicator" },
                                    { title: "Target" },
                                ]
                            });
                        } else {
                            $('#complaintTable3').DataTable().clear().rows.add(rowData).draw();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                        alert('Unable to load data.');
                    }
                });
            }


    $(document).ready(function () {
        fetchTarget();
         $('#researchForm2').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);

             // Show loading indicator
                    Swal.fire({
                        title: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

            $.ajax({
                url: "{{ route('faculty-target.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.close();
                   // Swal.fire({ icon: 'success', title: 'Success', text: response.message });
                   Swal.fire({
                        icon: 'success',
                        html: `<div class="alert alert-success alert-dismissible" role="alert">${response.message}</div>`,
                        background: '#ffffffff',
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                    });
                    form[0].reset();

                    // Reset Select2 dropdowns
                    $('#indicator_id').val(null).trigger('change');
                    $('#select2Success').val(null).trigger('change');
                    fetchTarget();
                },
                error: function (xhr) {
                    Swal.close();
                     // Clear previous errors before showing new ones
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    // ✅ If duplicate assignment (HTTP 409)
                    if (xhr.status === 409) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Already Assigned',
                            text: xhr.responseJSON.message
                        });
                        return;
                    }
                     if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Loop through all validation errors
                            $.each(errors, function (field, messages) {
                                let input = form.find('[name="' + field + '"]');

                                if (input.length) {
                                    input.addClass('is-invalid');

                                    // Show error message under input
                                    input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                                }
                            });

                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!'});
                        }
                }
            });
        });
      

    });
    </script>
    @endif
@endpush