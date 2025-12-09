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
           <h5 class="card-header">Rating Rules</h5>
           <div class="card-body">
                <form id="ratingForm">
                        <input type="hidden" id="rule_id">

                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Min %</label>
                                <input type="number" class="form-control" name="min_percentage" id="min_percentage" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Max %</label>
                                <input type="number" class="form-control" name="max_percentage" id="max_percentage" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Rating</label>
                                <select id="rating" name="rating" class="form-select" required="">
                                    <option value="">-- Select --</option>
                                    <option value="OS">OS</option>
                                    <option value="EE">EE</option>
                                    <option value="ME">ME</option>
                                    <option value="NI">NI</option>
                                    <option value="BE">BE</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Color</label>
                                <div>
                                <input type="color" class="" id="color" name="color" required>
                                </div>
                            </div>

                            <div class="col-md-12 mt-6">

                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <button type="submit" class="btn btn-primary">Save Rule</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <!--/ Permission Table -->
         <div class="card mt-6">
          <div class="card-body">
              <div class="card-datatable table-responsive">
                <table class="table border-top" id="rulesTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Min %</th>
                            <th>Max %</th>
                            <th>Rating</th>
                            <th>Description</th>
                            <th>Color</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
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
@endpush
@push('script')
<script>
loadRules();

function loadRules() {
    $.get("{{ url('rating-rules/fetch') }}", function(res) {
        let rows = "";
        res.forEach((rule, index) => {  // <-- use index
            rows += `
                <tr>
                    <td>${index + 1}</td>  <!-- <-- row number -->
                    <td>${rule.min_percentage}</td>
                    <td>${rule.max_percentage}</td>
                    <td>${rule.rating}</td>
                    <td>${rule.description ?? ''}</td>
                    <td><span style="background:${rule.color}; padding:5px 15px; display:inline-block;"></span></td>
                    <td>
                        <button onclick="editRule(${rule.id})" class="btn btn-warning btn-sm">Edit</button>
                        <button onclick="deleteRule(${rule.id})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>`;
        });
        $('#rulesTable tbody').html(rows);
    });
}


$('#ratingForm').submit(function(e){
    e.preventDefault();
    let form = $(this);

    let id = $('#rule_id').val();
    let url = id ? `{{ url('rating-rules/update') }}/${id}` : `{{ url('rating-rules/store') }}`;

    // Show loading indicator
    Swal.fire({
        title: 'Please wait...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            min_percentage: $('#min_percentage').val(),
            max_percentage: $('#max_percentage').val(),
            rating: $('#rating').val(),
            description: $('#description').val(),
            color: $('#color').val(),
            _token: "{{ csrf_token() }}"
        },
        success: function(res){
            Swal.close();
            Swal.fire({ icon: 'success', title: 'Success', text: res.message });
            $('#rule_id').val('');
            form[0].reset();
            form.find('.invalid-feedback').remove();
            form.find('.is-invalid').removeClass('is-invalid');
            loadRules();
        },
        error: function(xhr){
            Swal.close();
            // Clear previous errors before showing new ones
            form.find('.invalid-feedback').remove();
            form.find('.is-invalid').removeClass('is-invalid');
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
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
            }
        }
    });
});


// EDIT
function editRule(id) {
    $.get(`{{ url('rating-rules/edit') }}/${id}`, function(rule){
        $('#rule_id').val(rule.id);
        $('#min_percentage').val(rule.min_percentage);
        $('#max_percentage').val(rule.max_percentage);
        $('#rating').val(rule.rating);
        $('#description').val(rule.description);
        $('#color').val(rule.color);
    });
}

// DELETE
function deleteRule(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('rating-rules/delete') }}/${id}`,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(res) {
                    Swal.fire(
                        'Deleted!',
                        res.message,
                        'success'
                    );
                    loadRules(); // refresh table
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Something went wrong while deleting.',
                        'error'
                    );
                }
            });
        }
    });
}

</script>

@endpush