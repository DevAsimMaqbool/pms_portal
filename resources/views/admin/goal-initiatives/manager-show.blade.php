@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

```
{{-- HEADER --}}
<div class="goal-page-header mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div class="d-flex align-items-center gap-3">

            <div class="header-icon">
                <i class="fas fa-user-check"></i>
            </div>

            <div>
                <h3 class="mb-1">Initiative / Extra Role Review</h3>
                <p class="mb-0">
                    Review the initiative and provide your validation decision.
                </p>
            </div>

        </div>

        <a href="{{ route('goal-initiatives.manager.index') }}"
           class="btn btn-light">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Pending
        </a>

    </div>

</div>

{{-- ALERTS --}}
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

{{-- EMPLOYEE --}}
<div class="pms-card mb-4">

    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-user"></i>
        </div>

        <div>
            <h5>Employee Information</h5>
            <span>Submitted by the following team member</span>
        </div>
    </div>

    <div class="section-body">

        <div class="employee-profile">

            <div class="large-avatar">
                {{ strtoupper(substr($goalInitiative->user->name ?? 'U', 0, 1)) }}
            </div>

            <div>

                <h4>
                    {{ $goalInitiative->user->name ?? 'N/A' }}
                </h4>

                @if($goalInitiative->user?->employee_id)
                    <div class="profile-detail">
                        <i class="fas fa-id-badge"></i>
                        Employee ID:
                        <strong>{{ $goalInitiative->user->employee_id }}</strong>
                    </div>
                @endif

                @if($goalInitiative->user?->manager_name)
                    <div class="profile-detail">
                        <i class="fas fa-user-tie"></i>
                        Manager:
                        <strong>{{ $goalInitiative->user->manager_name }}</strong>
                    </div>
                @endif

            </div>

        </div>

    </div>

</div>

{{-- INITIATIVE --}}
<div class="pms-card mb-4">

    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-lightbulb"></i>
        </div>

        <div>
            <h5>Initiative Details</h5>
            <span>Information submitted by the employee</span>
        </div>
    </div>

    <div class="section-body">

        <div class="row g-4">

            <div class="col-md-8">

                <label class="detail-label">Title</label>

                <div class="detail-value title-value">
                    {{ $goalInitiative->title }}
                </div>

            </div>

            <div class="col-md-4">

                <label class="detail-label">Nature of Initiative</label>

                <div class="detail-value">
                    {{ $goalInitiative->nature_of_initiative }}

                    @if($goalInitiative->nature_of_initiative === 'Others' && $goalInitiative->nature_other)
                        <div class="small text-muted mt-1">
                            {{ $goalInitiative->nature_other }}
                        </div>
                    @endif
                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">From Date</label>

                <div class="detail-value">
                    {{ optional($goalInitiative->from_date)->format('d M Y') }}
                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">To Date</label>

                <div class="detail-value">
                    {{ optional($goalInitiative->to_date)->format('d M Y') }}
                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">Scope</label>

                <div class="detail-value">

                    @php
                        $scopeLabels = [
                            'individual'       => 'Individual',
                            'team_peer'        => 'Team / Peer',
                            'departmental'     => 'Departmental',
                            'faculty_wide'     => 'Faculty Wide',
                            'institution_wide' => 'Institution Wide',
                        ];
                    @endphp

                    {{ $scopeLabels[$goalInitiative->scope] ?? ucfirst(str_replace('_', ' ', $goalInitiative->scope)) }}

                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">Status</label>

                @php
                    $statusLabels = [
                        'idea_designed_only'   => 'Idea Designed Only',
                        'approved_in_progress' => 'Approved and In Progress',
                        'completed'            => 'Completed',
                        'completed_verified'   => 'Completed and Verified by Manager / Project Head',
                    ];
                @endphp

                <div class="detail-value">
                    {{ $statusLabels[$goalInitiative->status] ?? ucfirst(str_replace('_', ' ', $goalInitiative->status)) }}
                </div>

            </div>

            <div class="col-12">

                <label class="detail-label">Description</label>

                <div class="detail-box">
                    {!! nl2br(e($goalInitiative->description)) !!}
                </div>

            </div>

        </div>

    </div>

</div>

{{-- OUTCOME & IMPACT --}}
<div class="pms-card mb-4">

    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-chart-line"></i>
        </div>

        <div>
            <h5>Outcome & Impact</h5>
            <span>Expected and achieved impact of the initiative</span>
        </div>
    </div>

    <div class="section-body">

        <div class="row g-4">

            <div class="col-12">

                <label class="detail-label">Outcome</label>

                <div class="detail-box">
                    @if($goalInitiative->outcome)
                        {!! nl2br(e($goalInitiative->outcome)) !!}
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">Impact – Reach</label>

                <div class="detail-box">
                    @if($goalInitiative->impact_reach)
                        {!! nl2br(e($goalInitiative->impact_reach)) !!}
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">Impact – Outcome</label>

                <div class="detail-box">
                    @if($goalInitiative->impact_outcome)
                        {!! nl2br(e($goalInitiative->impact_outcome)) !!}
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>

            </div>

            <div class="col-md-6">

                <label class="detail-label">Sustainability</label>

                <div class="detail-value">
                    @if($goalInitiative->sustainability === 'one_off')
                        One-off Initiative
                    @elseif($goalInitiative->sustainability === 'adopted_standard_practice')
                        Adopted as Standard Practice
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif
                </div>

            </div>

            @if($goalInitiative->sustainability_field)

                <div class="col-md-6">

                    <label class="detail-label">Sustainability Description</label>

                    <div class="detail-box">
                        {!! nl2br(e($goalInitiative->sustainability_field)) !!}
                    </div>

                </div>

            @endif

            <div class="col-md-6">

                <label class="detail-label">Strategic Alignment</label>

                <div class="detail-value">

                    @if($goalInitiative->strategic_alignment === 'linked')
                        Linked
                    @elseif($goalInitiative->strategic_alignment === 'not_linked')
                        Not Linked
                    @else
                        <span class="text-muted">Not provided</span>
                    @endif

                </div>

            </div>

            @if($goalInitiative->strategic_goal)

                <div class="col-md-6">

                    <label class="detail-label">Strategic Alignment Description</label>

                    <div class="detail-box">
                        {!! nl2br(e($goalInitiative->strategic_goal)) !!}
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

{{-- SUPERVISOR --}}
<div class="pms-card mb-4">

    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-user-tie"></i>
        </div>

        <div>
            <h5>Supervisor / Project Head</h5>
            <span>Supervisor information provided by the employee</span>
        </div>
    </div>

    <div class="section-body">

        <div class="row g-4">

            <div class="col-md-4">

                <label class="detail-label">Name</label>

                <div class="detail-value">
                    {{ $goalInitiative->supervisor_name ?: 'Not provided' }}
                </div>

            </div>

            <div class="col-md-4">

                <label class="detail-label">Designation</label>

                <div class="detail-value">
                    {{ $goalInitiative->supervisor_designation ?: 'Not provided' }}
                </div>

            </div>

            <div class="col-md-4">

                <label class="detail-label">Department</label>

                <div class="detail-value">
                    {{ $goalInitiative->supervisor_department ?: 'Not provided' }}
                </div>

            </div>

        </div>

    </div>

</div>

{{-- EVIDENCE --}}
<div class="pms-card mb-4">

    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-paperclip"></i>
        </div>

        <div>
            <h5>Evidence</h5>
            <span>Supporting document attached by employee</span>
        </div>
    </div>

    <div class="section-body">

        @if($goalInitiative->evidence_attachment)

            <a href="{{ Storage::url($goalInitiative->evidence_attachment) }}"
               target="_blank"
               class="evidence-link">
                <i class="fas fa-file-alt me-2"></i>
                View / Open Evidence
                <i class="fas fa-external-link-alt ms-2"></i>
            </a>

        @else

            <span class="text-muted">
                <i class="fas fa-file-slash me-2"></i>
                No evidence attached.
            </span>

        @endif

    </div>

</div>

{{-- MANAGER DECISION --}}
@if($goalInitiative->manager_decision === 'submitted')

    <div class="pms-card decision-card mb-4">

        <div class="section-header decision-header">

            <div class="section-icon">
                <i class="fas fa-gavel"></i>
            </div>

            <div>
                <h5>Manager Validation</h5>
                <span>
                    Please review the initiative and provide your decision.
                </span>
            </div>

        </div>

        <div class="section-body">

            <form method="POST"
                  action=""
                  id="decisionForm">

                @csrf

                <div class="mb-4">

                    <label for="manager_remarks" class="form-label decision-label">
                        Manager Remarks
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="manager_remarks"
                        id="manager_remarks"
                        rows="5"
                        class="form-control manager-remarks @error('manager_remarks') is-invalid @enderror"
                        placeholder="Please provide your remarks / feedback..."
                        required>{{ old('manager_remarks') }}</textarea>

                    @error('manager_remarks')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        Remarks are required for all three decisions.
                    </div>

                </div>

                <div class="decision-actions">

                    {{-- APPROVE --}}
                    <button type="submit"
                            class="decision-btn approve-btn"
                            data-action="{{ route('goal-initiatives.approve', $goalInitiative) }}"
                            onclick="return confirmDecision(
                                this,
                                'Approve Initiative',
                                'Are you sure you want to approve this initiative?'
                            )">

                        <i class="fas fa-check-circle"></i>

                        <span>
                            <strong>Approve</strong>
                            <small>Approve as submitted</small>
                        </span>

                    </button>

                    {{-- APPROVE WITH AMENDMENT --}}
                    <button type="submit"
                            class="decision-btn amendment-btn"
                            data-action="{{ route('goal-initiatives.approve-with-amendment', $goalInitiative) }}"
                            onclick="return confirmDecision(
                                this,
                                'Approve with Amendment',
                                'Are you sure you want to approve this initiative with amendment?'
                            )">

                        <i class="fas fa-edit"></i>

                        <span>
                            <strong>Approve with Amendment</strong>
                            <small>Approve with your remarks / changes</small>
                        </span>

                    </button>

                    {{-- REJECT --}}
                    <button type="submit"
                            class="decision-btn reject-btn"
                            data-action="{{ route('goal-initiatives.reject', $goalInitiative) }}"
                            onclick="return confirmDecision(
                                this,
                                'Reject Initiative',
                                'Are you sure you want to reject this initiative?'
                            )">

                        <i class="fas fa-times-circle"></i>

                        <span>
                            <strong>Reject</strong>
                            <small>Return to employee for correction</small>
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

@else

    {{-- ALREADY PROCESSED --}}
    <div class="pms-card mb-4">

        <div class="section-header">

            <div class="section-icon">
                <i class="fas fa-check-double"></i>
            </div>

            <div>
                <h5>Manager Validation Completed</h5>
                <span>This initiative has already been processed.</span>
            </div>

        </div>

        <div class="section-body">

            @php
                $decisionLabels = [
                    'approved' => 'Approved',
                    'approved_with_amendment' => 'Approved with Amendment',
                    'rejected' => 'Rejected',
                ];
            @endphp

            <div class="validation-result">

                <div>
                    <span class="detail-label">Decision</span>

                    <div class="decision-result
                        {{ $goalInitiative->manager_decision === 'approved'
                            ? 'result-approved'
                            : ($goalInitiative->manager_decision === 'rejected'
                                ? 'result-rejected'
                                : 'result-amended') }}">

                        {{ $decisionLabels[$goalInitiative->manager_decision] ?? ucfirst($goalInitiative->manager_decision) }}

                    </div>
                </div>

                <div>
                    <span class="detail-label">Manager</span>

                    <div class="detail-value">
                        {{ $goalInitiative->manager?->name ?? 'N/A' }}
                    </div>
                </div>

                <div>
                    <span class="detail-label">Decision Date</span>

                    <div class="detail-value">
                        {{ $goalInitiative->manager_decided_at?->format('d M Y h:i A') ?? 'N/A' }}
                    </div>
                </div>

            </div>

            <div class="mt-4">

                <label class="detail-label">
                    Manager Remarks
                </label>

                <div class="detail-box">
                    {!! nl2br(e($goalInitiative->manager_remarks ?? 'No remarks provided.')) !!}
                </div>

            </div>

        </div>

    </div>

@endif
```

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
        background: linear-gradient(
            135deg,
            var(--pms-primary),
            var(--pms-primary-dark)
        );
        color: #fff;
        border-radius: 14px;
        padding: 22px 26px;
        box-shadow: 0 8px 25px rgba(31, 78, 121, .12);
    }

    .header-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .goal-page-header h3 {
        color: #fff;
        font-weight: 700;
    }

    .goal-page-header p {
        color: rgba(255,255,255,.78);
    }

    .goal-page-header .btn-light {
        border: 0;
        font-weight: 600;
        border-radius: 8px;
        padding: 9px 15px;
    }

    .pms-card {
        background: #fff;
        border: 1px solid var(--pms-border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(37,52,73,.05);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 19px 22px;
        border-bottom: 1px solid var(--pms-border);
        background: #fafcff;
    }

    .section-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #edf4fa;
        color: var(--pms-primary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .section-header h5 {
        margin: 0 0 3px;
        color: var(--pms-text);
        font-weight: 700;
    }

    .section-header span {
        color: var(--pms-muted);
        font-size: 13px;
    }

    .section-body {
        padding: 24px 22px;
    }

    .employee-profile {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .large-avatar {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: #eaf1f8;
        color: var(--pms-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
    }

    .employee-profile h4 {
        color: var(--pms-text);
        font-weight: 700;
        margin-bottom: 7px;
    }

    .profile-detail {
        color: var(--pms-muted);
        font-size: 13px;
        margin-top: 4px;
    }

    .profile-detail i {
        width: 18px;
        color: var(--pms-primary);
    }

    .detail-label {
        display: block;
        color: var(--pms-muted);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 7px;
    }

    .detail-value {
        color: var(--pms-text);
        font-size: 14px;
        font-weight: 600;
    }

    .title-value {
        font-size: 20px;
        color: var(--pms-primary);
    }

    .detail-box {
        background: #f8fafc;
        border: 1px solid var(--pms-border);
        border-radius: 9px;
        padding: 14px 15px;
        color: var(--pms-text);
        font-size: 14px;
        line-height: 1.7;
    }

    .evidence-link {
        display: inline-flex;
        align-items: center;
        background: #edf4fa;
        color: var(--pms-primary);
        border: 1px solid #d7e5f1;
        border-radius: 8px;
        padding: 10px 15px;
        font-weight: 600;
        text-decoration: none;
    }

    .evidence-link:hover {
        background: #e2edf6;
        color: var(--pms-primary-dark);
    }

    .decision-card {
        border-color: #d8e4ef;
    }

    .decision-header {
        background: #f5f9fc;
    }

    .decision-label {
        color: var(--pms-text);
        font-weight: 700;
    }

    .manager-remarks {
        border: 1px solid var(--pms-border);
        border-radius: 9px;
        padding: 13px 14px;
        resize: vertical;
        min-height: 130px;
    }

    .manager-remarks:focus {
        border-color: var(--pms-primary);
        box-shadow: 0 0 0 3px rgba(31,78,121,.10);
    }

    .decision-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .decision-btn {
        border: 1px solid;
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: left;
        background: #fff;
        transition: .2s ease;
        cursor: pointer;
    }

    .decision-btn > i {
        font-size: 23px;
    }

    .decision-btn span {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .decision-btn strong {
        font-size: 14px;
    }

    .decision-btn small {
        font-size: 11px;
        opacity: .75;
    }

    .approve-btn {
        border-color: #b9dfc8;
        color: #218838;
    }

    .approve-btn:hover {
        background: #f0faf3;
    }

    .amendment-btn {
        border-color: #b8d3e8;
        color: var(--pms-primary);
    }

    .amendment-btn:hover {
        background: #f2f7fb;
    }

    .reject-btn {
        border-color: #f0c0c0;
        color: #c0392b;
    }

    .reject-btn:hover {
        background: #fff5f5;
    }

    .validation-result {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 25px;
    }

    .decision-result {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 700;
    }

    .result-approved {
        background: #e9f7ef;
        color: #218838;
    }

    .result-amended {
        background: #edf4fa;
        color: var(--pms-primary);
    }

    .result-rejected {
        background: #fff0f0;
        color: #c0392b;
    }

    @media (max-width: 900px) {

        .decision-actions {
            grid-template-columns: 1fr;
        }

        .validation-result {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 576px) {

        .goal-page-header {
            padding: 18px;
        }

        .goal-page-header .btn-light {
            width: 100%;
        }

        .section-body {
            padding: 18px;
        }

    }

</style>

<script>

    function confirmDecision(button, title, message) {

        const form = document.getElementById('decisionForm');
        const remarks = document.getElementById('manager_remarks');

        if (!remarks.value.trim()) {
            remarks.focus();
            remarks.classList.add('is-invalid');

            alert('Manager remarks are required.');

            return false;
        }

        remarks.classList.remove('is-invalid');

        if (!confirm(message + '\n\nThis decision cannot be changed afterwards.')) {
            return false;
        }

        form.action = button.dataset.action;

        return true;
    }

</script>

@endsection
