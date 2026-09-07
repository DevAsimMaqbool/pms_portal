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
        $request->validate([
            'goal' => 'required|string|max:5000',

            's2r_driver_enabler_alignment' =>
                'required',

            'objectives' =>
                'nullable|string|max:5000',

            'target' =>
                'required|string|max:5000',

            'deadline' =>
                'required|date',

            // Evidence
            'evidence_type' =>
                'nullable|in:video,attachment',

            'evidence_video_url' => [
                'nullable',
                'required_if:evidence_type,video',
                'url',
                'max:2000',
            ],

            'evidence_attachment' => [
                'nullable',
                'required_if:evidence_type,attachment',
                'file',
                'mimes:doc,docx,pdf,png,jpg,jpeg',
                'max:10240', // 10 MB
            ],
        ]);

        $evidenceAttachment = null;

        /*
        |--------------------------------------------------------------------------
        | Upload Attachment
        |--------------------------------------------------------------------------
        */

        if (
            $request->evidence_type === 'attachment' &&
            $request->hasFile('evidence_attachment')
        ) {
            $evidenceAttachment = $request
                ->file('evidence_attachment')
                ->store('goal-evidence', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Goal
        |--------------------------------------------------------------------------
        */

        $goal = NewGoal::create([
            'user_id' => auth()->id(),

            'goal' =>
                $request->goal,

            's2r_driver_enabler_alignment' =>
                $request->s2r_driver_enabler_alignment,

            'objectives' =>
                $request->objectives,

            'target' =>
                $request->target,

            'deadline' =>
                $request->deadline,

            /*
            |--------------------------------------------------------------------------
            | Evidence
            |--------------------------------------------------------------------------
            */

            'evidence_type' =>
                $request->evidence_type,

            'evidence_video_url' =>
                $request->evidence_type === 'video'
                    ? $request->evidence_video_url
                    : null,

            'evidence_attachment' =>
                $request->evidence_type === 'attachment'
                    ? $evidenceAttachment
                    : null,
        ]);

        return redirect()
            ->route('newgoals.index')
            ->with('success', 'Goal created successfully.');
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

        /*
        |--------------------------------------------------------------------------
        | Evidence
        |--------------------------------------------------------------------------
        */

        'evidence_type' =>
            'nullable|in:video,attachment',

        'evidence_video_url' => [
            'nullable',
            'required_if:evidence_type,video',
            'url',
            'max:2000',
        ],

        'evidence_attachment' => [
            'nullable',
            'file',
            'mimes:doc,docx,pdf,png,jpg,jpeg',
            'max:10240',
        ],
    ]);

    DB::transaction(function () use ($newgoal, $validated, $request) {

        /*
        |--------------------------------------------------------------------------
        | Existing Evidence
        |--------------------------------------------------------------------------
        */

        $oldAttachment = $newgoal->evidence_attachment;

        $evidenceType = $validated['evidence_type'] ?? null;

        $evidenceVideoUrl = null;

        $evidenceAttachment = $oldAttachment;

        /*
        |--------------------------------------------------------------------------
        | No Evidence
        |--------------------------------------------------------------------------
        */

        if (empty($evidenceType)) {

            if ($oldAttachment) {
                Storage::disk('public')->delete($oldAttachment);
            }

            $evidenceAttachment = null;
            $evidenceVideoUrl = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Video Evidence
        |--------------------------------------------------------------------------
        */

        elseif ($evidenceType === 'video') {

            /*
            | Delete previous attachment if goal
            | was previously using attachment evidence.
            */

            if ($oldAttachment) {
                Storage::disk('public')->delete($oldAttachment);
            }

            $evidenceAttachment = null;

            $evidenceVideoUrl =
                $validated['evidence_video_url'];
        }

        /*
        |--------------------------------------------------------------------------
        | Attachment Evidence
        |--------------------------------------------------------------------------
        */

        elseif ($evidenceType === 'attachment') {

            /*
            | Video URL should not remain when
            | evidence type is attachment.
            */

            $evidenceVideoUrl = null;

            /*
            | Upload new attachment only if user
            | selected a new file.
            */

            if ($request->hasFile('evidence_attachment')) {

                /*
                | Delete old attachment
                */

                if ($oldAttachment) {
                    Storage::disk('public')->delete($oldAttachment);
                }

                /*
                | Store new attachment
                */

                $evidenceAttachment = $request
                    ->file('evidence_attachment')
                    ->store('goal-evidence', 'public');
            }

            /*
            | If no new file was uploaded,
            | keep existing attachment.
            */
        }

        /*
        |--------------------------------------------------------------------------
        | Update Goal
        |--------------------------------------------------------------------------
        */

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

            /*
            |--------------------------------------------------------------------------
            | Evidence
            |--------------------------------------------------------------------------
            */

            'evidence_type' =>
                $evidenceType,

            'evidence_video_url' =>
                $evidenceVideoUrl,

            'evidence_attachment' =>
                $evidenceAttachment,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Goal History
        |--------------------------------------------------------------------------
        */

        $newgoal->histories()->create([
            'user_id' =>
                Auth::id(),

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