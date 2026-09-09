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
                        Initiative Details
                    </h3>

                    <p class="mb-0 text-muted">
                        View initiative / extra role details and manager validation.
                    </p>

                </div>

            </div>

            <div class="d-flex gap-2">

                @if(
                    !in_array(
                        $goalInitiative->manager_decision,
                        ['approved', 'approved_with_amendment']
                    )
                )

                    <a href="{{ route('goal-initiatives.edit', $goalInitiative) }}"
                       class="btn btn-primary px-4">

                        <i class="fas fa-edit me-2"></i>
                        Edit

                    </a>

                @endif

                <a href="{{ route('goal-initiatives.index') }}"
                   class="btn btn-light border px-4">

                    <i class="fas fa-arrow-left me-2"></i>
                    Back

                </a>

            </div>

        </div>

    </div>

    {{-- MANAGER DECISION --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <h5 class="mb-1 fw-bold">
                Manager Validation
            </h5>

            <small>
                Current Line Manager decision for this initiative.
            </small>

        </div>

        <div class="section-body">

            <div class="row g-4">

                <div class="col-md-4">

                    <label class="detail-label">
                        Decision
                    </label>

                    <div>

                        @if($goalInitiative->manager_decision === 'submitted')

                            <span class="status-badge status-submitted">
                                <i class="fas fa-clock me-1"></i>
                                Pending Validation
                            </span>

                        @elseif($goalInitiative->manager_decision === 'approved')

                            <span class="status-badge status-approved">
                                <i class="fas fa-check-circle me-1"></i>
                                Approved
                            </span>

                        @elseif($goalInitiative->manager_decision === 'approved_with_amendment')

                            <span class="status-badge status-amended">
                                <i class="fas fa-check-double me-1"></i>
                                Approved with Amendment
                            </span>

                        @elseif($goalInitiative->manager_decision === 'rejected')

                            <span class="status-badge status-rejected">
                                <i class="fas fa-times-circle me-1"></i>
                                Rejected
                            </span>

                        @endif

                    </div>

                </div>

                <div class="col-md-4">

                    <label class="detail-label">
                        Manager
                    </label>

                    <div class="detail-value">

                        {{ $goalInitiative->manager?->name ?? '—' }}

                    </div>

                </div>

                <div class="col-md-4">

                    <label class="detail-label">
                        Decision Date
                    </label>

                    <div class="detail-value">

                        {{ $goalInitiative->manager_decided_at?->format('d M Y, h:i A') ?? '—' }}

                    </div>

                </div>

                @if($goalInitiative->manager_remarks)

                    <div class="col-12">

                        <label class="detail-label">
                            Manager Remarks
                        </label>

                        <div class="remarks-box">

                            {{ $goalInitiative->manager_remarks }}

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

    {{-- BASIC DETAILS --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <h5 class="mb-1 fw-bold">
                Initiative Details
            </h5>

        </div>

        <div class="section-body">

            <div class="row g-4">

                <div class="col-md-8">

                    <label class="detail-label">
                        Title
                    </label>

                    <div class="detail-value large">
                        {{ $goalInitiative->title }}
                    </div>

                </div>

                <div class="col-md-4">

                    <label class="detail-label">
                        Nature
                    </label>

                    <div class="detail-value">

                        {{ $goalInitiative->nature_of_initiative }}

                        @if($goalInitiative->nature_other)
                            <br>
                            <small class="text-muted">
                                {{ $goalInitiative->nature_other }}
                            </small>
                        @endif

                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        From Date
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->from_date?->format('d M Y') }}
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        To Date
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->to_date?->format('d M Y') }}
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Scope
                    </label>

                    @php
                        $scopeLabels = [
                            'individual' => 'Individual',
                            'team_peer' => 'Team / Peer',
                            'departmental' => 'Departmental',
                            'faculty_wide' => 'Faculty Wide',
                            'institution_wide' => 'Institution Wide',
                        ];
                    @endphp

                    <div class="detail-value">
                        {{ $scopeLabels[$goalInitiative->scope] ?? $goalInitiative->scope }}
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Status
                    </label>

                    @php
                        $statusLabels = [
                            'idea_designed_only' => 'Idea Designed Only',
                            'approved_in_progress' => 'Approved and In Progress',
                            'completed' => 'Completed',
                            'completed_verified' => 'Completed and Verified by Manager / Project Head',
                        ];
                    @endphp

                    <div class="detail-value">
                        {{ $statusLabels[$goalInitiative->status] ?? $goalInitiative->status }}
                    </div>

                </div>

                <div class="col-12">

                    <label class="detail-label">
                        Description
                    </label>

                    <div class="content-box">
                        {!! nl2br(e($goalInitiative->description)) !!}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- OUTCOME --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <h5 class="mb-1 fw-bold">
                Outcome
            </h5>

        </div>

        <div class="section-body">

            <div class="content-box">

                @if($goalInitiative->outcome)

                    {!! nl2br(e($goalInitiative->outcome)) !!}

                @else

                    <span class="text-muted">
                        No outcome provided.
                    </span>

                @endif

            </div>

        </div>

    </div>

    {{-- IMPACT --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <h5 class="mb-1 fw-bold">
                 Impact
            </h5>

        </div>

        <div class="section-body">

            <div class="row g-4">

                <div class="col-md-6">

                    <label class="detail-label">
                        Reach
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->impact_reach ?: '—' }}
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Outcome
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->impact_outcome ?: '—' }}
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Sustainability
                    </label>

                    <div class="detail-value">

                        @if($goalInitiative->sustainability === 'one_off')
                            One Off
                        @elseif($goalInitiative->sustainability === 'adopted_standard_practice')
                            Adopted / Implemented as Standard Practice
                        @else
                            —
                        @endif

                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Sustainability Description
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->sustainability_field ?: '—' }}
                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Strategic Alignment
                    </label>

                    <div class="detail-value">

                        @if($goalInitiative->strategic_alignment === 'linked')

                            Linked to Departmental / Institutional Goal

                        @elseif($goalInitiative->strategic_alignment === 'not_linked')

                            Not Linked to Any Departmental / Institutional Goal

                        @else

                            —

                        @endif

                    </div>

                </div>

                <div class="col-md-6">

                    <label class="detail-label">
                        Strategic Alignment Description
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->strategic_goal ?: '—' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- SUPERVISOR --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <h5 class="mb-1 fw-bold">
                 Initiative Supervised / Endorsed By
            </h5>

        </div>

        <div class="section-body">

            <div class="row g-4">

                <div class="col-md-4">

                    <label class="detail-label">
                        Name
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->supervisor_name ?: '—' }}
                    </div>

                </div>

                <div class="col-md-4">

                    <label class="detail-label">
                        Designation
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->supervisor_designation ?: '—' }}
                    </div>

                </div>

                <div class="col-md-4">

                    <label class="detail-label">
                        Department
                    </label>

                    <div class="detail-value">
                        {{ $goalInitiative->supervisor_department ?: '—' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- EVIDENCE --}}

    <div class="section-card mb-4">

        <div class="section-header">

            <h5 class="mb-1 fw-bold">
                Evidence
            </h5>

        </div>

        <div class="section-body">

            @if($goalInitiative->evidence_attachment)

                <a href="{{ asset('storage/' . $goalInitiative->evidence_attachment) }}"
                   target="_blank"
                   class="evidence-link">

                    <i class="fas fa-paperclip me-2"></i>

                    View Evidence Attachment

                    <i class="fas fa-external-link-alt ms-2"></i>

                </a>

            @else

                <span class="text-muted">
                    No evidence attachment provided.
                </span>

            @endif

        </div>

    </div>

