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
@endpush
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Permission Table -->
        <div class="card">
            <div class="card-datatable table-responsive card-body">
                <h5>My Assigned KPAs and Indicators</h5>
                <table class="table border-top" id="complaintTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>KPA</th>
                            <th>Indicator Category</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @foreach($assignments->groupBy('keyPerformanceArea.performance_area') as $kpa => $items)
                            @foreach($items->groupBy('category.category') as $category => $group)
                                @foreach($group as $item)
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ $kpa }}</td>
                                        <td>{{ $category }}</td>
                                        <td>{{ $item->indicator->indicator }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>


                <!-- @foreach($assignments->groupBy('keyPerformanceArea.performance_area') as $kpa => $items)
                                    <h4>{{ $kpa }}</h4>
                                    @foreach($items->groupBy('indicatorCategory.indicator_category') as $category => $group)
                                        <strong>{{ $category }}</strong>
                                        <ul>
                                            @foreach($group as $item)
                                                <li>{{ $item->indicator->indicator }}</li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                @endforeach -->
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
@endpush