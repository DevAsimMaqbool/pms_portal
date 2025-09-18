@extends('layouts.app')
@push('style')
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/swiper/swiper.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/cards-advance.css') }}" />
@endpush
@php use Illuminate\Support\Str; @endphp
@section('content')
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">

          <!-- Filters Row -->
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <div class="card h-100">
                <div class="card-body">
                  <label class="form-label">Select Employee</label>
                  <select id="employeeSelect" class="form-select">
                    <option value="all" selected>All Employees</option>
                    <option value="emp1">Dr. Ali Raza</option>
                    <option value="emp2">Ms. Sara Khan</option>
                    <option value="emp3">Mr. Imran Ahmed</option>
                  </select>
                  <small class="text-muted">Choose employee to view stats</small>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <h5 class="card-title mb-0">Employee Comparison</h5>
                    <span class="text-muted small">Across KPAs</span>
                  </div>
                  <canvas id="comparisonRadar" height="120"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Employee List Table -->
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title mb-3">Employee Performance List</h5>
              <div class="table-responsive">
                <table class="table table-bordered align-middle">
                  <thead class="table-light">
                  <tr>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Dept</th>
                    <th>Overall %</th>
                    <th>Teaching</th>
                    <th>Research</th>
                    <th>Engagement</th>
                    <th>Admin</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Dr. Ali Raza</td><td>Professor</td><td>CS</td><td>86%</td><td>82%</td><td>68%</td><td>75%</td><td>90%</td>
                    <td><span class="badge bg-success">Exceeds</span></td>
                    <td><a href="employee-dashboard.html" class="btn btn-sm btn-outline-primary">View</a></td>
                  </tr>
                  <tr>
                    <td>Ms. Sara Khan</td><td>Associate Prof</td><td>CS</td><td>78%</td><td>74%</td><td>70%</td><td>72%</td><td>80%</td>
                    <td><span class="badge bg-warning">Meets</span></td>
                    <td><a href="employee-dashboard.html" class="btn btn-sm btn-outline-primary">View</a></td>
                  </tr>
                  <tr>
                    <td>Mr. Imran Ahmed</td><td>Assistant Prof</td><td>CS</td><td>65%</td><td>60%</td><td>55%</td><td>70%</td><td>68%</td>
                    <td><span class="badge bg-danger">Needs Improvement</span></td>
                    <td><a href="employee-dashboard.html" class="btn btn-sm btn-outline-primary">View</a></td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Department Aggregate KPAs -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Department KPA Overview</h5>
                <span class="text-muted small">Aggregate Scores</span>
              </div>
              <div id="deptKPAChart"></div>
            </div>
          </div>

          <!-- HOD Academic Oversight -->
          <div class="row g-3">
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title">Classes Status</h5>
                  <div id="classesStatus"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title">Academic Compliance</h5>
                  <ul class="list-unstyled mb-0">
                    <li class="mb-2"><span class="badge bg-label-success me-2">85%</span> Exam Results Submitted on Time</li>
                    <li class="mb-2"><span class="badge bg-label-info me-2">92%</span> Feedback Surveys Completed</li>
                    <li><span class="badge bg-label-warning me-2">75%</span> Attendance Marking Compliance</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
  <!-- / Content -->
@endsection
@push('script')
  <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}
    "></script>
  <script src="{{ asset('admin/assets/js/app-logistics-dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/libs/swiper/swiper.js') }}
      "></script>
  <!-- <script src="{{ asset('admin/assets/js/cards-statistics.js') }}"></script> -->
  <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>

@endpush