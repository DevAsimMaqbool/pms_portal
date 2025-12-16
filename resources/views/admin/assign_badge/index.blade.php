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
                <h5 class="card-title mb-0">Assign Badges</h5>
            </div>

            <div class="card-datatable">
                <table class="table" id="nominationTable">
                    <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Indicator Name</th>
                            <th>Indicator Score</th>
                            <th>Assign Badge</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ trim(preg_replace('/[-\s]*\d+$/', '', $submission->user->name)) }}
                                </td>

                                <td>{{ $submission->user->job_title }}</td>
                                <td>{{ $submission->user->department }}</td>
                                <td>{{ $submission->indicator->indicator }}</td>
                                <td>{{ $submission->score }}%</td>

                                <td>
                                    <select class="form-select form-select-sm badge-select" data-id="{{ $submission->id }}" {{ $submission->badge_name ? 'disabled' : '' }}>
                                        <option value="">Select Badge</option>
                                        <option value="gold" {{ $submission->badge_name == 'gold' ? 'selected' : '' }}>Gold
                                        </option>
                                        <option value="silver" {{ $submission->badge_name == 'silver' ? 'selected' : '' }}>Silver
                                        </option>
                                        <option value="bronze" {{ $submission->badge_name == 'bronze' ? 'selected' : '' }}>Bronze
                                        </option>
                                    </select>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#nominationTable').DataTable({
                responsive: true
            });
        });
    </script>
    <script>
        document.querySelectorAll('.badge-select').forEach(select => {
            select.addEventListener('change', function () {
                const badge = this.value;
                const id = this.dataset.id;
                alert(id);
                if (!badge) return; // Do nothing if no selection

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are assigning the ${badge} badge!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/badges/update-badge/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ badge: badge })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('Updated!', data.message, 'success');
                                } else {
                                    Swal.fire('Error!', 'Something went wrong', 'error');
                                }
                            })
                            .catch(() => {
                                Swal.fire('Error!', 'Something went wrong', 'error');
                            });
                    } else {
                        // Reset select if canceled
                        this.value = '';
                    }
                });
            });
        });
    </script>

@endpush