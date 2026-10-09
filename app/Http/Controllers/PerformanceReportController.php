<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use App\Models\GoalOverallReview;
use App\Models\LineManagerFeedback;
use App\Models\GoalInitiative;
use App\Models\NewGoal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PerformanceReportController extends Controller
{
    /**
     * Download logged-in employee's finalized performance appraisal report.
     */
    public function download()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | GET ALL SELF REPORTS
        |--------------------------------------------------------------------------
        |
        | A goal can have multiple self-reports.
        |
        | We first get ALL reports for the employee.
        | Then we select the LATEST report for each goal.
        |
        */
        $allReports = GoalSelfReport::with([
            'goal.s2rDriver',
            'reviews.reviewer',
        ])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MANAGER APPROVED GOALS ONLY
        |--------------------------------------------------------------------------
        |
        | For every goal:
        |
        | 1. Get the latest self-report.
        | 2. Check its status.
        | 3. Show ONLY if status = manager_approved.
        |
        | HR approval is NOT required here.
        |
        */
        $reports = $allReports
            ->groupBy('new_goal_id')
            ->map(function ($goalReports) {

                /*
                |--------------------------------------------------------------------------
                | Latest/current report for this goal
                |--------------------------------------------------------------------------
                */
                $report = $goalReports
                    ->sortByDesc('id')
                    ->first();

                if (!$report) {
                    return null;
                }

                /*
                |--------------------------------------------------------------------------
                | ONLY MANAGER APPROVED
                |--------------------------------------------------------------------------
                */
                if ($report->status !== 'manager_approved') {
                    return null;
                }

                /*
                |--------------------------------------------------------------------------
                | Extra safety:
                | Verify latest manager review is approved.
                |--------------------------------------------------------------------------
                |
                | The status column is the main source.
                | The review table is used as an additional verification.
                |
                */
                $managerReview = $report->reviews
                    ->where('reviewer_type', 'manager')
                    ->sortByDesc('id')
                    ->first();

                if (
                    $managerReview &&
                    $managerReview->decision !== 'approved'
                ) {
                    return null;
                }

                /*
                |--------------------------------------------------------------------------
                | Manager approved goal
                |--------------------------------------------------------------------------
                */
                return $report;
            })
            ->filter()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | OVERALL REVIEW
        |--------------------------------------------------------------------------
        */
        $overallReview = GoalOverallReview::where(
            'user_id',
            $user->id
        )
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | MANAGER OVERALL RATING
        |--------------------------------------------------------------------------
        */
        $managerOverallRating = null;

        $managerWeightedReports = $reports
        ->filter(function ($report) {
        return $report->manager_rating !== null
        && is_numeric($report->manager_rating)
        && $report->weightage !== null
        && is_numeric($report->weightage);
        });

        if ($managerWeightedReports->isNotEmpty()) {
        $managerOverallRating = round(
        $managerWeightedReports->sum(function ($report) {
        return (float) $report->manager_rating
        * ((float) $report->weightage / 100);
        }),
        2
        );
        }

        /*
        |--------------------------------------------------------------------------
        | HR OVERALL RATING
        |--------------------------------------------------------------------------
        */
        $hrOverallRating = null;

        if (
            $overallReview &&
            $overallReview->hr_overall_rating !== null
        ) {
            $hrOverallRating = (float)
                $overallReview->hr_overall_rating;
        }

        /*
        |--------------------------------------------------------------------------
        | SELF OVERALL RATING
        |--------------------------------------------------------------------------
        |
        | Calculated only from manager-approved goals.
        |
        */
        $selfRatings = $reports
        ->pluck('rating')
        ->filter(function ($value) {
        return $value !== null && is_numeric($value);
        })
        ->map(function ($value) {
        return (float) $value;
        });

        $selfOverallRating = $selfRatings->isNotEmpty()
        ? round($selfRatings->avg(), 2)
        : null;

        /*
        |--------------------------------------------------------------------------
        | MANAGER OVERALL RATING FALLBACK
        |--------------------------------------------------------------------------
        |
        | If the overall manager rating does not exist,
        | calculate it from manager-approved goals.
        |
        */
        if ($managerOverallRating === null) {

            $managerRatings = $reports
                ->pluck('manager_rating')
                ->filter(function ($value) {
                    return $value !== null
                        && is_numeric($value)
                        && (float) $value > 0;
                })
                ->map(function ($value) {
                    return (float) $value;
                });

            $managerOverallRating = $managerRatings->count()
                ? round($managerRatings->avg(), 2)
                : null;
        }

        /*
        |--------------------------------------------------------------------------
        | HR OVERALL RATING FALLBACK
        |--------------------------------------------------------------------------
        |
        | HR rating is still displayed if available.
        | It does NOT control whether a goal appears.
        |
        */
        if ($hrOverallRating === null) {

            $hrRatings = $reports
                ->pluck('hr_rating')
                ->filter(function ($value) {
                    return $value !== null
                        && is_numeric($value)
                        && (float) $value > 0;
                })
                ->map(function ($value) {
                    return (float) $value;
                });

            $hrOverallRating = $hrRatings->count()
                ? round($hrRatings->avg(), 2)
                : null;
        }

        /*
        |--------------------------------------------------------------------------
        | LINE MANAGER FEEDBACK
        |--------------------------------------------------------------------------
        */
        $lineManagerFeedback = LineManagerFeedback::where(
            'employee_id',
            $user->id
        )
            ->where('status', 1)
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | VIRTUE SCORES
        |--------------------------------------------------------------------------
        */
        $virtueScores = [
            'Honesty & Integrity' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'honesty_integrity_1',
                    'honesty_integrity_2',
                    'honesty_integrity_3',
                ]
            ),

            'Responsibility & Accountability' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'responsibility_accountability_1',
                    'responsibility_accountability_2',
                    'responsibility_accountability_3',
                ]
            ),

            'Humility & Service' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'humility_service_1',
                    'humility_service_2',
                    'humility_service_3',
                ]
            ),

            'Empathy & Compassion' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'empathy_compassion_1',
                    'empathy_compassion_2',
                ]
            ),

            'Courage & Drive' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'inspirational_leadership_1',
                    'inspirational_leadership_2',
                    'inspirational_leadership_3',
                ]
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | OVERALL VIRTUE SCORE
        |--------------------------------------------------------------------------
        */
        $validVirtueScores = collect($virtueScores)
            ->filter(function ($score) {
                return $score !== null;
            });

        $virtueOverall = $validVirtueScores->count()
            ? round($validVirtueScores->avg(), 2)
            : null;

        /*
        |--------------------------------------------------------------------------
        | MANAGER COMMENTS
        |--------------------------------------------------------------------------
        |
        | Only comments for manager-approved goals.
        |
        */
        $managerComments = collect();

        foreach ($reports as $report) {

            $managerReview = $report->reviews
                ->where('reviewer_type', 'manager')
                ->where('decision', 'approved')
                ->sortByDesc('id')
                ->first();

            if (
                $managerReview &&
                filled($managerReview->comments)
            ) {
                $managerComments->push([
                    'goal' => optional($report->goal)->goal ?? 'Goal',
                    'comment' => $managerReview->comments,
                    'decision' => $managerReview->decision,
                    'reviewed_at' => $managerReview->reviewed_at,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MANAGER OVERALL FEEDBACK
        |--------------------------------------------------------------------------
        */
        $managerOverallFeedback = null;

        if ($overallReview) {

            /*
            | Actual database column:
            | manager_overll_comments
            */
            if (
                isset($overallReview->manager_overll_comments) &&
                filled($overallReview->manager_overll_comments)
            ) {
                $managerOverallFeedback =
                    $overallReview->manager_overll_comments;
            }

            /*
            | Fallback fields
            */
            if (!$managerOverallFeedback) {

                foreach ([
                    'manager_feedback',
                    'overall_feedback',
                    'feedback',
                    'remarks',
                    'comments',
                    'comment',
                ] as $field) {

                    if (
                        isset($overallReview->{$field}) &&
                        filled($overallReview->{$field})
                    ) {
                        $managerOverallFeedback =
                            $overallReview->{$field};

                        break;
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HR OVERALL FEEDBACK
        |--------------------------------------------------------------------------
        */
        $hrOverallFeedback = null;

        if (
            $overallReview &&
            isset($overallReview->comments) &&
            filled($overallReview->comments)
        ) {
            $hrOverallFeedback = $overallReview->comments;
        }

        /*
        |--------------------------------------------------------------------------
        | MANAGER APPROVED INITIATIVES ONLY
        |--------------------------------------------------------------------------
        |
        | approved:
        |       Manager approved
        |
        | approved_with_amendment:
        |       Manager approved with changes/amendment
        |
        | Both are considered manager-approved.
        |
        */
        $initiatives = GoalInitiative::with('manager')
            ->where('user_id', $user->id)
            ->whereIn('manager_decision', [
                'approved',
                'approved_with_amendment',
            ])
            ->latest('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */
        $pdf = Pdf::loadView(
            'admin.new_goals.my-performance-pdf',
            compact(
                'user',
                'reports',
                'overallReview',
                'lineManagerFeedback',
                'virtueScores',
                'virtueOverall',
                'selfOverallRating',
                'managerOverallRating',
                'hrOverallRating',
                'managerComments',
                'managerOverallFeedback',
                'hrOverallFeedback',
                'initiatives'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | PAPER
        |--------------------------------------------------------------------------
        */
        $pdf->setPaper('A4', 'portrait');

        /*
        |--------------------------------------------------------------------------
        | FILE NAME
        |--------------------------------------------------------------------------
        */
        $employeeCode =
            $user->employee_code
            ?? $user->employee_id
            ?? $user->id;

        $filename =
            'Performance_Appraisal_' .
            preg_replace(
                '/[^A-Za-z0-9_-]/',
                '_',
                $employeeCode
            ) .
            '_FY2026.pdf';

        return $pdf->download($filename);
    }

    /**
     * Show logged-in employee's Line Manager Feedback
     * in a Spider / Radar chart.
     */
    public function lineManagerFeedbackChart()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | LINE MANAGER FEEDBACK
        |--------------------------------------------------------------------------
        |
        | Get latest active/approved feedback for logged-in employee.
        |
        */
        $lineManagerFeedback = LineManagerFeedback::where(
            'employee_id',
            $user->id
        )
            ->where('status', 1)
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | VIRTUE SCORES
        |--------------------------------------------------------------------------
        */
        $virtueScores = [
            'Honesty & Integrity' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'honesty_integrity_1',
                    'honesty_integrity_2',
                    'honesty_integrity_3',
                ]
            ),

            'Responsibility & Accountability' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'responsibility_accountability_1',
                    'responsibility_accountability_2',
                    'responsibility_accountability_3',
                ]
            ),

            'Humility & Service' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'humility_service_1',
                    'humility_service_2',
                    'humility_service_3',
                ]
            ),

            'Empathy & Compassion' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'empathy_compassion_1',
                    'empathy_compassion_2',
                ]
            ),

            'Courage & Drive' => $this->averageValues(
                $lineManagerFeedback,
                [
                    'inspirational_leadership_1',
                    'inspirational_leadership_2',
                    'inspirational_leadership_3',
                ]
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | OVERALL VIRTUE SCORE
        |--------------------------------------------------------------------------
        */
        $validVirtueScores = collect($virtueScores)
            ->filter(function ($score) {
                return $score !== null;
            });

        $virtueOverall = $validVirtueScores->count()
            ? round($validVirtueScores->avg(), 2)
            : null;

        /*
        |--------------------------------------------------------------------------
        | FEEDBACK SCORE ON 100 SCALE
        |--------------------------------------------------------------------------
        */
        $feedbackScore100 = $virtueOverall !== null
            ? round($virtueOverall, 2)
            : null;

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.new_goals.line-manager-feedback-chart',
            compact(
                'user',
                'lineManagerFeedback',
                'virtueScores',
                'virtueOverall',
                'feedbackScore100'
            )
        );
    }

    /**
     * Calculate average of available numeric values.
     */
    private function averageValues(
        $model,
        array $fields
    ): ?float {

        if (!$model) {
            return null;
        }

        $values = collect($fields)
            ->map(function ($field) use ($model) {

                $value = $model->{$field} ?? null;

                return is_numeric($value)
                    ? (float) $value
                    : null;
            })
            ->filter(function ($value) {
                return $value !== null;
            });

        return $values->count()
            ? round($values->avg(), 2)
            : null;
    }

    /**
 * User Performance Dashboard
 */
public function dashboard()
{
    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | ALL SELF REPORTS
    |--------------------------------------------------------------------------
    */

    $allReports = GoalSelfReport::with([
        'goal.s2rDriver',
        'reviews.reviewer',
    ])
        ->where('user_id', $user->id)
        ->orderByDesc('id')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | LATEST REPORT FOR EACH GOAL
    |--------------------------------------------------------------------------
    */

    $latestReports = $allReports
        ->groupBy('new_goal_id')
        ->map(function ($goalReports) {
            return $goalReports
                ->sortByDesc('id')
                ->first();
        })
        ->filter()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | MANAGER APPROVED GOALS
    |--------------------------------------------------------------------------
    */

    $approvedReports = $latestReports
        ->filter(function ($report) {

            if ($report->status !== 'manager_approved') {
                return false;
            }

            $managerReview = $report->reviews
                ->where('reviewer_type', 'manager')
                ->sortByDesc('id')
                ->first();

            if (
                $managerReview &&
                $managerReview->decision !== 'approved'
            ) {
                return false;
            }

            return true;
        })
        ->values();

    /*
    |--------------------------------------------------------------------------
    | GOAL STATS
    |--------------------------------------------------------------------------
    */

    $totalGoals = $latestReports->count();

    $approvedGoals = $approvedReports->count();

    $completedGoals = $latestReports
        ->where('achievement_status', 'completed')
        ->count();

    $inProgressGoals = $latestReports
        ->where('achievement_status', 'in_progress')
        ->count();

    $partiallyCompletedGoals = $latestReports
        ->where('achievement_status', 'partially_complete')
        ->count();

    $notStartedGoals = $latestReports
        ->where('achievement_status', 'not_started')
        ->count();

    /*
    |--------------------------------------------------------------------------
    | GOAL PROGRESS
    |--------------------------------------------------------------------------
    */

    $goalProgress = $totalGoals > 0
        ? round(($completedGoals / $totalGoals) * 100, 2)
        : 0;

    /*
    |--------------------------------------------------------------------------
    | SELF OVERALL SCORE
    |--------------------------------------------------------------------------
    */

    $selfRatings = $approvedReports
        ->pluck('rating')
        ->filter(function ($value) {
            return $value !== null && is_numeric($value);
        })
        ->map(function ($value) {
            return (float) $value;
        });

    $selfOverallRating = $selfRatings->count()
        ? round($selfRatings->avg(), 2)
        : null;

    /*
    |--------------------------------------------------------------------------
    | OVERALL REVIEW
    |--------------------------------------------------------------------------
    */

    $overallReview = GoalOverallReview::where(
        'user_id',
        $user->id
    )
        ->latest('id')
        ->first();

        /*
    |--------------------------------------------------------------------------
    | MANAGER SCORE
    |--------------------------------------------------------------------------
    */

    $managerOverallRating = $approvedReports
        ->filter(function ($report) {
            return $report->manager_rating !== null
                && is_numeric($report->manager_rating)
                && $report->weightage !== null;
        })
        ->sum(function ($report) {
            return (float) $report->manager_rating
                * ((float) $report->weightage / 100);
        });

    /*
    |--------------------------------------------------------------------------
    | MANAGER FALLBACK SCORE
    |--------------------------------------------------------------------------
    */

    if ($managerOverallRating === null) {

        $managerRatings = $approvedReports
            ->pluck('manager_rating')
            ->filter(function ($value) {

                return $value !== null
                    && is_numeric($value)
                    && (float) $value > 0;

            })
            ->map(function ($value) {

                return (float) $value;

            });

        $managerOverallRating = $managerRatings->count()
            ? round($managerRatings->avg(), 2)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | HR SCORE
    |--------------------------------------------------------------------------
    */

    $hrOverallRating = null;

    if (
        $overallReview &&
        $overallReview->hr_overall_rating !== null
    ) {

        $hrOverallRating =
            (float) $overallReview->hr_overall_rating;

    }

    /*
    |--------------------------------------------------------------------------
    | HR FALLBACK SCORE
    |--------------------------------------------------------------------------
    */

    if ($hrOverallRating === null) {

        $hrRatings = $approvedReports
            ->pluck('hr_rating')
            ->filter(function ($value) {

                return $value !== null
                    && is_numeric($value)
                    && (float) $value > 0;

            })
            ->map(function ($value) {

                return (float) $value;

            });

        $hrOverallRating = $hrRatings->count()
            ? round($hrRatings->avg(), 2)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | LINE MANAGER FEEDBACK
    |--------------------------------------------------------------------------
    */

    $lineManagerFeedback = LineManagerFeedback::where(
        'employee_id',
        $user->id
    )
        ->where('status', 1)
        ->latest('id')
        ->first();

    /*
    |--------------------------------------------------------------------------
    | VIRTUE SCORES
    |--------------------------------------------------------------------------
    |
    | These values are already treated as 0-100 in your dashboard data.
    |
    */

    $virtueScores = [

        'Honesty & Integrity' => $this->averageValues(
            $lineManagerFeedback,
            [
                'honesty_integrity_1',
                'honesty_integrity_2',
                'honesty_integrity_3',
            ]
        ),

        'Responsibility & Accountability' => $this->averageValues(
            $lineManagerFeedback,
            [
                'responsibility_accountability_1',
                'responsibility_accountability_2',
                'responsibility_accountability_3',
            ]
        ),

        'Humility & Service' => $this->averageValues(
            $lineManagerFeedback,
            [
                'humility_service_1',
                'humility_service_2',
                'humility_service_3',
            ]
        ),

        'Empathy & Compassion' => $this->averageValues(
            $lineManagerFeedback,
            [
                'empathy_compassion_1',
                'empathy_compassion_2',
            ]
        ),

        'Courage & Drive' => $this->averageValues(
            $lineManagerFeedback,
            [
                'inspirational_leadership_1',
                'inspirational_leadership_2',
                'inspirational_leadership_3',
            ]
        ),
    ];

    /*
    |--------------------------------------------------------------------------
    | FEEDBACK OVERALL
    |--------------------------------------------------------------------------
    */

    $validVirtueScores = collect($virtueScores)
        ->filter(function ($score) {
            return $score !== null
                && is_numeric($score);
        });

    $feedbackScore100 = $validVirtueScores->count()
        ? round($validVirtueScores->avg(), 2)
        : null;

    /*
    |--------------------------------------------------------------------------
    | CONVERT SCORES TO 100
    |--------------------------------------------------------------------------
    */

    $selfScore100 = $selfOverallRating !== null
        ? round($selfOverallRating * 20, 2)
        : null;

    $managerScore100 = $managerOverallRating !== null
        ? round($managerOverallRating * 20, 2)
        : null;

    $hrScore100 = $hrOverallRating !== null
        ? round($hrOverallRating, 2)
        : null;

    /*
    |--------------------------------------------------------------------------
    | FINAL SCORE
    |--------------------------------------------------------------------------
    |
    | HR       = 70%
    | Feedback = 30%
    |
    */

    $finalScore = null;

    if (
        $hrScore100 !== null &&
        $feedbackScore100 !== null
    ) {

        $finalScore = $hrScore100;
    }

    /*
    |--------------------------------------------------------------------------
    | RATING HELPER
    |--------------------------------------------------------------------------
    */

    $getRating = function ($score) {

        if ($score === null) {
            return 'Pending';
        }

        $score = (float) $score;

        if ($score >= 90) {
            return 'OS';
        }

        if ($score >= 80) {
            return 'EE';
        }

        if ($score >= 70) {
            return 'ME';
        }

        if ($score >= 60) {
            return 'NI';
        }

        return 'BE';
    };

    /*
    |--------------------------------------------------------------------------
    | RATINGS
    |--------------------------------------------------------------------------
    */

    $selfRating = $getRating($selfScore100);

    $managerRating = $getRating($managerScore100);

    $feedbackRating = $getRating($feedbackScore100);

    $hrRating = $getRating($hrScore100);

    $finalRating = $getRating($finalScore);

    /*
    |--------------------------------------------------------------------------
    | INITIATIVES
    |--------------------------------------------------------------------------
    */

    $initiatives = GoalInitiative::with('manager')
        ->where('user_id', $user->id)
        ->whereIn('manager_decision', [
            'approved',
            'approved_with_amendment',
        ])
        ->latest('id')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | REVIEW STATUS
    |--------------------------------------------------------------------------
    */

    $selfReportSubmitted =
        $latestReports->whereIn('status', [
            'submitted',
            'manager_approved',
            'manager_rejected',
            'hr_approved',
            'hr_rejected',
        ])->count() > 0;

    $managerReviewCompleted =
        $approvedGoals > 0;

    $hrReviewCompleted =
        $overallReview &&
        (
            $overallReview->hr_overall_rating !== null
            ||
            (
                isset($overallReview->decision)
                && $overallReview->decision === 'approved'
            )
        );

    $finalized =
        $overallReview &&
        isset($overallReview->decision)
        &&
        $overallReview->decision === 'approved';

    /*
    |--------------------------------------------------------------------------
    | RETURN DASHBOARD
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.new_goals.performance-dashboard',
        compact(
            'user',
            'latestReports',
            'approvedReports',
            'totalGoals',
            'approvedGoals',
            'completedGoals',
            'inProgressGoals',
            'partiallyCompletedGoals',
            'notStartedGoals',
            'goalProgress',
            'overallReview',
            'selfOverallRating',
            'managerOverallRating',
            'hrOverallRating',
            'selfScore100',
            'managerScore100',
            'feedbackScore100',
            'hrScore100',
            'finalScore',
            'selfRating',
            'managerRating',
            'feedbackRating',
            'hrRating',
            'finalRating',
            'lineManagerFeedback',
            'virtueScores',
            'initiatives',
            'selfReportSubmitted',
            'managerReviewCompleted',
            'hrReviewCompleted',
            'finalized'
        )
    );
}

public function downloadGoalReport()
{
    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | GET ALL GOALS OF EMPLOYEE
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | All goals will be shown.
    | Manager approval is NOT required.
    |
    */

    $goals = NewGoal::with([
        's2rDriver',
    ])
        ->where('user_id', $user->id)
        ->latest('id')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | GET ALL SELF REPORTS
    |--------------------------------------------------------------------------
    |
    | A goal can have multiple self reports.
    | We only use the latest self report for each goal.
    |
    */

    $allReports = GoalSelfReport::with([
        'reviews.reviewer',
    ])
        ->where('user_id', $user->id)
        ->orderByDesc('id')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | LATEST SELF REPORT PER GOAL
    |--------------------------------------------------------------------------
    */

    $latestReports = $allReports
        ->groupBy('new_goal_id')
        ->map(function ($goalReports) {

            return $goalReports
                ->sortByDesc('id')
                ->first();

        });

    /*
    |--------------------------------------------------------------------------
    | ATTACH LATEST SELF REPORT TO EACH GOAL
    |--------------------------------------------------------------------------
    |
    | Every goal will remain in the report even if:
    |
    | - No self report exists
    | - Self report is pending
    | - Self report is rejected
    | - Self report is manager approved
    |
    */

    $reports = $goals->map(function ($goal) use ($latestReports) {

        /*
        |--------------------------------------------------------------------------
        | Latest self report for this goal
        |--------------------------------------------------------------------------
        */

        $report = $latestReports->get($goal->id);

        /*
        |--------------------------------------------------------------------------
        | Manager Review
        |--------------------------------------------------------------------------
        |
        | If a self report exists, get latest manager review.
        |
        */

        $managerReview = null;

        if ($report) {

            $managerReview = $report->reviews
                ->where('reviewer_type', 'manager')
                ->sortByDesc('id')
                ->first();

        }

        /*
        |--------------------------------------------------------------------------
        | Manager Remarks
        |--------------------------------------------------------------------------
        */

        $managerRemarks = null;

        if ($managerReview) {

            $managerRemarks = $managerReview->comments;

        }

        /*
        |--------------------------------------------------------------------------
        | Attach data to goal
        |--------------------------------------------------------------------------
        */

        $goal->latest_self_report = $report;

        $goal->latest_manager_review = $managerReview;

        $goal->manager_remarks = $managerRemarks;

        return $goal;

    })
        ->values();

    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'admin.new_goals.goal-detail-pdf',
        compact(
            'user',
            'reports'
        )
    );

    /*
    |--------------------------------------------------------------------------
    | PAPER
    |--------------------------------------------------------------------------
    */

    $pdf->setPaper('A4', 'portrait');

    /*
    |--------------------------------------------------------------------------
    | FILE NAME
    |--------------------------------------------------------------------------
    */

    $employeeCode =
        $user->employee_code
        ?? $user->employee_id
        ?? $user->id;

    $filename =
        'Employee_Goals_Report_' .
        preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $employeeCode
        ) .
        '_FY2026.pdf';

    return $pdf->download($filename);
}

public function OvelalldownloadGoalReport()
{
     $groupedGoals = collect();
     // Current manager
    $currentUser = Auth::user();

    // Report generation date
    $reportDate = now()->format('d M Y, h:i A');
    // Get employees under the current manager
    $employees = User::where('manager_id', Auth::id())
        ->pluck('id');

    NewGoal::query()
        ->select([
            'id',
            'user_id',
            's2r_driver_enabler_alignment',
            'goal',
            'target',
        ])
        ->whereIn('user_id', $employees)
        ->with([
            's2rDriver:id,driver_name',
            'user:id,name',
            'latestSelfReport',
        ])
        ->orderBy('s2r_driver_enabler_alignment')
        ->orderBy('id')
        ->chunk(100, function ($goals) use (&$groupedGoals) {
            foreach ($goals as $goal) {
                $driverId = $goal->s2r_driver_enabler_alignment ?? 'no_driver';

                if (!$groupedGoals->has($driverId)) {
                    $groupedGoals->put($driverId, collect());
                }

                $groupedGoals->get($driverId)->push($goal);
            }
        });


    $pdf = Pdf::loadView(
        'admin.new_goals.goal-report-pdf',
        compact('groupedGoals', 'currentUser','reportDate')
    );

    $pdf->setPaper('A4', 'portrait');

    return $pdf->download('All_Employees_Goals_Report.pdf');
}
}