@extends('layouts.app')
@push('style')

  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-profile.css') }}" />
@endpush
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Dean Give Target to HOD</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped"
                   id="yearsTable">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Assign</th>
                        <th>Indicator</th>
                        <th>Targte</th>
                        <th>Other</th>
                        <th>Year</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($recordtarget as $records)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $records->assign->name ?? '-' }}</td>
                        <td>{{ $records->indicator->indicator ?? '-' }}</td>
                        <td>{{ $records->target ?? '-' }}</td>
                        <td>
                            @if($records->indicator_id == 128)
                                <span class="badge bg-primary me-2 my-1">Scopus: {{ $records->scopus_q1 ?? 0 }}</span>
                                <span class="badge bg-primary me-2 my-1">HEC: {{ $records->hec_w ?? 0 }}</span>
                                <span class="badge bg-primary me-2 my-1">Medical: {{ $records->medical_recognized ?? 0 }}</span>
                               
                            @else
                                
                            @endif
                        </td>
                        <td>{{ $records->year->year ?? '-' }}</td>
                        <td>{{ $records->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No record found.</td>
                    </tr>
                @endforelse
            </tbody>

            </table>

        </div>

    </div>

</div>


@endsection
@push('script')
<script src="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/datatables-responsive-bootstrap5.js') }}"></script>

<script>
$(document).ready(function () {
    $('#yearsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "Previous",
                next: "Next"
            },
            emptyTable: "No record found."
        }
    });
});
</script>
@endpush