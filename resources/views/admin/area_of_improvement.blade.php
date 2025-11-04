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
  </style>
@endpush
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row g-6">
      <!-- Statistics -->
      <div class="col-md-12 col-xxl-12">
        <div class="card h-100">
          <div class="card-body d-flex align-items-end">
            <div class="w-100">

              <div class="row gy-3">

                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-primary me-4 p-2"><i class="icon-base ti tabler-book icon-lg"></i>
                    </div>
                    <div class="card-info">
                      <h5 class="mb-0">90%</h5>
                      <small>Teaching</small>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-info me-4 p-2"><i class="icon-base ti tabler-bulb icon-lg"></i>
                    </div>
                    <div class="card-info">
                      <h5 class="mb-0">85%</h5>
                      <small>Research</small>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-danger me-4 p-2"><i
                        class="icon-base ti tabler-network icon-lg"></i></div>
                    <div class="card-info">
                      <h5 class="mb-0">80%</h5>
                      <small>Engagement</small>
                    </div>
                  </div>
                </div>

                <div class="col-md-3 col-6">
                  <div class="d-flex align-items-center">
                    <div class="badge rounded bg-label-success me-4 p-2"><i
                        class="icon-base ti tabler-shield-check icon-lg"></i></div>
                    <div class="card-info">
                      <h5 class="mb-0">75%</h5>
                      <small>Character Virtue</small>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Last Transaction -->
      <div class="col-lg-12">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 me-2">Need to Improve</h5>
            <button type="button" class="btn rounded-pill btn-outline-primary waves-effect"><i
                class="icon-base ti tabler-calendar icon-xs me-2"></i>Fall 2025</button>
          </div>
          <div class="card-datatable table-responsive">
            <table class="table border-top" id="areaOfImprovment">
              <thead class="border-bottom">
                <tr>
                  <th>Indicator</th>
                  <th>Rating</th>
                  <th>Score</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-truck icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column me-4">
                        <small class="text-body">Research Publications</small>
                      </div>
                      <div class="progress w-50 me-4" style="height:8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 50%" aria-valuenow="50"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>

                  <td><span class="badge bg-label-danger">BE</span></td>
                  <td>
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      50%
                    </p>
                  </td>
                </tr>

                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-truck icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column me-4">
                        <small class="text-body">Line Manager Satisfaction Rating</small>
                      </div>
                      <div class="progress w-50 me-4" style="height:8px;">
                        <div class="progress-bar bg-orange" role="progressbar" style="width: 35%" aria-valuenow="53"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>

                  <td><span class="badge bg-label-danger">BE</span></td>
                  <td>
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      53%
                    </p>
                  </td>
                </tr>

                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-info"><i
                            class="icon-base ti tabler-truck icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column me-4">
                        <small class="text-body">Student Pass Percentage</small>
                      </div>
                      <div class="progress w-50 me-4" style="height:8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 59%" aria-valuenow="59"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>

                  <td><span class="badge bg-label-danger">BE</span></td>
                  <td>
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      59%
                    </p>
                  </td>
                </tr>


                <tr>
                  <td class="pt-5">
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-orange"><i
                            class="icon-base ti tabler-package icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column me-4">
                        <small class="text-body">Research productivity of PG students</small>
                      </div>
                      <div class="progress w-50 me-4" style="height:8px;">
                        <div class="progress-bar bg-label-orange" role="progressbar" style="width: 63%" aria-valuenow="63"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>

                  <td class="pt-5"><span class="badge bg-label-orange">NI</span></td>
                  <td class="pt-5">
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      63%
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="pt-5">
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar flex-shrink-0 me-4">
                        <span class="avatar-initial rounded bg-label-orange"><i
                            class="icon-base ti tabler-package icon-26px"></i></span>
                      </div>
                      <div class="d-flex flex-column me-4">
                        <small class="text-body">Student Satisfaction</small>
                      </div>
                      <div class="progress w-50 me-4" style="height:8px;">
                        <div class="progress-bar bg-orange" role="progressbar" style="width: 65%" aria-valuenow="65"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>

                  <td class="pt-5"><span class="badge bg-label-orange">NI</span></td>
                  <td class="pt-5">
                    <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                      65%
                    </p>
                  </td>
                </tr>




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