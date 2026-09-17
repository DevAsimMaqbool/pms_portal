@extends('layouts.app')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Rating + Color Mapping
    |--------------------------------------------------------------------------
    | Exact PMS rating thresholds and colors.
    */

    $getRatingMeta = function ($percentage) {

        if ($percentage === null || !is_numeric($percentage)) {
            return [
                'rating' => 'Pending',
                'color' => '#adb5bd',
                'text' => '#495057',
                'soft' => '#f1f3f5',
            ];
        }

        $percentage = (float) $percentage;

        if ($percentage >= 90) {

            return [
                'rating' => 'OS',
                'color' => '#6EA8FE',
                'text' => '#173a5c',
                'soft' => '#6EA8FE22',
            ];

        } elseif ($percentage >= 80) {

            return [
                'rating' => 'EE',
                'color' => '#96e2b4',
                'text' => '#155724',
                'soft' => '#96e2b422',
            ];

        } elseif ($percentage >= 70) {

            return [
                'rating' => 'ME',
                'color' => '#ffcb9a',
                'text' => '#7a4b00',
                'soft' => '#ffcb9a22',
            ];

        } elseif ($percentage >= 60) {

            return [
                'rating' => 'NI',
                'color' => '#fd7e13',
                'text' => '#ffffff',
                'soft' => '#fd7e1322',
            ];

        } else {

            return [
                'rating' => 'BE',
                'color' => '#ff4c51',
                'text' => '#ffffff',
                'soft' => '#ff4c5122',
            ];
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Weighted Scores
    |--------------------------------------------------------------------------
    | Calculate once and reuse.
    */

    $weightedManagerScore = $managerScore100 !== null
        ? round((float) $managerScore100 * 0.70, 2)
        : null;

    $weightedFeedbackScore = $feedbackScore100 !== null
        ? round((float) $feedbackScore100 * 0.30, 2)
        : null;

    $weightedTotal = (
        $weightedManagerScore !== null &&
        $weightedFeedbackScore !== null
    )
        ? round(
            $weightedManagerScore + $weightedFeedbackScore,
            2
        )
        : null;

    /*
    |--------------------------------------------------------------------------
    | Rating Metadata
    |--------------------------------------------------------------------------
    */

    $selfRatingMeta = $getRatingMeta($selfScore100);

    $managerRatingMeta = $getRatingMeta($managerScore100);

    $feedbackRatingMeta = $getRatingMeta($feedbackScore100);

    $totalRatingMeta = $getRatingMeta($weightedTotal);

    $hrRatingMeta = $getRatingMeta($hrScore100);

    $finalRatingMeta = $getRatingMeta($finalScore);

@endphp

<div class="container-fluid py-3">

    {{-- =========================================================
        EMPLOYEE INFO + FINAL SCORE
    ========================================================== --}}

    <div class="performance-header mb-3">

        {{-- =====================================================
            EMPLOYEE INFORMATION
        ====================================================== --}}

        <div class="employee-info-card">

            <div class="employee-avatar">
                <i class="fas fa-user"></i>
            </div>

            <div class="employee-details">

                <div class="employee-top-line">

                    <div class="employee-name">
                        {{ $user->name ?? '—' }}
                    </div>

                    <span class="employee-profile-label">
                        Employee
                    </span>

                </div>

                <div class="employee-meta">

                    <span>
                        <i class="fas fa-id-badge"></i>
                        {{ $user->barcode ?? '—' }}
                    </span>

                    <span class="employee-divider">
                        •
                    </span>

                    <span>
                        <i class="fas fa-building"></i>

                        {{
                            isset($user->hr_department_name) &&
                            str_contains($user->hr_department_name, '/')
                                ? trim(last(explode('/', $user->hr_department_name)))
                                : ($user->hr_department_name ?? '—')
                        }}
                    </span>

                </div>

                <div class="employee-manager">

                    <span class="manager-label">

                        <i class="fas fa-user-tie"></i>

                        Line Manager

                    </span>

                    <span class="manager-name">
                        {{ $user->manager_name ?? '—' }}
                    </span>

                </div>

            </div>

        </div>

        {{-- =====================================================
            FINAL SCORE
        ====================================================== --}}

        <div
            class="header-final-score"
            style="
                --final-color: {{ $finalRatingMeta['color'] }};
                --final-text: {{ $finalRatingMeta['text'] }};
            "
        >

            <div class="final-score-glow"></div>

            <div class="header-final-score-content">

                <div class="header-final-score-title">

                    <div
                        class="header-final-score-icon"
                        style="
                            background: {{ $finalRatingMeta['soft'] }};
                            color: {{ $finalRatingMeta['color'] }};
                            border-color: {{ $finalRatingMeta['color'] }};
                        "
                    >
                        <i class="fas fa-award"></i>
                    </div>

                    <div>

                        <div
                            class="header-final-score-label"
                            style="color: {{ $finalRatingMeta['text'] }};"
                        >
                            FINAL SCORE
                        </div>

                        <div
                            class="header-final-score-caption"
                            style="color: {{ $finalRatingMeta['text'] }};"
                        >
                            Overall performance
                        </div>

                    </div>

                </div>

                <div
                    class="header-final-score-number"
                    style="color: {{ $finalRatingMeta['text'] }};"
                >

                    @if($finalScore !== null)

                        <strong style="color: {{ $finalRatingMeta['text'] }};">
                            {{ number_format($finalScore, 2) }}
                        </strong>

                        <span style="color: {{ $finalRatingMeta['text'] }};">
                            /100
                        </span>

                    @else

                        <strong style="color: {{ $finalRatingMeta['text'] }};">
                            —
                        </strong>

                    @endif

                </div>

                <div class="header-final-score-rating">

                    <span style="color: {{ $finalRatingMeta['text'] }};">
                        Rating
                    </span>

                    <strong
                        style="
                            background-color: {{ $finalRatingMeta['color'] }};
                            color: {{ $finalRatingMeta['text'] }};
                            border-color: {{ $finalRatingMeta['color'] }};
                        "
                    >
                        {{ $finalScore !== null
                            ? $finalRatingMeta['rating']
                            : 'Pending'
                        }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
        SCORE CARDS
    ========================================================== --}}

    <div class="score-grid mb-3">

        {{-- =====================================================
            SELF ASSESSMENT
        ====================================================== --}}

        <div
            class="performance-score-card"
            style="
                --rating-color: {{ $selfRatingMeta['color'] }};
                --rating-soft: {{ $selfRatingMeta['soft'] }};
            "
        >

            <div
                class="score-accent"
                style="background: {{ $selfRatingMeta['color'] }};"
            ></div>

            <div class="performance-score-top">

                <div
                    class="score-icon"
                    style="
                        background: {{ $selfRatingMeta['soft'] }};
                        color: {{ $selfRatingMeta['color'] }};
                    "
                >
                    <i class="fas fa-user"></i>
                </div>

                <div class="score-heading">

                    <div class="score-card-label">
                        Self Assessment
                    </div>

                    <div class="score-card-caption">
                        Employee rating
                    </div>

                </div>

            </div>

            <div
                class="performance-score-value"
                style="color: {{ $selfRatingMeta['color'] }};"
            >

                @if($selfScore100 !== null)

                    {{ number_format($selfScore100, 2) }}

                    <span>/100</span>

                @else

                    —

                @endif

            </div>

            <div class="score-card-bottom">

                <span
                    class="score-rating"
                    style="
                        background: {{ $selfRatingMeta['color'] }};
                        color: {{ $selfRatingMeta['text'] }};
                    "
                >
                    {{ $selfScore100 !== null
                        ? $selfRatingMeta['rating']
                        : 'Pending'
                    }}
                </span>

                <span class="score-scale">
                    Self Score
                </span>

            </div>

        </div>

        {{-- =====================================================
            MANAGER ASSESSMENT
        ====================================================== --}}

        <div
            class="performance-score-card"
            style="
                --rating-color: {{ $managerRatingMeta['color'] }};
                --rating-soft: {{ $managerRatingMeta['soft'] }};
            "
        >

            <div
                class="score-accent"
                style="background: {{ $managerRatingMeta['color'] }};"
            ></div>

            <div class="performance-score-top">

                <div
                    class="score-icon"
                    style="
                        background: {{ $managerRatingMeta['soft'] }};
                        color: {{ $managerRatingMeta['color'] }};
                    "
                >
                    <i class="fas fa-user-tie"></i>
                </div>

                <div class="score-heading">

                    <div class="score-card-label">
                        Manager Assessment
                    </div>

                    <div class="score-card-caption">
                        Weighted contribution
                    </div>

                </div>

            </div>

            <div
                class="performance-score-value"
                style="color: {{ $managerRatingMeta['color'] }};"
            >

                @if($weightedManagerScore !== null)

                    {{ number_format($weightedManagerScore, 2) }}

                    <span>/70</span>

                @else

                    —

                @endif

            </div>

            <div class="score-card-bottom">

                <span
                    class="score-rating"
                    style="
                        background: {{ $managerRatingMeta['color'] }};
                        color: {{ $managerRatingMeta['text'] }};
                    "
                >
                    {{ $managerScore100 !== null
                        ? $managerRatingMeta['rating']
                        : 'Pending'
                    }}
                </span>

                <span class="score-scale">
                    70%
                </span>

            </div>

        </div>

        {{-- =====================================================
            LINE MANAGER FEEDBACK
        ====================================================== --}}

        <div
            class="performance-score-card"
            style="
                --rating-color: {{ $feedbackRatingMeta['color'] }};
                --rating-soft: {{ $feedbackRatingMeta['soft'] }};
            "
        >

            <div
                class="score-accent"
                style="background: {{ $feedbackRatingMeta['color'] }};"
            ></div>

            <div class="performance-score-top">

                <div
                    class="score-icon"
                    style="
                        background: {{ $feedbackRatingMeta['soft'] }};
                        color: {{ $feedbackRatingMeta['color'] }};
                    "
                >
                    <i class="fas fa-comments"></i>
                </div>

                <div class="score-heading">

                    <div class="score-card-label">
                        Line Manager Feedback
                    </div>

                    <div class="score-card-caption">
                        Weighted contribution
                    </div>

                </div>

            </div>

            <div
                class="performance-score-value"
                style="color: {{ $feedbackRatingMeta['color'] }};"
            >

                @if($weightedFeedbackScore !== null)

                    {{ number_format($weightedFeedbackScore, 2) }}

                    <span>/30</span>

                @else

                    —

                @endif

            </div>

            <div class="score-card-bottom">

                <span
                    class="score-rating"
                    style="
                        background: {{ $feedbackRatingMeta['color'] }};
                        color: {{ $feedbackRatingMeta['text'] }};
                    "
                >
                    {{ $feedbackScore100 !== null
                        ? $feedbackRatingMeta['rating']
                        : 'Pending'
                    }}
                </span>

                <span class="score-scale">
                    30%
                </span>

            </div>

        </div>

        {{-- =====================================================
            TOTAL SCORE
        ====================================================== --}}

        <div
            class="performance-score-card total-card"
            style="
                --rating-color: {{ $totalRatingMeta['color'] }};
                --rating-soft: {{ $totalRatingMeta['soft'] }};
            "
        >

            <div
                class="score-accent"
                style="background: {{ $totalRatingMeta['color'] }};"
            ></div>

            <div class="performance-score-top">

                <div
                    class="score-icon"
                    style="
                        background: {{ $totalRatingMeta['soft'] }};
                        color: {{ $totalRatingMeta['color'] }};
                    "
                >
                    <i class="fas fa-calculator"></i>
                </div>

                <div class="score-heading">

                    <div class="score-card-label">
                        Total Score
                    </div>

                    <div class="score-card-caption">
                        Manager + Feedback
                    </div>

                </div>

            </div>

            <div
                class="performance-score-value total-value"
                style="color: {{ $totalRatingMeta['color'] }};"
            >

                @if($weightedTotal !== null)

                    {{ number_format($weightedTotal, 2) }}

                    <span>/100</span>

                @else

                    —

                @endif

            </div>

            <div class="score-card-bottom">

                <span
                    class="score-rating"
                    style="
                        background: {{ $totalRatingMeta['color'] }};
                        color: {{ $totalRatingMeta['text'] }};
                    "
                >
                    {{ $weightedTotal !== null
                        ? $totalRatingMeta['rating']
                        : 'Pending'
                    }}
                </span>

                <span class="score-scale">
                    70% + 30%
                </span>

            </div>

        </div>

        {{-- =====================================================
            HR ASSESSMENT
        ====================================================== --}}

        <div
            class="performance-score-card"
            style="
                --rating-color: {{ $hrRatingMeta['color'] }};
                --rating-soft: {{ $hrRatingMeta['soft'] }};
            "
        >

            <div
                class="score-accent"
                style="background: {{ $hrRatingMeta['color'] }};"
            ></div>

            <div class="performance-score-top">

                <div
                    class="score-icon"
                    style="
                        background: {{ $hrRatingMeta['soft'] }};
                        color: {{ $hrRatingMeta['color'] }};
                    "
                >
                    <i class="fas fa-user-shield"></i>
                </div>

                <div class="score-heading">

                    <div class="score-card-label">
                        HR Assessment
                    </div>

                    <div class="score-card-caption">
                        HR moderation
                    </div>

                </div>

            </div>

            <div
                class="performance-score-value"
                style="color: {{ $hrRatingMeta['color'] }};"
            >

                @if($hrScore100 !== null)

                    {{ number_format($hrScore100, 2) }}

                    <span>/100</span>

                @else

                    —

                @endif

            </div>

            <div class="score-card-bottom">

                <span
                    class="score-rating"
                    style="
                        background: {{ $hrRatingMeta['color'] }};
                        color: {{ $hrRatingMeta['text'] }};
                    "
                >
                    {{ $hrScore100 !== null
                        ? $hrRatingMeta['rating']
                        : 'Pending'
                    }}
                </span>

                <span class="score-scale">
                    HR Score
                </span>

            </div>

        </div>

    </div>

    {{-- =========================================================
        REVIEW JOURNEY
    ========================================================== --}}

    <div class="review-card">

        <div class="review-card-header">

            <div class="review-header-left">

                <div class="review-icon">
                    <i class="fas fa-route"></i>
                </div>

                <div>

                    <div class="review-title">
                        Review Journey
                    </div>

                    <div class="review-subtitle">
                        Current appraisal workflow and completion status
                    </div>

                </div>

            </div>

            <div class="journey-status
                {{ $finalized
                    ? 'journey-completed'
                    : 'journey-progress'
                }}">

                @if($finalized)

                    <i class="fas fa-check-circle"></i>
                    Completed

                @else

                    <i class="fas fa-clock"></i>
                    In Progress

                @endif

            </div>

        </div>

        <div class="review-card-body">

            <div class="review-steps">

                {{-- SELF REPORT --}}
                <div class="review-step">

                    <div class="review-step-icon
                        {{ $selfReportSubmitted
                            ? 'completed'
                            : 'pending'
                        }}">

                        @if($selfReportSubmitted)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-file-alt"></i>
                        @endif

                    </div>

                    <div class="review-step-content">

                        <div class="review-step-number">
                            01
                        </div>

                        <div class="review-step-title">
                            Self Report
                        </div>

                        <div class="review-step-status
                            {{ $selfReportSubmitted
                                ? 'status-completed'
                                : 'status-pending'
                            }}">

                            <span class="status-dot"></span>

                            {{ $selfReportSubmitted
                                ? 'Submitted'
                                : 'Pending'
                            }}

                        </div>

                    </div>

                </div>

                <div class="review-connector
                    {{ $selfReportSubmitted ? 'active' : '' }}">
                </div>

                {{-- MANAGER REVIEW --}}
                <div class="review-step">

                    <div class="review-step-icon
                        {{ $managerReviewCompleted
                            ? 'completed'
                            : 'pending'
                        }}">

                        @if($managerReviewCompleted)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-user-tie"></i>
                        @endif

                    </div>

                    <div class="review-step-content">

                        <div class="review-step-number">
                            02
                        </div>

                        <div class="review-step-title">
                            Manager Review
                        </div>

                        <div class="review-step-status
                            {{ $managerReviewCompleted
                                ? 'status-completed'
                                : 'status-pending'
                            }}">

                            <span class="status-dot"></span>

                            {{ $managerReviewCompleted
                                ? 'Completed'
                                : 'Pending'
                            }}

                        </div>

                    </div>

                </div>

                <div class="review-connector
                    {{ $managerReviewCompleted ? 'active' : '' }}">
                </div>

                {{-- HR REVIEW --}}
                <div class="review-step">

                    <div class="review-step-icon
                        {{ $hrReviewCompleted
                            ? 'completed'
                            : 'pending'
                        }}">

                        @if($hrReviewCompleted)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-user-shield"></i>
                        @endif

                    </div>

                    <div class="review-step-content">

                        <div class="review-step-number">
                            03
                        </div>

                        <div class="review-step-title">
                            HR Review
                        </div>

                        <div class="review-step-status
                            {{ $hrReviewCompleted
                                ? 'status-completed'
                                : 'status-pending'
                            }}">

                            <span class="status-dot"></span>

                            {{ $hrReviewCompleted
                                ? 'Completed'
                                : 'Pending'
                            }}

                        </div>

                    </div>

                </div>

                <div class="review-connector
                    {{ $hrReviewCompleted ? 'active' : '' }}">
                </div>

                {{-- FINALIZED --}}
                <div class="review-step">

                    <div class="review-step-icon
                        {{ $finalized
                            ? 'completed'
                            : 'pending'
                        }}">

                        @if($finalized)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-award"></i>
                        @endif

                    </div>

                    <div class="review-step-content">

                        <div class="review-step-number">
                            04
                        </div>

                        <div class="review-step-title">
                            Finalized
                        </div>

                        <div class="review-step-status
                            {{ $finalized
                                ? 'status-completed'
                                : 'status-pending'
                            }}">

                            <span class="status-dot"></span>

                            {{ $finalized
                                ? 'Finalized'
                                : 'In Progress'
                            }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {

    --pms-primary: #1f4e79;
    --pms-primary-dark: #173a5c;

    --pms-border: #e4e9f0;

    --pms-text: #253449;
    --pms-muted: #718096;

    --pms-bg: #f7f9fc;

}

/* =========================================================
   BODY
========================================================= */

body {
    background: var(--pms-bg);
}

/* =========================================================
   HEADER
========================================================= */

.performance-header {

    position: relative;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        235px;

    align-items: stretch;

    gap: 10px;

    padding: 10px;

    min-height: 88px;

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f5f8fc 100%
        );

    border: 1px solid var(--pms-border);

    border-radius: 14px;

    box-shadow:
        0 4px 18px
        rgba(31, 78, 121, .05);

    overflow: hidden;

}

.performance-header::before {

    content: '';

    position: absolute;

    left: 0;

    top: 11px;

    bottom: 11px;

    width: 3px;

    border-radius:
        0 4px 4px 0;

    background:
        var(--pms-primary);

}

/* =========================================================
   EMPLOYEE INFO
========================================================= */

.employee-info-card {

    position: relative;

    min-width: 0;

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 8px 11px;

    background:
        rgba(234, 242, 249, .78);

    border: 1px solid #d6e3ef;

    border-radius: 11px;

}

.employee-avatar {

    width: 42px;

    height: 42px;

    min-width: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    background: #ffffff;

    color: var(--pms-primary);

    font-size: 13px;

    box-shadow:
        0 3px 9px
        rgba(31, 78, 121, .07);

}

.employee-details {

    min-width: 0;

    flex: 1;

}

.employee-top-line {

    display: flex;

    align-items: center;

    gap: 7px;

    min-width: 0;

}

.employee-name {

    min-width: 0;

    color: var(--pms-text);

    font-size: 12px;

    font-weight: 800;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}

.employee-profile-label {

    flex: 0 0 auto;

    padding: 3px 6px;

    border-radius: 20px;

    background: #e8f1fa;

    color: var(--pms-primary);

    font-size: 6px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .5px;

}

.employee-meta {

    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 5px;

    margin-top: 4px;

    color: var(--pms-muted);

    font-size: 7px;

}

.employee-meta span {

    display: inline-flex;

    align-items: center;

}

.employee-meta i {

    color: var(--pms-primary);

    font-size: 7px;

}

.employee-divider {

    color: #b5c1cc;

}

.employee-manager {

    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 5px;

    margin-top: 4px;

    font-size: 7px;

}

.manager-label {

    display: inline-flex;

    align-items: center;

    gap: 4px;

    color: var(--pms-muted);

}

.manager-label i {

    color: var(--pms-primary);

    font-size: 7px;

}

.manager-name {

    min-width: 0;

    max-width: 260px;

    color: var(--pms-primary);

    font-weight: 700;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}

/* =========================================================
   FINAL SCORE
========================================================= */

.header-final-score {

    position: relative;

    min-width: 0;

    min-height: 66px;

    padding: 8px 11px;

    border-radius: 11px;

    background:
        linear-gradient(
            135deg,
            color-mix(in srgb, var(--final-color) 88%, white),
            color-mix(in srgb, var(--final-color) 72%, white)
        );

    color: var(--final-text);

    border: 1px solid
        color-mix(in srgb, var(--final-color) 65%, white);

    box-shadow:
        0 5px 15px
        color-mix(in srgb, var(--final-color) 15%, transparent);

    overflow: hidden;

}

.final-score-glow {

    position: absolute;

    width: 105px;

    height: 105px;

    right: -45px;

    top: -55px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.20);

}

