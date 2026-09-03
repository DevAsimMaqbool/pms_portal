<?php

namespace App\Http\Controllers;

use App\Models\GoalHistory;
use App\Models\GoalOverallReview;
use App\Models\GoalReportReview;
use App\Models\GoalSelfReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalManagerReviewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Employee List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | EMPLOYEES
    |--------------------------------------------------------------------------
    |
    | Keep your existing employee query here.
    | Example:
    |
    */

    $employees = User::where('manager_id', Auth::id())
        ->withCount([
            'goalSelfReports as total_goals' => function ($query) {
                $query->whereIn('status', [
                    'submitted',
                    'manager_approved',
                    'manager_rejected',
                ]);
            },

            'goalSelfReports as reviewed_goals' => function ($query) {
                $query->where('status', 'manager_approved');
            },

            'goalSelfReports as pending_goals' => function ($query) {
                $query->whereIn('status', [
                    'submitted',
                    'manager_rejected',
                ]);
            },
        ])
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | CALCULATE OVERALL RATINGS
    |--------------------------------------------------------------------------
    */

    foreach ($employees as $employee) {

        /*
        |--------------------------------------------------------------------------
        | SELF OVERALL RATING
        |--------------------------------------------------------------------------
        */

        $selfRatings = GoalSelfReport::where(
            'user_id',
            $employee->id
        )
        ->whereNotNull('rating')
        ->pluck('rating');

        $employee->self_overall_rating =
            $selfRatings->count() > 0
                ? round($selfRatings->avg(), 2)
                : null;

        /*
        |--------------------------------------------------------------------------
        | MANAGER / HR OVERALL RATING
        |--------------------------------------------------------------------------
        */

        $overallReview = GoalOverallReview::where(
            'user_id',
            $employee->id
        )
        ->latest('id')
        ->first();

        /*
        |--------------------------------------------------------------------------
        | MANAGER OVERALL
        |--------------------------------------------------------------------------
        */

        $employee->manager_overall_rating =
            $overallReview?->manager_overall_rating;

        /*
        |--------------------------------------------------------------------------
        | HR OVERALL
        |--------------------------------------------------------------------------
        */

        $employee->hr_overall_rating =
            $overallReview?->hr_overall_rating;
    }

    return view(
            'admin.goal-manager.index',
            compact('employees')
        );
} 

    /*
    |--------------------------------------------------------------------------
    | Show ALL Goals Of Employee
    |--------------------------------------------------------------------------
    */

    public function show(User $user)
    {
        $managerId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $user->manager_id == $managerId,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Load All Submitted Goals
        |--------------------------------------------------------------------------
        */

        $reports = GoalSelfReport::with([
            'user',
            'goal.s2rDriver',
            'reviews.reviewer',
        ])
            ->where('user_id', $user->id)
            ->whereIn('status', [
                'submitted',
                'manager_approved',
                'manager_rejected',
            ])
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Add Manager Review To Each Goal
        |--------------------------------------------------------------------------
        */

        $reports->transform(function ($report) use ($managerId) {

            $report->managerReview = $report->reviews
                ->where('reviewer_id', $managerId)
                ->where('reviewer_type', 'manager')
                ->sortByDesc('id')
                ->first();

            return $report;
        });

        /*
        |--------------------------------------------------------------------------
        | Manager Overall Review
        |--------------------------------------------------------------------------
        */

        $overallReview = GoalOverallReview::query()
            ->where('user_id', $user->id)
            ->where('manager_reviewer_id', $managerId)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Calculated Manager Overall Rating
        |--------------------------------------------------------------------------
        |
        | Weightage is stored in goal_self_reports.
        |
        | Formula:
        |
        | Sum(manager_rating * weightage) / Sum(weightage)
        |
        */

        $weightedTotal = 0;
        $totalWeight = 0;

        foreach ($reports as $report) {

            if (
                $report->manager_rating !== null &&
                $report->weightage !== null
            ) {

                $weightedTotal +=
                    ((float) $report->manager_rating *
                        (float) $report->weightage);

                $totalWeight +=
                    (float) $report->weightage;
            }
        }

        $calculatedOverallRating = $totalWeight > 0
            ? round($weightedTotal / $totalWeight, 2)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Weightage Summary
        |--------------------------------------------------------------------------
        */

        $totalWeightage = $reports
            ->whereNotNull('weightage')
            ->sum('weightage');

        $reviewedGoals = $reports
            ->whereNotNull('manager_rating')
            ->count();

        $pendingGoals = $reports->count() - $reviewedGoals;

        return view(
            'admin.goal-manager.show',
            compact(
                'user',
                'reports',
                'overallReview',
                'calculatedOverallRating',
                'totalWeightage',
                'reviewedGoals',
                'pendingGoals'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Review Individual Goal
    |--------------------------------------------------------------------------
    */

    public function review(
        Request $request,
        GoalSelfReport $goalSelfReport
    ) {
        $managerId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            optional($goalSelfReport->user)->manager_id == $managerId,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'weightage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'decision' => [
                'required',
                'in:approved,rejected',
            ],

            'manager_rating' => [
                'required',
                'integer',
                'min:0',
                'max:5',
            ],

            'comments' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $goalSelfReport,
            $managerId
        ) {

            /*
            |--------------------------------------------------------------------------
            | Save Weightage + Manager Rating
            |--------------------------------------------------------------------------
            */

            $goalSelfReport->update([

                'weightage' =>
                    $validated['weightage'],

                'manager_rating' =>
                    $validated['manager_rating'],

                'manager_reviewed_at' =>
                    now(),

                'status' =>
                    $validated['decision'] === 'approved'
                    ? 'manager_approved'
                    : 'manager_rejected',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Save / Update Manager Review
            |--------------------------------------------------------------------------
            */

            GoalReportReview::updateOrCreate(
                [
                    'goal_self_report_id' =>
                        $goalSelfReport->id,

                    'reviewer_id' =>
                        $managerId,

                    'reviewer_type' =>
                        'manager',
                ],
                [
                    'decision' =>
                        $validated['decision'],

                    'comments' =>
                        $validated['comments'] ?? null,

                    'reviewed_at' =>
                        now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Goal History
            |--------------------------------------------------------------------------
            */

            GoalHistory::create([

                'new_goal_id' =>
                    $goalSelfReport->new_goal_id,

                'user_id' =>
                    $managerId,

                'action' =>
                    $validated['decision'] === 'approved'
                    ? 'Manager Goal Approved'
                    : 'Manager Goal Rejected',

                'from_status' =>
                    'submitted',

                'to_status' =>
                    $validated['decision'] === 'approved'
                    ? 'manager_approved'
                    : 'manager_rejected',

                'comments' =>
                    $validated['comments'] ?? null,

                'metadata' => [

                    'report_id' =>
                        $goalSelfReport->id,

                    'employee_id' =>
                        $goalSelfReport->user_id,

                    'weightage' =>
                        $validated['weightage'],

                    'manager_rating' =>
                        $validated['manager_rating'],
                ],
            ]);
        });

        return redirect()
            ->route(
                'goal-manager.show',
                $goalSelfReport->user_id
            )
            ->with(
                'success',
                'Goal review has been saved successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager Overall Review
    |--------------------------------------------------------------------------
    */

    public function overallReview(
    Request $request,
    User $user
) {
    $managerId = Auth::id();

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    abort_unless(
        $user->manager_id == $managerId,
        403
    );

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'manager_overll_comments' => [
            'nullable',
            'string',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Check All Goals Are Reviewed
    |--------------------------------------------------------------------------
    */

    $pendingGoals = GoalSelfReport::query()
        ->where('user_id', $user->id)
        ->whereNotIn('status', [
            'manager_approved',
            'manager_rejected',
        ])
        ->exists();

    if ($pendingGoals) {

        return back()
            ->withErrors([
                'manager_overll_comments' =>
                    'Please review all employee goals before submitting the overall assessment.',
            ])
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | Save Manager Overall Comments
    |--------------------------------------------------------------------------
    |
    | manager_overall_rating is already stored/calculated elsewhere.
    | We do NOT modify it here.
    |
    */

    GoalOverallReview::updateOrCreate(
        [
            'user_id' => $user->id,
            //'manager_reviewer_id' => $managerId,
        ],
        [
            'manager_reviewer_id' => $managerId,
            'manager_overll_comments' =>
                $validated['manager_overll_comments'] ?? null,

            'reviewed_at' => now(),
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'goal-manager.show',
            $user
        )
        ->with(
            'success',
            'Overall manager remarks have been saved successfully.'
        );
}

public function lineManagerForm()
    {
        $authUser = Auth::user();

        // Upward: get manager if exists
        $manager = $authUser->manager ? collect([$authUser->manager]) : collect();

        // Downward: get subordinates if any
        $subordinates = $authUser->subordinates ?? collect();

        // Combine both into a single collection
        $facultyMembers = $manager->merge($subordinates);
        return view('admin.form.goal_feedback.line_manager_feedback_in_goal', compact('facultyMembers'));
    }
}