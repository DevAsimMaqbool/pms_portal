<?php

namespace App\Http\Controllers;

use App\Models\NewGoal;
use App\Models\S2RDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewGoalController extends Controller
{
    /**
     * Employee's goals
     */
    public function index()
    {
        $goals = NewGoal::with([
            's2rDriver',
            'latestSelfReport.managerReview.reviewer',
            'latestSelfReport.hrReview.reviewer',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view(
            'admin.new_goals.index',
            compact('goals')
        );
    }

    /**
     * Create goal form
     */
    public function create()
    {
        $drivers = S2RDriver::orderBy('id', 'asc')->get();

        return view(
            'admin.new_goals.create',
            compact('drivers')
        );
    }

    /**
     * Store goal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal' => 'required|string|max:5000',

            's2r_driver_enabler_alignment' =>
                'required|exists:s2_r_drivers,id',

            'objectives' =>
                'nullable|string|max:5000',

            'target' =>
                'required|string|max:5000',

            'deadline' =>
                'required|date',
        ]);

        DB::transaction(function () use ($validated) {

            $goal = NewGoal::create([
                'user_id' => Auth::id(),

                'goal' =>
                    $validated['goal'],

                's2r_driver_enabler_alignment' =>
                    $validated['s2r_driver_enabler_alignment'],

                'objectives' =>
                    $validated['objectives'] ?? null,

                'target' =>
                    $validated['target'],

                'deadline' =>
                    $validated['deadline'],

                'status' =>
                    'active',
            ]);

            $goal->histories()->create([
                'user_id' => Auth::id(),

                'action' =>
                    'Goal Created',

                'from_status' =>
                    null,

                'to_status' =>
                    'active',

                'metadata' => [
                    'goal_id' => $goal->id,
                ],
            ]);
        });

        return redirect()
            ->route('newgoals.index')
            ->with(
                'success',
                'Goal created successfully.'
            );
    }

    /**
     * Show goal
     */
    public function show(NewGoal $newgoal)
    {
        $this->authorizeGoal($newgoal);

        $newgoal->load([
            'user',
            's2rDriver',
            'selfReports.reviews.reviewer',
            'histories.user',
        ]);

        return view(
            'admin.new_goals.show',
            compact('newgoal')
        );
    }

    /**
     * Edit
     */
    public function edit(NewGoal $newgoal)
    {
        $this->authorizeGoal($newgoal);

        /*
         * Don't allow editing once submitted.
         */
        if (
            $newgoal->selfReports()
                ->whereIn('status', [
                    'submitted',
                    'manager_approved',
                    'manager_rejected',
                    'hr_approved',
                    'hr_rejected',
                ])
                ->exists()
        ) {
            return redirect()
                ->route('newgoals.index')
                ->with(
                    'error',
                    'This goal can no longer be edited because a self report has been submitted.'
                );
        }

        $drivers = S2RDriver::orderBy('driver_name')->get();

        return view(
            'admin.new_goals.edit',
            compact(
                'newgoal',
                'drivers'
            )
        );
    }

    /**
     * Update
     */
    public function update(
        Request $request,
        NewGoal $newgoal
    ) {
        $this->authorizeGoal($newgoal);

        if (
            $newgoal->selfReports()
                ->whereIn('status', [
                    'submitted',
                    'manager_approved',
                    'manager_rejected',
                    'hr_approved',
                    'hr_rejected',
                ])
                ->exists()
        ) {
            return redirect()
                ->route('newgoals.index')
                ->with(
                    'error',
                    'This goal can no longer be edited.'
                );
        }

        $validated = $request->validate([
            'goal' =>
                'required|string|max:5000',

            's2r_driver_enabler_alignment' =>
                'required|exists:s2_r_drivers,id',

            'objectives' =>
                'nullable|string|max:5000',

            'target' =>
                'required|string|max:5000',

            'deadline' =>
                'required|date',
        ]);

        DB::transaction(function () use ($newgoal, $validated) {

            $newgoal->update([
                'goal' =>
                    $validated['goal'],

                's2r_driver_enabler_alignment' =>
                    $validated['s2r_driver_enabler_alignment'],

                'objectives' =>
                    $validated['objectives'] ?? null,

                'target' =>
                    $validated['target'],

                'deadline' =>
                    $validated['deadline'],
            ]);

            $newgoal->histories()->create([
                'user_id' => Auth::id(),

                'action' =>
                    'Goal Updated',

                'from_status' =>
                    $newgoal->status,

                'to_status' =>
                    $newgoal->status,
            ]);
        });

        return redirect()
            ->route('newgoals.index')
            ->with(
                'success',
                'Goal updated successfully.'
            );
    }

    /**
     * Delete
     */
    public function destroy(NewGoal $newgoal)
    {
        $this->authorizeGoal($newgoal);

        if ($newgoal->selfReports()->exists()) {
            return redirect()
                ->route('newgoals.index')
                ->with(
                    'error',
                    'This goal cannot be deleted because a self report exists.'
                );
        }

        DB::transaction(function () use ($newgoal) {

            $newgoal->histories()->create([
                'user_id' => Auth::id(),

                'action' =>
                    'Goal Deleted',

                'from_status' =>
                    $newgoal->status,

                'to_status' =>
                    'deleted',
            ]);

            $newgoal->delete();
        });

        return redirect()
            ->route('newgoals.index')
            ->with(
                'success',
                'Goal deleted successfully.'
            );
    }

    /**
     * Authorization
     */
    private function authorizeGoal(NewGoal $newgoal)
    {
        abort_unless(
            $newgoal->user_id == Auth::id(),
            403
        );
    }
}