.header-final-score-content {

    position: relative;

    z-index: 1;

    height: 100%;

    display: grid;

    grid-template-columns:
        1fr auto;

    grid-template-rows:
        auto 1fr;

    column-gap: 8px;

}

.header-final-score-title {

    grid-column: 1;

    display: flex;

    align-items: center;

    gap: 6px;

}

.header-final-score-icon {

    width: 23px;

    height: 23px;

    min-width: 23px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 7px;

    border: 1px solid transparent;

    font-size: 8px;

}

.header-final-score-label {

    font-size: 6px;

    font-weight: 800;

    letter-spacing: .7px;

}

.header-final-score-caption {

    margin-top: 2px;

    font-size: 6px;

    opacity: .70;

}

.header-final-score-number {

    grid-column: 2;

    grid-row: 1 / 3;

    display: flex;

    align-items: center;

    justify-content: center;

    white-space: nowrap;

}

.header-final-score-number strong {

    font-size: 25px;

    line-height: 1;

    font-weight: 800;

    letter-spacing: -.5px;

}

.header-final-score-number span {

    margin-left: 2px;

    font-size: 7px;

    font-weight: 600;

    opacity: .65;

}

.header-final-score-rating {

    grid-column: 1;

    align-self: end;

    display: flex;

    align-items: center;

    gap: 5px;

    margin-top: 3px;

}

