@extends('layouts.app')
@push('style')

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row g-6">
      <!-- Last Transaction -->
      <div class="col-lg-12">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 me-2">Term Management</h5>
            <button class="btn btn-primary mb-3" id="createNewTerm">Add Term</button>
          </div>
          <div class="card-datatable table-responsive">
            <table class="table table-bordered" id="termsTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Term</th>
                        <th>Start Year</th>
                        <th>End Year</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
     

    </div>


    <!-- Modal -->
<div class="modal fade" id="termModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="termForm">
          <div class="modal-header">
            <h5 class="modal-title" id="modalHeading"></h5>
          </div>
          <div class="modal-body">
              @csrf
              <input type="hidden" name="term_id" id="term_id">

              <div class="mb-3">
                  <label>Term</label>
                  <select name="term" id="term" class="form-control">
                      <option value="Spring">Spring</option>
                      <option value="Fall">Fall</option>
                  </select>
              </div>

              <div class="mb-3">
                  <label>Start Year</label>
                  <select name="start_year" id="start_year" class="form-control">
                      @for($i = date('Y'); $i <= date('Y')+5; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                  </select>
              </div>

              <div class="mb-3">
                  <label>End Year</label>
                  <select name="end_year" id="end_year" class="form-control">
                      @for($i = date('Y')+1; $i <= date('Y')+6; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                  </select>
              </div>

              <div class="mb-3">
                  <label>Status</label>
                  <select name="status" id="status" class="form-control">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </form>
    </div>
  </div>
</div>
<!--/model -->
  </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('admin/assets/js/app-user-view-account.js') }}"></script>
  <!-- Vendors JS -->
  <script src="{{ asset('admin/assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <!-- Page JS -->
  <script src="{{ asset('admin/assets/js/app-academy-dashboard.js') }}"></script>

  <script src="{{ asset('admin/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
  <script src="{{ asset('admin/assets/js/charts-chartjs-legend.js') }}"></script>
  <script src="{{ asset('admin/assets/js/charts-chartjs.js') }}"></script>
  
  <script type="text/javascript">
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
$(function () {
    var table = $('#termsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('terms.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'term', name: 'term'},
            {data: 'start_year', name: 'start_year'},
            {data: 'end_year', name: 'end_year'},
            {data: 'status_text', name: 'status_text'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewTerm').click(function () {
        $('#saveBtn').val("create-term");
        $('#term_id').val('');
        $('#termForm').trigger("reset");
        $('#modalHeading').html("Add New Term");
        $('#termModal').modal('show');
    });

    $('body').on('click', '.editTerm', function () {
        var term_id = $(this).data('id');
        $.get("{{ url('terms/edit') }}/"+term_id, function (data) {
            $('#modalHeading').html("Edit Term");
            $('#saveBtn').val("edit-term");
            $('#termModal').modal('show');
            $('#term_id').val(data.id);
            $('#term').val(data.term);
            $('#start_year').val(data.start_year);
            $('#end_year').val(data.end_year);
            $('#status').val(data.status);
        })
    });

    $('#termForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var term_id = $('#term_id').val();
        var url = term_id ? "{{ url('terms/update') }}/"+term_id : "{{ route('terms.store') }}";

        $.ajax({
            data: formData,
            url: url,
            type: "POST",
            dataType: 'json',
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success || `Term  successfully`,
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#termForm').trigger("reset");
                $('#termModal').modal('hide');
                table.ajax.reload();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    // DELETE WITH SWEETALERT2
    $('body').on('click', '.deleteTerm', function () {
        let term_id = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('terms/delete') }}/" + term_id,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.success || 'Term deleted successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong.',
                        });
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });




});
</script>
@endpush