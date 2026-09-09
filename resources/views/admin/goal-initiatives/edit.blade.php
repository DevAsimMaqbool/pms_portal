@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="goal-page-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>

                <div>

                    <h3 class="fw-bold mb-1">
                        Edit Initiative / Extra Role
                    </h3>

                    <p class="mb-0 text-muted">
                        Update your initiative details.
                    </p>

                </div>

            </div>

            <a href="{{ route('goal-initiatives.index') }}"
               class="btn btn-light border shadow-sm px-4">

                <i class="fas fa-arrow-left me-2"></i>
                Back

            </a>

        </div>

    </div>

    {{-- ERRORS --}}

    @if($errors->any())

        <div class="alert alert-danger border-0 shadow-sm mb-4">

            <strong>
                Please correct the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    {{-- REJECTION REMARKS --}}

    @if($goalInitiative->manager_decision === 'rejected')

        <div class="alert alert-warning border-0 shadow-sm mb-4">

            <div class="fw-bold mb-1">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Initiative Rejected by Manager
            </div>

            @if($goalInitiative->manager_remarks)

                <div>
                    {{ $goalInitiative->manager_remarks }}
                </div>

            @endif

            <small class="d-block mt-2">
                You can update the initiative and submit it again.
            </small>

        </div>

    @endif

    <form method="POST"
          action="{{ route('goal-initiatives.update', $goalInitiative) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- TITLE --}}

        <div class="section-card mb-4">

            <div class="section-header">

                <h5 class="mb-1 fw-bold">
                    Initiative Details
                </h5>

                <small>
                    Provide the basic details of the initiative or extra role.
                </small>

            </div>

            <div class="section-body">

                <label class="form-label fw-semibold">
                    Title of Initiative / Extra Role
                    <span class="text-danger">*</span>
                </label>

                <input type="text"
                       name="title"
                       value="{{ old('title', $goalInitiative->title) }}"
                       class="form-control"
                       required>

            </div>

        </div>

        {{-- DATES --}}

        <div class="section-card mb-4">

            <div class="section-body">

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            From Date
                            <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ old('from_date', $goalInitiative->from_date?->format('Y-m-d')) }}"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            To Date
                            <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ old('to_date', $goalInitiative->to_date?->format('Y-m-d')) }}"
                               class="form-control"
                               required>

                    </div>

                </div>

            </div>

        </div>

        {{-- NATURE --}}

        <div class="section-card mb-4">

            <div class="section-body">

                <label class="form-label fw-semibold">
                    Nature of Initiative
                    <span class="text-danger">*</span>
                </label>

                <select name="nature_of_initiative"
                        id="nature_of_initiative"
                        class="form-select"
                        required>

                    <option value="">
                        Select Nature
                    </option>

                    @foreach($natureOptions as $nature)

                        <option value="{{ $nature }}"
                            {{ old('nature_of_initiative', $goalInitiative->nature_of_initiative) === $nature ? 'selected' : '' }}>

                            {{ $nature }}

                        </option>

                    @endforeach

                </select>

                <div id="nature_other_wrapper"
                     class="mt-3"
                     style="display:none;">

                    <label class="form-label fw-semibold">
                        Please specify
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="nature_other"
                           id="nature_other"
                           value="{{ old('nature_other', $goalInitiative->nature_other) }}"
                           class="form-control"
                           placeholder="Enter nature of initiative">

                </div>

            </div>

        </div>

        {{-- SCOPE --}}

        <div class="section-card mb-4">

            <div class="section-body">

                <label class="form-label fw-semibold mb-3">
                    Scope
                    <span class="text-danger">*</span>
                </label>

                <div class="scope-options">

                    @foreach($scopeOptions as $value => $label)

                        <label class="scope-option">

                            <input type="radio"
                                   name="scope"
                                   value="{{ $value }}"
                                   {{ old('scope', $goalInitiative->scope) === $value ? 'checked' : '' }}
                                   required>

                            <span>
                                {{ $label }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- DESCRIPTION --}}

        <div class="section-card mb-4">

            <div class="section-body">

                <label class="form-label fw-semibold">
                    Description of the Initiative
                    <span class="text-danger">*</span>
                </label>

                <textarea name="description"
                          class="form-control"
                          rows="6"
                          maxlength="10000"
                          required>{{ old('description', $goalInitiative->description) }}</textarea>

            </div>

        </div>

        {{-- STATUS --}}

        <div class="section-card mb-4">

            <div class="section-body">

                <label class="form-label fw-semibold">
                    Status
                    <span class="text-danger">*</span>
                </label>

                <select name="status"
                        class="form-select"
                        required>

                    <option value="">
                        Select Status
                    </option>

                    @foreach($statusOptions as $value => $label)

                        <option value="{{ $value }}"
                            {{ old('status', $goalInitiative->status) === $value ? 'selected' : '' }}>

                            {{ $label }}

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        {{-- OUTCOME --}}

        <div class="section-card mb-4">

            <div class="section-body">

                <label class="form-label fw-semibold">
                    Outcome(s) of the Initiative
                </label>

                <textarea name="outcome"
                          class="form-control"
                          rows="6"
                          maxlength="10000">{{ old('outcome', $goalInitiative->outcome) }}</textarea>

            </div>

        </div>

        {{-- IMPACT --}}

        <div class="section-card mb-4">

            <div class="section-header">

                <h5 class="mb-1 fw-bold">
                    I - Impact
                </h5>

                <small>
                    Describe the reach, outcome and sustainability.
                </small>

            </div>

            <div class="section-body">

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Reach
                    </label>

                    <input type="text"
                           name="impact_reach"
                           value="{{ old('impact_reach', $goalInitiative->impact_reach) }}"
                           class="form-control">

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Outcome
                    </label>

                    <input type="text"
                           name="impact_outcome"
                           value="{{ old('impact_outcome', $goalInitiative->impact_outcome) }}"
                           class="form-control">

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Sustainability
                    </label>

                    <select name="sustainability"
                            id="sustainability"
                            class="form-select">

                        <option value="">Select</option>

                        <option value="one_off"
                            {{ old('sustainability', $goalInitiative->sustainability) === 'one_off' ? 'selected' : '' }}>
                            One Off
                        </option>

                        <option value="adopted_standard_practice"
                            {{ old('sustainability', $goalInitiative->sustainability) === 'adopted_standard_practice' ? 'selected' : '' }}>
                            Adopted / Implemented as Standard Practice
                        </option>

                    </select>

                </div>

                <div class="mb-4"
                     id="sustainability_field_wrapper"
                     style="display:none;">

                    <label class="form-label fw-semibold">
                        Sustainability Description
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="sustainability_field"
                           id="sustainability_field"
                           value="{{ old('sustainability_field', $goalInitiative->sustainability_field) }}"
                           class="form-control">

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Strategic Alignment
                    </label>

                    <select name="strategic_alignment"
                            id="strategic_alignment"
                            class="form-select">

                        <option value="">Select</option>

                        <option value="not_linked"
                            {{ old('strategic_alignment', $goalInitiative->strategic_alignment) === 'not_linked' ? 'selected' : '' }}>
                            Not Linked to Any Departmental / Institutional Goal
                        </option>

                        <option value="linked"
                            {{ old('strategic_alignment', $goalInitiative->strategic_alignment) === 'linked' ? 'selected' : '' }}>
                            Linked to Departmental / Institutional Goal
                        </option>

                    </select>

                </div>

                <div class="mb-4"
                     id="strategic_goal_wrapper"
                     style="display:none;">

                    <label class="form-label fw-semibold">
                        Strategic Alignment Description
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="strategic_goal"
                           id="strategic_goal"
                           value="{{ old('strategic_goal', $goalInitiative->strategic_goal) }}"
                           class="form-control">

                </div>

            </div>

        </div>

        {{-- SUPERVISOR --}}

        <div class="section-card mb-4">

            <div class="section-header">

                <h5 class="mb-1 fw-bold">
                    J - Initiative Supervised / Endorsed By
                </h5>

                <small>
                    Supervisor, project head or endorser details.
                </small>

            </div>

            <div class="section-body">

                <div class="row g-4">

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Name of Supervisor
                        </label>

                        <input type="text"
                               name="supervisor_name"
                               value="{{ old('supervisor_name', $goalInitiative->supervisor_name) }}"
                               class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Designation
                        </label>

                        <input type="text"
                               name="supervisor_designation"
                               value="{{ old('supervisor_designation', $goalInitiative->supervisor_designation) }}"
                               class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Department
                        </label>

                        <input type="text"
                               name="supervisor_department"
                               value="{{ old('supervisor_department', $goalInitiative->supervisor_department) }}"
                               class="form-control">

                    </div>

                </div>

            </div>

        </div>

        {{-- EVIDENCE --}}

        <div class="section-card mb-4">

            <div class="section-header">

                <h5 class="mb-1 fw-bold">
                    Evidence of Initiative
                </h5>

                <small>
                    Upload supporting evidence.
                </small>

            </div>

            <div class="section-body">

                @if($goalInitiative->evidence_attachment)

                    <div class="existing-file mb-3">

                        <i class="fas fa-paperclip me-2"></i>

                        Existing Evidence

                        <a href="{{ asset('storage/' . $goalInitiative->evidence_attachment) }}"
                           target="_blank"
                           class="ms-2">

                            View

                        </a>

                    </div>

                @endif

                <label class="form-label fw-semibold">
                    Replace Attachment
                </label>

                <input type="file"
                       name="evidence_attachment"
                       class="form-control"
                       accept=".doc,.docx,.pdf,.png,.jpg,.jpeg">

                <small class="form-hint">
                    Supported formats: DOC, DOCX, PDF, PNG, JPG and JPEG.
                    Maximum size: 10 MB.
                </small>

            </div>

        </div>

        {{-- ACTIONS --}}

        <div class="form-actions">

            <a href="{{ route('goal-initiatives.index') }}"
               class="btn btn-light border px-4">

                <i class="fas fa-times me-2"></i>
                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary px-4 shadow-sm">

                <i class="fas fa-save me-2"></i>
                Update & Submit Again

            </button>

        </div>

    </form>