.header-final-score-rating > span {

    font-size: 6px;

    opacity: .65;

}

.header-final-score-rating strong {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 25px;

    padding: 3px 7px;

    border-radius: 20px;

    border: 1px solid transparent;

    font-size: 6px;

    font-weight: 800;

}

/* =========================================================
   SCORE GRID
========================================================= */

.score-grid {

    display: grid;

    grid-template-columns:
        repeat(5, minmax(0, 1fr));

    gap: 9px;

}

/* =========================================================
   SCORE TILE
========================================================= */

.performance-score-card {

    position: relative;

    min-width: 0;

    min-height: 112px;

    padding: 12px;

    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            var(--rating-soft),
            #ffffff 78%
        );

    border: 1px solid
        color-mix(
            in srgb,
            var(--rating-color) 28%,
            #e4e9f0
        );

    border-radius: 12px;

    box-shadow:
        0 3px 12px
        color-mix(
            in srgb,
            var(--rating-color) 8%,
            transparent
        );

    transition:
        transform .16s ease,
        box-shadow .16s ease;

}

.performance-score-card:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 20px
        color-mix(
            in srgb,
            var(--rating-color) 16%,
            transparent
        );

}

.score-accent {

    position: absolute;

    top: 0;

    left: 0;

    width: 100%;

    height: 3px;

    border-radius:
        12px 12px 0 0;

}

