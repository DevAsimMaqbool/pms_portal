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
                <h5 class="card-title mb-0">QEC Audit Rating</h5>
                <a href="{{ url('kpa/1/category/3/indicator/110') }}" class="btn btn-primary">Add</a>
            </div>

            <div class="card-datatable">
                <table class="table" id="userTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Audit Term</th>
                            <th>Faculty</th>
                            <th>Department</th>
                            <th>Program</th>
                            <th>Total Score</th>
                            <th>Score Obtained</th>
                            <th>Strength</th>
                            <th>Area of Improvement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $index => $audit)
                            @php
                                $firstDetail = $audit->details->first(); // 👈 Only first detail for preview
                            @endphp

                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $firstDetail->audit_term ?? 'N/A' }}</td>
                                <td>{{ $firstDetail->faculty->name ?? 'N/A' }}</td>
                                <td>{{ $firstDetail->department->name ?? 'N/A' }}</td>
                                <td>{{ $firstDetail->program->name ?? 'N/A' }}</td>
                                <td>{{ $firstDetail->total_score ?? 0 }}</td>
                                <td>{{ $firstDetail->obtained_score ?? 0 }}</td>
                                <td>{{ $firstDetail->strenght ?? 'N/A' }}</td>
                                <td>{{ $firstDetail->area_of_improvement ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('qec-audit-rating.edit', $audit->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No Records Found</td>
                            </tr>
                        @endforelse
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