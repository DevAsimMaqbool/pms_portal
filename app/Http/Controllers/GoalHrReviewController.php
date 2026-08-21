<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use App\Models\GoalReportReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalHrReviewController extends Controller
{
    /**
     * HR reports listing
     *
     * Show all reports which have reached HR.
     * After HR approves/rejects, they should NOT disappear.
     */
    public function index()
    {
        $reports = GoalSelfReport::with([
            'user',
            'goal',
            'managerReview.reviewer',
            'hrReview.reviewer',
        ])
            ->whereIn('status', [
                'manager_approved',
                'hr_approved',
                'hr_rejected',
            ])
            ->latest('updated_at')
            ->paginate(20);

        return view(
            'admin.goal-hr.index',
            compact('reports')
        );
    }

    /**
     * Show HR review page
     */
    public function show(GoalSelfReport $goalSelfReport)
    {
        /*
        |--------------------------------------------------------------------------
        | Allow HR to view:
        | manager approved
        | HR approved
        | HR rejected
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array($goalSelfReport->status, [
                'manager_approved',
                'hr_approved',
                'hr_rejected',
            ]),
            403
        );

        $goalSelfReport->load([
            'user',
            'goal',
            'reviews.reviewer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get latest HR review
        |--------------------------------------------------------------------------
        */

        $hrReview = $goalSelfReport->reviews
            ->where('reviewer_type', 'hr')
            ->sortByDesc('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Get latest Manager review
        |--------------------------------------------------------------------------
        */

        $managerReview = $goalSelfReport->reviews
            ->where('reviewer_type', 'manager')
            ->sortByDesc('id')
            ->first();

        return view(
            'admin.goal-hr.show',
            compact(
                'goalSelfReport',
                'hrReview',
                'managerReview'
            )
        );
    }

    /**
     * Save HR review
     */
    public function review(
        Request $request,
        GoalSelfReport $goalSelfReport
    ) {
        /*
        |--------------------------------------------------------------------------
        | HR can review manager approved reports
        | OR update an already submitted HR review.
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array($goalSelfReport->status, [
                'manager_approved',
                'hr_approved',
                'hr_rejected',
            ]),
            403
        );

        $validated = $request->validate([
            'decision' => [
                'required',
                'in:approved,rejected',
            ],

            'hr_rating' => [
                'required',
                'integer',
                'min:0',
                'max:5',
            ],

            'comments' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        DB::transaction(function () use ($validated, $goalSelfReport) {

            /*
            |--------------------------------------------------------------------------
            | Determine new status
            |--------------------------------------------------------------------------
            */

            $newStatus = $validated['decision'] === 'approved'
                ? 'hr_approved'
                : 'hr_rejected';

            $oldStatus = $goalSelfReport->status;

            /*
            |--------------------------------------------------------------------------
            | Create HR review history
            |
            | We create a new review record instead of deleting old history.
            | Therefore previous HR decisions remain available in history.
            |--------------------------------------------------------------------------
            */

            GoalReportReview::create([
                'goal_self_report_id' => $goalSelfReport->id,

                'reviewer_id' => Auth::id(),

                'reviewer_type' => 'hr',

                'decision' => $validated['decision'],

                'comments' => $validated['comments'] ?? null,

                'reviewed_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update report
            |--------------------------------------------------------------------------
            */

            $goalSelfReport->update([
                'status' => $newStatus,

                'hr_rating' => $validated['hr_rating'],

                'hr_reviewed_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | If HR approves, mark goal completed
            |--------------------------------------------------------------------------
            */

            if ($newStatus === 'hr_approved') {

                $goalSelfReport->goal->update([
                    'status' => 'completed',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Goal history
            |--------------------------------------------------------------------------
            */

            $goalSelfReport->goal->histories()->create([

                'user_id' => Auth::id(),

                'action' =>
                    $validated['decision'] === 'approved'
                    ? 'HR Final Decision Approved'
                    : 'HR Final Decision Rejected',

                'from_status' => $oldStatus,

                'to_status' => $newStatus,

                'comments' =>
                    $validated['comments'] ?? null,

                'metadata' => [
                    'report_id' => $goalSelfReport->id,
                ],
            ]);
        });

        return redirect()
            ->route('goal-hr.index')
            ->with(
                'success',
                'HR final decision submitted successfully.'
            );
    }
}