/* =========================================================
   SCORE HEADER
========================================================= */

.performance-score-top {

    display: flex;

    align-items: center;

    gap: 7px;

}

.score-icon {

    width: 31px;

    height: 31px;

    min-width: 31px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    font-size: 10px;

}

.score-heading {

    min-width: 0;

}

.score-card-label {

    color: var(--pms-text);

    font-size: 9px;

    font-weight: 800;

    line-height: 1.2;

}

.score-card-caption {

    margin-top: 2px;

    color: var(--pms-muted);

    font-size: 7px;

    line-height: 1.2;

}

/* =========================================================
   SCORE VALUE
========================================================= */

.performance-score-value {

    margin-top: 13px;

    font-size: 22px;

    line-height: 1;

    font-weight: 800;

    letter-spacing: -.3px;

}

.performance-score-value span {

    color: var(--pms-muted);

    font-size: 8px;

    font-weight: 600;

    letter-spacing: 0;

}

/* =========================================================
   SCORE FOOTER
========================================================= */

.score-card-bottom {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 5px;

    margin-top: 9px;

}

.score-rating {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 27px;

    padding: 3px 7px;

    border-radius: 20px;

    font-size: 7px;

    font-weight: 800;

}

.score-scale {

    color: var(--pms-muted);

    font-size: 7px;

    white-space: nowrap;

}