</div>

<style>

:root {
    --pms-primary:#1f4e79;
    --pms-border:#e4e9f0;
    --pms-text:#253449;
    --pms-muted:#718096;
}

.goal-page-header {
    background:linear-gradient(135deg,#fff,#f5f8fc);
    border:1px solid var(--pms-border);
    border-radius:16px;
    padding:22px 26px;
    box-shadow:0 4px 18px rgba(31,78,121,.06);
}

.header-icon {
    width:48px;
    height:48px;
    border-radius:12px;
    background:var(--pms-primary);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
}

.section-card {
    background:#fff;
    border:1px solid var(--pms-border);
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 4px 18px rgba(31,78,121,.06);
}

.section-header {
    background:#f8fafc;
    border-bottom:1px solid var(--pms-border);
    padding:18px 22px;
}

.section-header small {
    color:var(--pms-muted);
}

.section-body {
    padding:24px;
}

.detail-label {
    display:block;
    color:var(--pms-muted);
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.4px;
    margin-bottom:7px;
}

.detail-value {
    color:var(--pms-text);
    font-weight:600;
}

.detail-value.large {
    font-size:18px;
}

.content-box {
    background:#f8fafc;
    border:1px solid var(--pms-border);
    border-radius:10px;
    padding:15px;
    line-height:1.7;
    color:var(--pms-text);
}

.remarks-box {
    background:#fff8e8;
    border:1px solid #f4dfad;
    border-radius:10px;
    padding:15px;
    color:#745500;
}

.status-badge {
    display:inline-flex;
    align-items:center;
    padding:8px 12px;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
}

.status-submitted {
    background:#fff7e6;
    color:#9a6700;
}

.status-approved {
    background:#eaf8ef;
    color:#237a3b;
}

.status-amended {
    background:#eef2ff;
    color:#4c51bf;
}

.status-rejected {
    background:#fff0f0;
    color:#c53030;
}

.evidence-link {
    display:inline-flex;
    align-items:center;
    padding:12px 16px;
    border:1px solid #dbe2ea;
    border-radius:10px;
    color:var(--pms-primary);
    text-decoration:none;
    font-weight:600;
    background:#f8fafc;
}

.evidence-link:hover {
    background:#f2f7fc;
}

.btn-primary {
    background:var(--pms-primary);
    border-color:var(--pms-primary);
}

</style>

@endsection