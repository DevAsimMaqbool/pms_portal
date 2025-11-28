@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/%40form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <!-- Header with Add Feedback Button -->
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-title mb-0">Employee Feedback</h5>
                <a href="{{ route('linemanager.form') }}" class="btn btn-primary">Add Feedback</a>
            </div>

            <div class="card-datatable">
                <table class="table" id="userTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Faculty Member</th>
                            <th>Responsibility & Accountability</th>
                            <th>Empathy & Compassion</th>
                            <th>Humility & Service</th>
                            <th>Honesty & Integrity</th>
                            <th>Inspirational Leadership</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ratings as $rating)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rating->employee?->name ?? 'N/A' }}</td>
                                <td>{{ $rating->responsibility_accountability_1 }},
                                    {{ $rating->responsibility_accountability_2 }}
                                </td>
                                <td>{{ $rating->empathy_compassion_1 }}, {{ $rating->empathy_compassion_2 }}</td>
                                <td>{{ $rating->humility_service_1 }}, {{ $rating->humility_service_2 }}</td>
                                <td>{{ $rating->honesty_integrity_1 }}, {{ $rating->honesty_integrity_2 }}</td>
                                <td>{{ $rating->inspirational_leadership_1 }}, {{ $rating->inspirational_leadership_2 }}</td>
                                <td>{{ $rating->remarks }}</td>
                                <td>
                                    <a href="{{ route('employee.rating.edit', $rating->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-responsive/dataTables.responsive.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                responsive: true
            });
        });
    </script>
@endpush