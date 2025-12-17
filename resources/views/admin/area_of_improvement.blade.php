@extends('layouts.app')
@push('style')

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
  <style>
    .bg-orange,
    .bg-label-orange {
      background-color: #fd7e1459 !important;
      color: #fd7e14 !important
    }

    .text-orange {
      color: #f6c8ab !important;
      /* or your preferred shade */
    }
  </style>
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
            <h5 class="card-title m-0 me-2">Need to Improve</h5>
          </div>
          <div class="card-datatable table-responsive">
            <table class="table border-top" id="areaOfImprovment">
              <thead class="border-bottom">
                <tr>
                  <th>Indicator</th>
                  <th>Progress</th>
                  <th>Rating</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody>
                @foreach($areaOfImprovement as $areaOfImprovements)
                     
                     <tr>
                        <td>
                          <div class="d-flex justify-content-start align-items-center">
                            <div class="avatar flex-shrink-0 me-4">
                              <span class="avatar-initial rounded bg-label-info"><i
                                  class="icon-base ti tabler-truck icon-26px"></i></span>
                            </div>
                            <div class="d-flex flex-column me-4">
                              <small class="text-body">{{ $areaOfImprovements->indicator->indicator }}</small>
                            </div>
                          </div>
                        </td>
                        <td class="dt-type-numeric">
                          <div class="d-flex align-items-center">
                            <div class="progress w-100 me-3" style="height: 6px;">
                              <div class="progress-bar bg-{{ $areaOfImprovements->color }}" role="progressbar" style="width: {{ $areaOfImprovements->score }}%" aria-valuenow="{{ $areaOfImprovements->score }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </td>

                        <td><span class="badge bg-label-{{ $areaOfImprovements->color }}"> {{ $areaOfImprovements->rating }}</span></td>
                        <td>
                          <p class="text-danger fw-medium mb-0 d-flex align-items-center gap-1">
                            {{ $areaOfImprovements->score }}%
                          </p>
                        </td>
                      </tr>


                @endforeach
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!--/ Last Transaction -->
      <!-- Carrier Performance -->
      <div class="col-12 col-lg-12">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 me-2">Performance Improvment Plan</h5>
          </div>
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
      </div>

    </div>
  </div>
  <!--  Topic and Instructors  End-->
  <!-- / Content -->
@endsection
@push('script')
  <script>
    const chartLabels = @json($labels);
    const dataset1 = @json($dataset1);
    const dataset2 = @json($dataset2);
  </script>
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
  <script>
    $(document).ready(function () {
      $('#areaOfImprovment').DataTable({
        destroy: true,
        order: []
      });
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
        ? `<img src="${fileUrl}" alt="Document" width="60" height="60" class="img-thumbnail doc-preview" style="cursor:pointer" data-src="${fileUrl}">` : `<a href="${fileUrl}" target="_blank">View File</a>`;
    }

    // 🔹 Render Status Dropdown
    function renderStatusDropdown(id, status) {
      const options = {
        not_started: "Not Started",
        inprogress: "In Progress",
        completed: "Completed"
      };
      return `<select class="form-select form-select-sm status-select" data-id="${id}" id="status_${id}" name="status_${id}" >${Object.entries(options).map(([value, label]) => `<option value="${value}" ${status === value ? "selected" : ""}>${label}</option>`).join('')}</select>`;
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