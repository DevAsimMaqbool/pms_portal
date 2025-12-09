@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <!-- Header with Add Policy Button -->
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-title mb-0">Policies & SOPs</h5>
                <a href="{{ route('policy.create') }}" class="btn btn-primary">Add Policy</a>
            </div>

            <div class="card-datatable">
                <table class="table" id="policyTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>SOPs File</th>
                            <th>Policy File</th>
                            <th>Uploaded By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policies as $policy)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($policy->sop_file)
                                        <a href="{{ asset('storage/' . $policy->sop_file) }}" target="_blank">View File</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($policy->policy_file)
                                        <a href="{{ asset('storage/' . $policy->policy_file) }}" target="_blank">View File</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $policy->created_by ? $policy->creator->name ?? 'N/A' : 'N/A' }}</td>
                                <td>{{ $policy->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('policy.edit', $policy->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('policy.destroy', $policy->id) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Are you sure you want to delete this policy?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
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
            $('#policyTable').DataTable({
                responsive: true
            });
        });
    </script>
@endpush