/* =========================================================
   REVIEW CARD
========================================================= */

.review-card {

    overflow: hidden;

    background: #ffffff;

    border: 1px solid
        var(--pms-border);

    border-radius: 14px;

    box-shadow:
        0 3px 14px
        rgba(31, 78, 121, .04);

}

.review-card-header {

    min-height: 53px;

    padding: 10px 14px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 12px;

    background:
        linear-gradient(
            135deg,
            #f8fafc,
            #ffffff
        );

    border-bottom: 1px solid
        var(--pms-border);

}

.review-header-left {

    display: flex;

    align-items: center;

    gap: 9px;

}

.review-icon {

    width: 31px;

    height: 31px;

    min-width: 31px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    background: #e8f1fa;

    color: var(--pms-primary);

    font-size: 10px;

}

.review-title {

    color: var(--pms-text);

    font-size: 10px;

    font-weight: 800;

}

.review-subtitle {

    margin-top: 2px;

    color: var(--pms-muted);

    font-size: 7px;

}

.journey-status {

    display: inline-flex;

    align-items: center;

    gap: 4px;

    padding: 5px 8px;

    border-radius: 20px;

    font-size: 7px;

    font-weight: 700;

}

.journey-completed {

    background: #e7f6ed;

    color: #198754;

}

.journey-progress {

    background: #f1f4f8;

    color: var(--pms-muted);

}

