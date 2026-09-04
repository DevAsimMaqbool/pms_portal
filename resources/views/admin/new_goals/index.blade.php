@extends('layouts.app')

@section('content')

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    My Goals
                </h3>

                <p class="text-muted mb-0">
                    Manage your goals and track their review progress.
                </p>
            </div>

            <a href="{{ route('newgoals.create') }}" class="btn btn-primary px-4">

                <i class="fas fa-plus me-2"></i>
                Create New Goal

            </a>

        </div>

        {{-- Messages --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

        @endif

        {{-- Goals --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                @if($goals->count())

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4">
                                        #
                                    </th>

                                    <th>
                                        Goal
                                    </th>

                                    <th>
                                        S2R Driver  / Enabler
                                    </th>

                                    <th>
                                        Target
                                    </th>

                                    <th>
                                        Deadline
                                    </th>

                                    <th>
                                        Report
                                    </th>

                                    <th class="text-end px-4">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($goals as $goal)

                                    <tr>

                                        <td class="px-4 fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td style="min-width:260px">

                                            <div class="fw-semibold">
                                                {{ Str::limit($goal->goal, 80) }}
                                            </div>

                                            @if($goal->objectives)

                                                <small class="text-muted">
                                                    Objective:
                                                    {{ Str::limit($goal->objectives, 60) }}
                                                </small>

                                            @endif

                                        </td>

                                        <td style="min-width:180px">

                                            <span class="badge bg-info-subtle text-info">

                                                {{ $goal->s2rDriver->driver_name ?? 'N/A' }}

                                            </span>

                                        </td>

                                        <td style="min-width:180px">

                                            {{ Str::limit($goal->target, 70) }}

                                        </td>

                                        <td>

                                            {{ optional($goal->deadline)->format('d M Y') }}

                                            @if(
                                                    $goal->deadline &&
                                                    $goal->deadline->isPast() &&
                                                    !$goal->latestSelfReport
                                                )

                                                <div>
                                                    <small class="text-danger">
                                                        Deadline Passed
                                                    </small>
                                                </div>

                                            @endif

                                        </td>

                                        {{-- Report status --}}
                                        <td>

                                            @if(!$goal->latestSelfReport)

                                                <span class="badge bg-secondary">
                                                    Not Submitted
                                                </span>

                                            @else

                                                @php
                                                    $reportStatus =
                                                        $goal->latestSelfReport->status;
                                                @endphp

                                                @if($reportStatus === 'submitted')

                                                    <span class="badge bg-warning text-dark">
                                                        Manager Review
                                                    </span>

                                                @elseif($reportStatus === 'manager_approved')

                                                    <span class="badge bg-info">
                                                        HR Moderated Rating
                                                    </span>

                                                @elseif($reportStatus === 'manager_rejected')

                                                    <span class="badge bg-danger">
                                                        Manager Rejected
                                                    </span>

                                                @elseif($reportStatus === 'hr_approved')

                                                    <span class="badge bg-success">
                                                        Final Approved
                                                    </span>

                                                @elseif($reportStatus === 'hr_rejected')

                                                    <span class="badge bg-danger">
                                                        HR Rejected
                                                    </span>

                                                @endif

                                            @endif

                                        </td>

                                        <td class="text-end px-4">

                                            <div class="dropdown">

                                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">

                                                    <i class="fas fa-ellipsis-v"></i>

                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    <li>

                                                        <a class="dropdown-item" href="{{ route('newgoals.show', $goal) }}">

                                                            <i class="fas fa-eye me-2"></i>
                                                            View Goal

                                                        </a>

                                                    </li>

                                                    @if(!$goal->selfReports()->exists())

                                                        <li>

                                                            <a class="dropdown-item" href="{{ route('newgoals.edit', $goal) }}">

                                                                <i class="fas fa-edit me-2"></i>
                                                                Edit

                                                            </a>

                                                        </li>

                                                        <li>

                                                            <form method="POST" action="{{ route('newgoals.destroy', $goal) }}"
                                                                onsubmit="return confirm('Are you sure you want to delete this goal?')">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button class="dropdown-item text-danger">

                                                                    <i class="fas fa-trash me-2"></i>
                                                                    Delete

                                                                </button>

                                                            </form>

                                                        </li>

                                                    @endif

                                                    @if($goal->latestSelfReport)

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <li>

                                                            <a class="dropdown-item"
                                                                href="{{ route('goal-self-reports.show', $goal->latestSelfReport) }}">

                                                                <i class="fas fa-file-alt me-2"></i>
                                                                View Self Report

                                                            </a>

                                                        </li>

                                                    @endif

                                                    <li>

                                                        <a class="dropdown-item" href="{{ route('newgoals.history', $goal) }}">

                                                            <i class="fas fa-history me-2"></i>
                                                            History

                                                        </a>

                                                    </li>

                                                </ul>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <div class="mb-3">

                            <i class="fas fa-bullseye fa-3x text-muted"></i>

                        </div>

                        <h5>
                            No Goals Found
                        </h5>

                        <p class="text-muted">
                            Start by creating your first goal.
                        </p>

                        <a href="{{ route('newgoals.create') }}" class="btn btn-primary">

                            <i class="fas fa-plus me-2"></i>
                            Create Goal

                        </a>

                    </div>

                @endif

            </div>

            @if($goals->hasPages())

                <div class="card-footer bg-white">

                    {{ $goals->links() }}

                </div>

            @endif

        </div>

    </div>

    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
      <div class="modal-content">
        <div class="modal-body">

          <div class="text-center mb-4">
            <h3 class="modal-title">
              Change Your Password
            </h3>
            <p class="text-body-secondary">
              For security reasons, you must create a new password before continuing.
            </p>
          </div>

          <form action="{{ route('change-password.first-login') }}" method="POST" id="changePasswordForm">
            @csrf
            <div class="mb-4">
              <label class="form-label">New Password</label>

              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                required>

              @error('password')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-4">
              <label class="form-label">Confirm New Password</label>

              <input type="password" name="password_confirmation"
                class="form-control @error('password') is-invalid @enderror" required>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                Update Password
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
@php
$showPasswordPopup = session('show_password_popup', false);
@endphp
@if($showPasswordPopup)
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        let modal = new bootstrap.Modal(
          document.getElementById('resetPasswordModal'),
          {
            backdrop: 'static',
            keyboard: false
          }
        );

        modal.show();
      });
    </script>
  @endif
   @if ($errors->any())
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        let modal = new bootstrap.Modal(
          document.getElementById('resetPasswordModal'),
          {
            backdrop: 'static',
            keyboard: false
          }
        );

        modal.show();
      });
    </script>
  @endif
@endpush