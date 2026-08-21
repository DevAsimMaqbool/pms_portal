<?php

namespace App\Http\Controllers;

use App\Models\NewGoal;
use App\Models\GoalSelfReport;
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

    public function index()
    {
        $reports = GoalSelfReport::with([
            'goal.s2rDriver',
            'managerReview.reviewer',
            'hrReview.reviewer',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view(
            'admin.goal-self-reports.index',
            compact('reports')
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