<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use App\Models\GoalReportReview;
use App\Models\GoalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalManagerReviewController extends Controller
{
    /**
     * Manager Reports
     *
     * Shows ALL reports belonging to the logged-in manager:
     * - Pending
     * - Approved
     * - Rejected
     *
     * Do NOT filter by status = submitted here because
     * approved/rejected reports must remain visible to manager.
     */
    public function index()
    {
        $managerId = Auth::id();

        $reports = GoalSelfReport::with([
            'user',
            'goal',
            'reviews.reviewer',
        ])
            ->whereHas('user', function ($query) use ($managerId) {
                $query->where('manager_id', $managerId);
            })
            ->latest('submitted_at')
            ->paginate(20);

        return view(
            'admin.goal-manager.index',
            compact('reports')
        );
    }

    /**
     * Show Manager Review Page
     */
    public function show(GoalSelfReport $goalSelfReport)
    {
        $managerId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            optional($goalSelfReport->user)->manager_id == $managerId,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Load Required Relationships
        |--------------------------------------------------------------------------
        */

        $goalSelfReport->load([
            'user',
            'goal.s2rDriver',
            'reviews' => function ($query) {
                $query->where('reviewer_type', 'manager')
                    ->latest('id');
            },
            'reviews.reviewer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Existing Manager Review
        |--------------------------------------------------------------------------
        */

        $managerReview = $goalSelfReport->reviews
            ->where('reviewer_id', $managerId)
            ->where('reviewer_type', 'manager')
            ->first();

        return view(
            'admin.goal-manager.review',
            compact(
                'goalSelfReport',
                'managerReview'
            )
        );
    }
    public function showBK(GoalSelfReport $goalSelfReport)
    {
        $managerId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        | Make sure this employee actually belongs to logged-in manager.
        */
        abort_unless(
            optional($goalSelfReport->user)->manager_id == $managerId,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Load Required Relationships
        |--------------------------------------------------------------------------
        */
        $goalSelfReport->load([
            'user',
            'goal',
            'reviews.reviewer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find Existing Manager Review
        |--------------------------------------------------------------------------
        |
        | We get the latest review created by the logged-in manager.
        |
        */
        $managerReview = $goalSelfReport->reviews
            ->where('reviewer_id', $managerId)
            ->where('reviewer_type', 'manager')
            ->sortByDesc('id')
            ->first();

        return view(
            'admin.goal-manager.review',
            compact(
                'goalSelfReport',
                'managerReview'
            )
        );
    }

    /**
     * Save / Update Manager Review
     */
    public function review(Request $request, GoalSelfReport $goalSelfReport)
    {
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
                'required'
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

        DB::transaction(function () use ($validated, $goalSelfReport, $managerId) {
            /*
            |--------------------------------------------------------------------------
            | Manager Review
            |--------------------------------------------------------------------------
            */

            GoalReportReview::updateOrCreate(
                [
                    'goal_self_report_id' => $goalSelfReport->id,
                    'reviewer_id' => $managerId,
                    'reviewer_type' => 'manager',
                ],
                [
                    'decision' => $validated['decision'],
                    'comments' => $validated['comments'] ?? null,
                    'reviewed_at' => now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Manager Rating
            |--------------------------------------------------------------------------
            */

            $goalSelfReport->update([
                'manager_rating' => $validated['manager_rating'],
                'weightage' => $validated['weightage'],

                'manager_reviewed_at' => now(),

                'status' => $validated['decision'] === 'approved'
                    ? 'manager_approved'
                    : 'manager_rejected',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Goal History
            |--------------------------------------------------------------------------
            */

            GoalHistory::create([
                'new_goal_id' => $goalSelfReport->new_goal_id,
                'user_id' => $managerId,
                'action' => $validated['decision'] === 'approved'
                    ? 'Manager Goal Approved'
                    : 'Manager Goal Rejected',
                'from_status' => 'submitted',
                'to_status' => $validated['decision'] === 'approved'
                    ? 'manager_approved'
                    : 'manager_rejected',
                'comments' => $validated['comments'] ?? null,
                'metadata' => [
                    'report_id' => $goalSelfReport->id,
                    'manager_rating' => $validated['manager_rating'],
                ],
            ]);
        });

        return redirect()
            ->route('goal-manager.index')
            ->with(
                'success',
                'Goal assessment has been saved successfully.'
            );
    }
    public function reviewBK(
        Request $request,
        GoalSelfReport $goalSelfReport
    ) {
        $managerId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Security Check
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
            'decision' => [
                'required',
                'in:approved,rejected',
            ],

            'manager_rating' => [
                'required',
                'integer',
                'between:0,5',
            ],

            'comments' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Manager Rating
        |--------------------------------------------------------------------------
        */
        $goalSelfReport->manager_rating =
            $validated['manager_rating'];

        /*
        |--------------------------------------------------------------------------
        | Save Report Status
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | We are keeping the report visible to the manager.
        | The index() method does NOT filter by status.
        |
        */
        if ($validated['decision'] === 'approved') {
            $goalSelfReport->status = 'manager_approved';
        } elseif ($validated['decision'] === 'rejected') {
            $goalSelfReport->status = 'manager_rejected';
        }

        $goalSelfReport->save();

        /*
        |--------------------------------------------------------------------------
        | Create / Update Manager Review
        |--------------------------------------------------------------------------
        |
        | If a review already exists for this manager + report,
        | update it instead of creating duplicate reviews.
        |
        */

        $managerReview = $goalSelfReport->reviews()
            ->where('reviewer_id', $managerId)
            ->latest('id')
            ->first();

        if ($managerReview) {

            $managerReview->decision =
                $validated['decision'];

            $managerReview->comments =
                $validated['comments'] ?? null;

            $managerReview->save();

        } else {

            $goalSelfReport->reviews()->create([
                'reviewer_id' => $managerId,
                'decision' => $validated['decision'],
                'comments' => $validated['comments'] ?? null,
            ]);
        }

        return redirect()
            ->route('goal-manager.index')
            ->with(
                'success',
                'Manager review submitted successfully.'
            );
    }
}