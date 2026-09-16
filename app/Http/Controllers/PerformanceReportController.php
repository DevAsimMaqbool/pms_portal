<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use App\Models\GoalOverallReview;
use App\Models\LineManagerFeedback;
use App\Models\GoalInitiative;
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

        if (
            $overallReview &&
            $overallReview->manager_overall_rating !== null
        ) {
            $managerOverallRating = (float)
                $overallReview->manager_overall_rating;
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

        $selfOverallRating = $selfRatings->count()
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
}