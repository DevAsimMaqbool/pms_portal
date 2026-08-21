<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function review(
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