/* =========================================================
   REVIEW BODY
========================================================= */

.review-card-body {

    padding: 17px 22px;

}

.review-steps {

    display: flex;

    align-items: flex-start;

    width: 100%;

}

.review-step {

    display: flex;

    flex-direction: column;

    align-items: center;

    width: 145px;

    min-width: 100px;

    text-align: center;

}

.review-step-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #f4f6f8;

    border: 2px solid #dce3ea;

    color: #8996a4;

    font-size: 11px;

}

.review-step-icon.completed {

    background: #e7f6ed;

    border-color: #b9dfc8;

    color: #198754;

    box-shadow:
        0 0 0 4px #f2faf5;

}

.review-step-icon.pending {

    background: #f5f7f9;

    border-color: #dce3ea;

    color: #8d99a6;

}

.review-step-content {

    margin-top: 7px;

}

.review-step-number {

    color: #a7b1bb;

    font-size: 6px;

    font-weight: 800;

    letter-spacing: .4px;

}

.review-step-title {

    margin-top: 2px;

    color: var(--pms-text);

    font-size: 8px;

    font-weight: 800;

    white-space: nowrap;

}

.review-step-status {

    display: inline-flex;

    align-items: center;

    gap: 4px;

    margin-top: 4px;

    padding: 3px 7px;

    border-radius: 20px;

    font-size: 6px;

    font-weight: 700;

}

