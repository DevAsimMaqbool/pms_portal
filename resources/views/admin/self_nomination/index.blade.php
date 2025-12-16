@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-title mb-0">Self Nominations</h5>
            </div>

            <div class="card-datatable">
                <table class="table" id="nominationTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Submitted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $submission->user->barcode }}</td>

                                <td>
                                    {{ trim(preg_replace('/[-\s]*\d+$/', '', $submission->user->name)) }}
                                </td>

                                <td>{{ $submission->user->job_title }}</td>
                                <td>{{ $submission->user->department }}</td>

                                <td>{{ $submission->created_at->format('Y-m-d') }}</td>

                                <td>
                                    <a class="btn btn-icon btn-text-secondary rounded-pill waves-effect"
                                        href="{{ route('nomination.show', $submission->id) }}" title="View Nomination"
                                        aria-label="View Nomination">
                                        <i class="icon-base ti tabler-eye icon-md"></i>
                                    </a>
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
    <script src="{{ asset('admin/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/datatables-responsive/dataTables.responsive.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#nominationTable').DataTable({
                responsive: true
            });
        });
    </script>
@endpush