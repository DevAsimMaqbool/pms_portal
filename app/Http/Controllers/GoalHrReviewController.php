<?php

namespace App\Http\Controllers;

use App\Models\GoalSelfReport;
use App\Models\GoalOverallReview;
use App\Models\GoalHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalHrReviewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HR Goal List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
{
    // Get available departments
    $departments = User::whereNotNull('hr_department_name')
        ->where('hr_department_name', '!=', '')
        ->distinct()
        ->orderBy('hr_department_name')
        ->pluck('hr_department_name');

    $employees = User::whereHas('goalSelfReports', function ($query) {
            $query->where('status', 'manager_approved');
        })
        ->when($request->filled('department'), function ($query) use ($request) {

            $query->where(
                'hr_department_name',
                $request->department
            );

        })
        ->with([
            'goalSelfReports' => function ($query) {
                $query->where('status', 'manager_approved')
                    ->with([
                        'goal.s2rDriver',
                        'reviews' => function ($query) {
                            $query->where(
                                'reviewer_type',
                                'manager'
                            )->latest('id');
                        },
                        'reviews.reviewer',
                    ]);
            },

            'goalOverallReviews' => function ($query) {
                $query->latest('id');
            },
        ])
        ->paginate(15)
        ->withQueryString();

    return view(
        'admin.goal-hr.index',
        compact(
            'employees',
            'departments'
        )
    );
}

    /*
    |--------------------------------------------------------------------------
    | HR Overall Review
    |--------------------------------------------------------------------------
    */

    public function show(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Get All Manager-Reviewed Goals
        |--------------------------------------------------------------------------
        */

        $reports = GoalSelfReport::where(
            'user_id',
            $user->id
        )
            ->where('status', 'manager_approved')
            ->with([
                'goal.s2rDriver',
                'reviews' => function ($query) {
                    $query->where(
                        'reviewer_type',
                        'manager'
                    )->latest('id');
                },
                'reviews.reviewer',
            ])
            ->latest('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Existing Overall HR Review
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
        | Manager Overall Rating
        |--------------------------------------------------------------------------
        |
        | For now we calculate the manager's overall rating
        | from the ratings assigned against individual goals.
        |
        */

        $managerRatings = $reports
            ->pluck('manager_rating')
            ->filter(function ($rating) {
                return $rating !== null;
            });

        $managerOverallRating = $managerRatings->count()
            ? round($managerRatings->avg(), 2)
            : null;

        return view(
            'admin.goal-hr.review',
            compact(
                'user',
                'reports',
                'overallReview',
                'managerOverallRating'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Save HR Overall Moderation
    |--------------------------------------------------------------------------
    */

    public function review(Request $request, User $user)
    {
        $validated = $request->validate([
            'hr_overall_rating' => [
                'required',
                'integer',
                'min:0',
                'max:5',
            ],

            'decision' => [
                'required',
                'in:approved,rejected',
            ],

            'comments' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get Manager Overall Rating
        |--------------------------------------------------------------------------
        */

        $managerRatings = GoalSelfReport::where(
            'user_id',
            $user->id
        )
            ->where('status', 'manager_approved')
            ->whereNotNull('manager_rating')
            ->pluck('manager_rating');

        $managerOverallRating = $managerRatings->count()
            ? round($managerRatings->avg(), 2)
            : null;
        /*
        |--------------------------------------------------------------------------
        | Save Overall HR Review
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated, $user, $managerOverallRating) {

            GoalOverallReview::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'reviewer_id' => Auth::id(),
                ],
                [
                    'manager_overall_rating' => $managerOverallRating,

                    'hr_overall_rating' =>
                        $validated['hr_overall_rating'],

                    'decision' =>
                        $validated['decision'],

                    'comments' =>
                        $validated['comments'] ?? null,

                    'reviewed_at' => now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | History
            |--------------------------------------------------------------------------
            */

            GoalHistory::create([
                'new_goal_id' => null,
                'user_id' => Auth::id(),
                'action' =>
                    $validated['decision'] === 'approved'
                    ? 'HR Overall Performance Approved'
                    : 'HR Overall Performance Rejected',

                'from_status' => 'manager_approved',

                'to_status' =>
                    $validated['decision'] === 'approved'
                    ? 'hr_approved'
                    : 'hr_rejected',

                'comments' =>
                    $validated['comments'] ?? null,

                'metadata' => [
                    'employee_id' => $user->id,
                    'manager_overall_rating' =>
                        $managerOverallRating,
                    'hr_overall_rating' =>
                        $validated['hr_overall_rating'],
                ],
            ]);
        });

        return redirect()
            ->route(
                'goal-hr.show',
                $user
            )
            ->with(
                'success',
                'Overall performance moderation has been saved successfully.'
            );
    }
}