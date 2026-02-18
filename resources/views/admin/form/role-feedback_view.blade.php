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
                <h5 class="card-title mb-0">Employee Feedbacks</h5>
                <a href="{{ route('linemanagerevent.form') }}" class="btn btn-primary">Add Feedback</a>
            </div>
            <!-- <div class="px-3 pb-3">
                    <span class="badge bg-primary">Total: {{ $total }}</span>
                    <span class="badge bg-success">Completed: {{ $completed }}</span>
                    <span class="badge bg-danger">Not Completed: {{ $notCompleted }}</span>
                    </div> -->

            <div class="card-datatable">
                <table class="table" id="userTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Faculty Member</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Feedback Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facultyMembers as $member)
                            @php
                                $memberFeedbacks = $ratings[$member->id] ?? collect();
                            @endphp

                            @forelse($memberFeedbacks as $feedback)
                                <tr>
                                    <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td> {{-- Index --}}
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->department ?? 'N/A' }}</td>
                                    <td>{{ $feedback->event_name ?? 'N/A' }}</td>
                                    <td>{{ $feedback->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('employee.feedback.edit', $feedback->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->department ?? 'N/A' }}</td>
                                    <td>N/A</td> {{-- Event column --}}
                                    <td>N/A</td> {{-- Date column --}}
                                    <td>
                                        <a href="{{ route('linemanagerevent.form', ['employee_id' => $member->id]) }}"
                                            class="btn btn-sm btn-success">
                                            Add
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
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