.status-dot {

    width: 5px;

    height: 5px;

    border-radius: 50%;

    background: currentColor;

}

.status-completed {

    background: #e7f6ed;

    color: #198754;

}

.status-pending {

    background: #f1f4f8;

    color: #8996a4;

}

.review-connector {

    position: relative;

    flex: 1;

    min-width: 25px;

    max-width: 110px;

    height: 2px;

    margin-top: 18px;

    background: #e0e6eb;

}

.review-connector::after {

    content: '';

    position: absolute;

    right: 0;

    top: 50%;

    width: 5px;

    height: 5px;

    transform:
        translateY(-50%)
        rotate(45deg);

    border-top: 1px solid #d6dde4;

    border-right: 1px solid #d6dde4;

}

.review-connector.active {

    background: #a9d7ba;

}

.review-connector.active::after {

    border-color: #91caa5;

}

/* =========================================================
   RESPONSIVE - 1100
========================================================= */

@media (max-width: 1100px) {

    .score-grid {

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

    }

}

/* =========================================================
   RESPONSIVE - 991
========================================================= */

@media (max-width: 991px) {

    .performance-header {

        grid-template-columns:
            1fr;

    }

    .header-final-score {

        min-height: 70px;

    }

    .score-grid {

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

    }

}

/* =========================================================
   RESPONSIVE - 767
========================================================= */

