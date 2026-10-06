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
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-misc.css') }}" />
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(in_array(getRoleName(activeRole()), ['Employability Center']))
            <!-- Multi Column with Form Separator -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">% Employability</h5>
                    </div>
                    <div class="">
                        <a href="{{ url('kpa/1/category/1/indicator/103') }}" class="btn btn-success">Add</a>
                    </div>
                </div>
                <div class="card-datatable table-responsive card-body">
                    @if(in_array(getRoleName(activeRole()), ['Employability Center']))
                        <div class="tab-pane fade show" id="form2" role="tabpanel">
                            <div class="table-responsive text-nowrap">
                                <table id="employabilityTable" class="table table-bordered">
                                     <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Faculty</th>
                                            <th>Department</th>
                                            <th>Program Name</th>
                                            <th>Total Students</th>
                                            <th>Total Salary</th>
                                            <th>Employability</th>
                                            <th>Employer Satisfaction</th>
                                            <th>Graduate Sat</th>
                                            <th>Sum Employer Satisfaction</th>
                                            <th>Sum Graduate Satisfaction</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <!-- Update Intellectual Property Modal -->

            <!--/ Add Permission Modal -->

        @else
            <div class="misc-wrapper">
                <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">401</h1>
                <h4 class="mb-2 mx-2">You are not authorized! 🔐</h4>
                <p class="mb-6 mx-2">You don’t have permission to access this page. Go back!</p>
                <div class="mt-12">
                    <img src="{{ asset('admin/assets/img/illustrations/page-misc-you-are-not-authorized.png') }}"
                        alt="page-misc-not-authorized" width="170" class="img-fluid" />
                </div>
            </div>
        @endif
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
    <script src="{{ asset('admin/assets/js/extended-ui-star-ratings.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/raty-js/raty-js.js') }}"></script>
    <script>
        window.currentUserRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
@endpush
@push('script')
    <script>
        let employerRaty;
        let graduateRaty;




    </script>
    @if(in_array(getRoleName(activeRole()), ['Employability Center']))

        <script>
           function fetchCommercialForms() {

    if ($.fn.DataTable.isDataTable('#employabilityTable')) {
        $('#employabilityTable').DataTable().destroy();
    }

    $('#employabilityTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('employability.count') }}",
            type: "GET"
        },

        scrollX: true,
        scrollCollapse: true,
        autoWidth: false,

        pageLength: 10,

        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],

        searching: true,

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'id',
                orderable: false,
                searchable: false
            },

            {
                data: 'faculty_name',
                name: 'faculty_name'
            },

            {
                data: 'department_name',
                name: 'department_name'
            },

            {
                data: 'program_name',
                name: 'program_name'
            },

            {
                data: 'total_students',
                name: 'total_students',
                searchable: false
            },

            {
                data: 'total_salary',
                name: 'total_salary',
                searchable: false
            },
            {
                data: 'employability',
                name: 'employability',
                searchable: false,
                render: function(data) {
                    return data !== null ? parseFloat(data).toFixed(2) + '%' : '0.00%';
                }
            },
            {
                data: 'employer_satisfaction_score',
                name: 'employer_satisfaction_score',
                searchable: false,
                render: function(data) {
                    return data !== null ? parseFloat(data).toFixed(2) + '%' : '0.00%';
                }
            },
            {
                data: 'graduate_sat',
                name: 'graduate_sat',
                searchable: false,
                render: function(data) {
                    return data !== null ? parseFloat(data).toFixed(2) + '%' : '0.00%';
                }
            },

            {
                data: 'total_employer_satisfaction',
                name: 'total_employer_satisfaction',
                searchable: false
            },

            {
                data: 'total_graduate_satisfaction',
                name: 'total_graduate_satisfaction',
                searchable: false
            }

        ],

        order: [
            [4, 'desc']
        ]
    });
}



            $(document).ready(function () {
                fetchCommercialForms();
            });

        </script>
    @endif
@endpush