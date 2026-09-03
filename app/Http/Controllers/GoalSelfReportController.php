<?php

namespace App\Http\Controllers;

use App\Models\NewGoal;
use App\Models\GoalSelfReport;
use App\Models\GoalOverallReview;
use App\Models\LineManagerFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalSelfReportController extends Controller
{
private array $ratings = [
'not_started' => 0,
'in_progress' => 1,
'partially_complete' => 3,
'completed' => 5,
];

public function index(Request $request)
{
    $allowedStatuses = [
        'submitted',
        'manager_approved',
        'manager_rejected',
        'hr_approved',
        'hr_rejected',
    ];

    $query = GoalSelfReport::with([
        'goal.s2rDriver',
        'user',
    ])
    ->where('user_id', Auth::id())
    ->latest();

    if (
        $request->filled('status') &&
        in_array($request->status, $allowedStatuses)
    ) {
        $query->where('status', $request->status);
    }

    $reports = $query
        ->paginate(10)
        ->withQueryString();

    $overallReview = GoalOverallReview::where('user_id', Auth::id())
        ->latest('id')
        ->first();

    /*
    |--------------------------------------------------------------------------
    | LINE MANAGER FEEDBACK
    |--------------------------------------------------------------------------
    */

    $lineManagerFeedback = LineManagerFeedback::where(
        'employee_id',
        Auth::id()
    )
    ->where('status', 1)
    ->latest('id')
    ->first();

    $managerFeedbackOverall = null;

    if ($lineManagerFeedback) {

        $feedbackRatings = [
            $lineManagerFeedback->responsibility_accountability_1,
            $lineManagerFeedback->responsibility_accountability_2,
            $lineManagerFeedback->responsibility_accountability_3,

            $lineManagerFeedback->empathy_compassion_1,
            $lineManagerFeedback->empathy_compassion_2,

            $lineManagerFeedback->humility_service_1,
            $lineManagerFeedback->humility_service_2,
            $lineManagerFeedback->humility_service_3,

            $lineManagerFeedback->honesty_integrity_1,
            $lineManagerFeedback->honesty_integrity_2,
            $lineManagerFeedback->honesty_integrity_3,

            $lineManagerFeedback->inspirational_leadership_1,
            $lineManagerFeedback->inspirational_leadership_2,
            $lineManagerFeedback->inspirational_leadership_3,
        ];

        /*
         * Calculate average of the available ratings.
         */
        $validRatings = collect($feedbackRatings)
            ->filter(fn ($rating) => $rating !== null);

        if ($validRatings->count() > 0) {

            $managerFeedbackOverall = round(
                $validRatings->avg(),
                2
            );

        }
    }
    /*
|--------------------------------------------------------------------------
| SELF OVERALL RATING
|--------------------------------------------------------------------------
*/

$selfRatings = GoalSelfReport::where('user_id', Auth::id())
    ->whereNotNull('rating')
    ->pluck('rating');

$selfOverallRating = null;

if ($selfRatings->count() > 0) {
    $selfOverallRating = round(
        $selfRatings->avg(),
        2
    );
}

    return view(
        'admin.goal-self-reports.index',
        compact(
            'reports',
            'overallReview',
            'managerFeedbackOverall',
            'selfOverallRating'
        )
    );
}

public function create()
{
$goals = NewGoal::where('user_id', Auth::id())
->where('status', 'active')
->whereDoesntHave('selfReports', function ($query) {
$query->whereIn('status', [
'submitted',
'manager_approved',
'hr_approved',
]);
})
->orderBy('deadline')
->get();

return view(
'admin.goal-self-reports.create',
compact('goals')
);
}

public function store(Request $request)
{
$validated = $request->validate([
'new_goal_id' => [
'required',
'exists:new_goals,id',
],

'progress_against_goal' => [
'required',
'string',
'max:10000',
],

'achievement_status' => [
'required',
'in:not_started,in_progress,partially_complete,completed',
],
]);

/*
|--------------------------------------------------------------------------
| Verify that the selected goal belongs to logged-in user
|--------------------------------------------------------------------------
*/

$goal = NewGoal::where('id', $validated['new_goal_id'])
->where('user_id', Auth::id())
->firstOrFail();

/*
|--------------------------------------------------------------------------
| Prevent duplicate active/submitted reports
|--------------------------------------------------------------------------
*/

if (
$goal->selfReports()
->whereIn('status', [
'submitted',
'manager_approved',
'hr_approved',
])
->exists()
) {
return back()
->withInput()
->with(
'error',
'A report has already been submitted for this goal.'
);
}

/*
|--------------------------------------------------------------------------
| Calculate Rating Automatically
|--------------------------------------------------------------------------
*/

$rating = $this->ratings[
$validated['achievement_status']
];

DB::transaction(function () use ($validated, $goal, $rating) {

$report = GoalSelfReport::create([
'new_goal_id' => $goal->id,

'user_id' => Auth::id(),

'progress_against_goal' =>
$validated['progress_against_goal'],

'achievement_status' =>
$validated['achievement_status'],

'rating' => $rating,

'status' => 'submitted',

'submitted_at' => now(),
]);

/*
|--------------------------------------------------------------------------
| Goal History
|--------------------------------------------------------------------------
*/

$goal->histories()->create([
'user_id' => Auth::id(),

'action' => 'Self Report Submitted',

'from_status' => $goal->status,

'to_status' => 'submitted',

'metadata' => [
'report_id' => $report->id,

'achievement_status' =>
$validated['achievement_status'],

'rating' => $rating,
],
]);
});

return redirect()
->route('goal-self-reports.index')
->with(
'success',
'Self report submitted successfully and sent to your Line Manager.'
);
}

public function edit(GoalSelfReport $goalSelfReport)
{
 abort_unless(
        $goalSelfReport->user_id == Auth::id(),
        403
    );

    if (in_array($goalSelfReport->status, [
        'manager_approved',
        'hr_approved',
        'hr_rejected',
    ])) {
        return redirect()
            ->route('goal-self-reports.index')
            ->with('error', 'This goal report can no longer be edited.');
    }

    $goalSelfReport->load([
        'goal.s2rDriver',
        'reviews' => function ($query) {
            $query->where('reviewer_type', 'manager')
                ->latest('id');
        }
    ]);

return view(
'admin.goal-self-reports.edit',
compact('goalSelfReport')
);
}

public function update(Request $request, GoalSelfReport $goalSelfReport)
{
    /*
    |--------------------------------------------------------------------------
    | SECURITY
    |--------------------------------------------------------------------------
    | Only the employee who owns this report can update it.
    |--------------------------------------------------------------------------
    */

    abort_unless(
        $goalSelfReport->user_id == Auth::id(),
        403
    );

    /*
    |--------------------------------------------------------------------------
    | PREVENT EDIT AFTER APPROVAL
    |--------------------------------------------------------------------------
    */

    if (in_array($goalSelfReport->status, [
        'manager_approved',
        'hr_approved',
        'hr_rejected',
    ])) {

        return redirect()
            ->route('goal-self-reports.index')
            ->with(
                'error',
                'This self report can no longer be edited.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([

        'progress_against_goal' => [
            'required',
            'string',
            'max:10000',
        ],

        'achievement_status' => [
            'required',
            'in:not_started,in_progress,partially_complete,completed',
        ],

    ]);

    /*
    |--------------------------------------------------------------------------
    | CALCULATE RATING AUTOMATICALLY
    |--------------------------------------------------------------------------
    */

    $rating = $this->ratings[
        $validated['achievement_status']
    ];

    /*
    |--------------------------------------------------------------------------
    | UPDATE REPORT + HISTORY
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use (
        $validated,
        $goalSelfReport,
        $rating
    ) {

        /*
        |--------------------------------------------------------------------------
        | OLD VALUES FOR HISTORY
        |--------------------------------------------------------------------------
        */

        $oldStatus = $goalSelfReport->status;

        $oldAchievementStatus =
            $goalSelfReport->achievement_status;

        $oldRating =
            $goalSelfReport->rating;

        /*
        |--------------------------------------------------------------------------
        | UPDATE SELF REPORT
        |--------------------------------------------------------------------------
        */

        $goalSelfReport->update([

            'progress_against_goal' =>
                $validated['progress_against_goal'],

            'achievement_status' =>
                $validated['achievement_status'],

            'rating' =>
                $rating,

            /*
            |--------------------------------------------------------------------------
            | If manager rejected the report, resubmit it
            |--------------------------------------------------------------------------
            */

            'status' => 'submitted',

            'submitted_at' => now(),

            /*
            |--------------------------------------------------------------------------
            | Clear manager review timestamp because it is
            | being sent back for manager review.
            |--------------------------------------------------------------------------
            */

            'manager_reviewed_at' => null,

        ]);

        /*
        |--------------------------------------------------------------------------
        | GOAL HISTORY
        |--------------------------------------------------------------------------
        */

        $goalSelfReport->goal->histories()->create([

            'user_id' => Auth::id(),

            'action' => 'Self Report Updated',

            'from_status' => $oldStatus,

            'to_status' => 'submitted',

            'metadata' => [

                'report_id' =>
                    $goalSelfReport->id,

                'old_achievement_status' =>
                    $oldAchievementStatus,

                'new_achievement_status' =>
                    $validated['achievement_status'],

                'old_rating' =>
                    $oldRating,

                'new_rating' =>
                    $rating,

            ],

        ]);

    });

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route('goal-self-reports.index')
        ->with(
            'success',
            'Self report updated successfully and sent back to your Line Manager.'
        );
}

public function show(GoalSelfReport $goalSelfReport)
{
$this->authorizeReport($goalSelfReport);

$goalSelfReport->load([
'goal',
'reviews.reviewer',
]);

return view(
'admin.goal-self-reports.show',
compact('goalSelfReport')
);
}

private function authorizeReport(GoalSelfReport $report)
{
abort_unless(
$report->user_id == Auth::id(),
403
);
}
}