@media (max-width: 767px) {

    .container-fluid {

        padding-left: 10px;
        padding-right: 10px;

    }

    .performance-header {

        padding: 9px;

    }

    .employee-avatar {

        width: 38px;

        height: 38px;

        min-width: 38px;

    }

    .employee-name {

        font-size: 10px;

    }

    .employee-profile-label {

        display: none;

    }

    .header-final-score-content {

        grid-template-columns:
            1fr auto;

    }

    .header-final-score-number {

        grid-column: 2;

        grid-row: 1 / 3;

    }

    .header-final-score-rating {

        grid-column: 1;

    }

    .score-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

    }

    .review-card-body {

        overflow-x: auto;

    }

    .review-steps {

        min-width: 650px;

    }

}

/* =========================================================
   RESPONSIVE - 480
========================================================= */

@media (max-width: 480px) {

    .score-grid {

        grid-template-columns:
            1fr;

    }

    .employee-meta {

        gap: 3px;

    }

    .employee-divider {

        display: none;

    }

    .employee-manager {

        align-items: flex-start;

        flex-direction: column;

        gap: 2px;

    }

    .manager-name {

        max-width: 100%;

    }

    .header-final-score {

        min-height: 68px;

    }

    .header-final-score-number strong {

        font-size: 22px;

    }

    .performance-score-card {

        min-height: 108px;

    }

}

</style>

@endsection