</div>

<style>

:root {
    --pms-primary:#1f4e79;
    --pms-primary-dark:#173a5c;
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

.form-label {
    color:var(--pms-text);
}

.form-control,
.form-select {
    border-color:#dbe2ea;
    border-radius:10px;
    padding:11px 14px;
}

.form-control:focus,
.form-select:focus {
    border-color:var(--pms-primary);
    box-shadow:0 0 0 .2rem rgba(31,78,121,.10);
}

.scope-options {
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:12px;
}

.scope-option {
    cursor:pointer;
    margin:0;
}

.scope-option input {
    display:none;
}

.scope-option span {
    display:block;
    padding:15px;
    border:1px solid #dfe6ee;
    border-radius:12px;
    background:#fff;
    color:var(--pms-text);
    font-weight:600;
}

.scope-option input:checked + span {
    border:2px solid var(--pms-primary);
    background:#f2f7fc;
    color:var(--pms-primary);
}

.form-hint {
    display:block;
    color:var(--pms-muted);
    font-size:12px;
    margin-top:7px;
}

.existing-file {
    padding:12px 15px;
    background:#f8fafc;
    border:1px solid var(--pms-border);
    border-radius:10px;
}

.form-actions {
    display:flex;
    justify-content:flex-end;
    gap:10px;
    padding:18px 0;
}

.btn-primary {
    background:var(--pms-primary);
    border-color:var(--pms-primary);
}

@media(max-width:768px) {

    .scope-options {
        grid-template-columns:1fr;
    }

    .form-actions {
        flex-direction:column-reverse;
    }

    .form-actions .btn {
        width:100%;
    }

}

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | NATURE - OTHER
    |--------------------------------------------------------------------------
    */

    const nature = document.getElementById('nature_of_initiative');

    const natureOtherWrapper =
        document.getElementById('nature_other_wrapper');

    const natureOther =
        document.getElementById('nature_other');

    function toggleNatureOther() {

        if (nature.value === 'Others') {

            natureOtherWrapper.style.display = 'block';

            natureOther.required = true;

        } else {

            natureOtherWrapper.style.display = 'none';

            natureOther.required = false;

        }

    }

    nature.addEventListener(
        'change',
        toggleNatureOther
    );

    toggleNatureOther();

    /*
    |--------------------------------------------------------------------------
    | SUSTAINABILITY DESCRIPTION
    |--------------------------------------------------------------------------
    */

    const sustainability =
        document.getElementById('sustainability');

    const sustainabilityWrapper =
        document.getElementById('sustainability_field_wrapper');

    const sustainabilityField =
        document.getElementById('sustainability_field');

    function toggleSustainabilityField() {

        if (sustainability.value !== '') {

            sustainabilityWrapper.style.display = 'block';

            sustainabilityField.required = true;

        } else {

            sustainabilityWrapper.style.display = 'none';

            sustainabilityField.required = false;

        }

    }

    sustainability.addEventListener(
        'change',
        toggleSustainabilityField
    );

    toggleSustainabilityField();

    /*
    |--------------------------------------------------------------------------
    | STRATEGIC ALIGNMENT DESCRIPTION
    |--------------------------------------------------------------------------
    */

    const strategicAlignment =
        document.getElementById('strategic_alignment');

    const strategicGoalWrapper =
        document.getElementById('strategic_goal_wrapper');

    const strategicGoal =
        document.getElementById('strategic_goal');

    function toggleStrategicGoal() {

        if (strategicAlignment.value !== '') {

            strategicGoalWrapper.style.display = 'block';

            strategicGoal.required = true;

        } else {

            strategicGoalWrapper.style.display = 'none';

            strategicGoal.required = false;

        }

    }

    strategicAlignment.addEventListener(
        'change',
        toggleStrategicGoal
    );

    toggleStrategicGoal();

});

</script>

@endsection