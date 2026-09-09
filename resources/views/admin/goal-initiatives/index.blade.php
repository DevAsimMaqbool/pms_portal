@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="goal-page-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>

                <div>
                    <h3 class="fw-bold mb-1">
                        Initiative / Extra Role
                    </h3>

                    <p class="mb-0 text-muted">
                        Manage your initiatives and additional contributions.
                    </p>
                </div>

            </div>

            <a href="{{ route('goal-initiatives.create') }}"
               class="btn btn-primary px-4 shadow-sm">

                <i class="fas fa-plus me-2"></i>
                Add Initiative

            </a>

        </div>

    </div>

    {{-- ALERTS --}}

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- TABLE CARD --}}

    <div class="section-card">

        <div class="section-header">

            <div>
                <h5 class="mb-1 fw-bold">
                    My Initiatives
                </h5>

                <small>
                    Initiatives submitted for Line Manager validation.
                </small>
            </div>

        </div>

        <div class="section-body p-0">

            @if($initiatives->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>

                                <th class="px-4">
                                    Initiative
                                </th>

                                <th>
                                    Dates
                                </th>

                                <th>
                                    Scope
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Manager Decision
                                </th>

                                <th class="text-end px-4">
                                    Actions
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                        @foreach($initiatives as $initiative)

                            <tr>

                                {{-- TITLE --}}

                                <td class="px-4">

                                    <div class="fw-semibold">
                                        {{ $initiative->title }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $initiative->nature_of_initiative }}

                                        @if($initiative->nature_other)
                                            - {{ $initiative->nature_other }}
                                        @endif
                                    </small>

                                </td>

                                {{-- DATES --}}

                                <td>

                                    <div>
                                        {{ $initiative->from_date?->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        to
                                        {{ $initiative->to_date?->format('d M Y') }}
                                    </small>

                                </td>

                                {{-- SCOPE --}}

                                <td>

                                    @php
                                        $scopeLabels = [
                                            'individual' => 'Individual',
                                            'team_peer' => 'Team / Peer',
                                            'departmental' => 'Departmental',
                                            'faculty_wide' => 'Faculty Wide',
                                            'institution_wide' => 'Institution Wide',
                                        ];
                                    @endphp

                                    <span class="badge badge-scope">
                                        {{ $scopeLabels[$initiative->scope] ?? $initiative->scope }}
                                    </span>

                                </td>

                                {{-- INITIATIVE STATUS --}}

                                <td>

                                    @php
                                        $statusLabels = [
                                            'idea_designed_only' => 'Idea Designed Only',
                                            'approved_in_progress' => 'Approved & In Progress',
                                            'completed' => 'Completed',
                                            'completed_verified' => 'Completed & Verified',
                                        ];
                                    @endphp

                                    {{ $statusLabels[$initiative->status] ?? $initiative->status }}

                                </td>

                                {{-- MANAGER DECISION --}}

                                <td>

                                    @if($initiative->manager_decision === 'submitted')

                                        <span class="status-badge status-submitted">
                                            <i class="fas fa-clock me-1"></i>
                                            Pending Validation
                                        </span>

                                    @elseif($initiative->manager_decision === 'approved')

                                        <span class="status-badge status-approved">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Approved
                                        </span>

                                    @elseif($initiative->manager_decision === 'approved_with_amendment')

                                        <span class="status-badge status-amended">
                                            <i class="fas fa-check-double me-1"></i>
                                            Approved with Amendment
                                        </span>

                                    @elseif($initiative->manager_decision === 'rejected')

                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Rejected
                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}

                                <td class="text-end px-4">

                                    <div class="d-flex justify-content-end gap-2">

                                        {{-- VIEW --}}

                                        <a href="{{ route('goal-initiatives.show', $initiative) }}"
                                           class="btn btn-sm btn-light border"
                                           title="View">

                                            <i class="fas fa-eye"></i>

                                        </a>

                                        {{-- EDIT --}}

                                        @if(
                                            !in_array(
                                                $initiative->manager_decision,
                                                ['approved', 'approved_with_amendment']
                                            )
                                        )

                                            <a href="{{ route('goal-initiatives.edit', $initiative) }}"
                                               class="btn btn-sm btn-light border"
                                               title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                        @endif

                                        {{-- DELETE --}}

                                        @if(
                                            !in_array(
                                                $initiative->manager_decision,
                                                ['approved', 'approved_with_amendment']
                                            )
                                        )

                                            <form method="POST"
                                                  action="{{ route('goal-initiatives.destroy', $initiative) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this initiative?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-light border text-danger"
                                                        title="Delete">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}

                <div class="p-4">
                    {{ $initiatives->links() }}
                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>

                    <h5 class="fw-bold mt-3">
                        No Initiatives Found
                    </h5>

                    <p class="text-muted mb-4">
                        You have not added any initiative or extra role yet.
                    </p>

                    <a href="{{ route('goal-initiatives.create') }}"
                       class="btn btn-primary px-4">

                        <i class="fas fa-plus me-2"></i>
                        Add Initiative

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

<style>

:root {
    --pms-primary: #1f4e79;
    --pms-primary-dark: #173a5c;
    --pms-border: #e4e9f0;
    --pms-text: #253449;
    --pms-muted: #718096;
}

.goal-page-header {
    background: linear-gradient(135deg,#fff,#f5f8fc);
    border: 1px solid var(--pms-border);
    border-radius: 16px;
    padding: 22px 26px;
    box-shadow: 0 4px 18px rgba(31,78,121,.06);
}

.header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--pms-primary);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.section-card {
    background: #fff;
    border: 1px solid var(--pms-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(31,78,121,.06);
}

.section-header {
    background: #f8fafc;
    border-bottom: 1px solid var(--pms-border);
    padding: 18px 22px;
}

.section-header small {
    color: var(--pms-muted);
}

.table {
    color: var(--pms-text);
}

.table thead th {
    background: #f8fafc;
    border-bottom: 1px solid var(--pms-border);
    color: var(--pms-text);
    font-size: 13px;
    font-weight: 700;
    padding: 16px 12px;
    white-space: nowrap;
}

.table tbody td {
    padding: 16px 12px;
    border-color: #edf1f5;
    font-size: 14px;
}

.badge-scope {
    background: #f2f7fc;
    color: var(--pms-primary);
    border: 1px solid #dce8f3;
    padding: 7px 10px;
    border-radius: 8px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 7px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.status-submitted {
    background: #fff7e6;
    color: #9a6700;
}

.status-approved {
    background: #eaf8ef;
    color: #237a3b;
}

.status-amended {
    background: #eef2ff;
    color: #4c51bf;
}

.status-rejected {
    background: #fff0f0;
    color: #c53030;
}

.btn-primary {
    background: var(--pms-primary);
    border-color: var(--pms-primary);
}

.btn-primary:hover {
    background: var(--pms-primary-dark);
    border-color: var(--pms-primary-dark);
}

.empty-state {
    text-align: center;
    padding: 70px 20px;
}

.empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: #f2f7fc;
    color: var(--pms-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}

</style>

@endsection