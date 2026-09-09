<?php

namespace App\Http\Controllers;

use App\Models\GoalInitiative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GoalInitiativeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Nature Options
    |--------------------------------------------------------------------------
    */

    private array $natureOptions = [
        'Teaching and Learning',
        'Research Innovation and Commercialization',
        'Financial Sustainability',
        'Social Responsibility',
        'Brand / Institutional Identity',
        'Community and Outreach',
        'Internationalisation',
        'People and Culture',
        'Process and Operational Improvements',
        'Governance and Administration',
        'Technological',
        'Others',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scope Options
    |--------------------------------------------------------------------------
    */

    private array $scopeOptions = [
        'individual'       => 'Individual',
        'team_peer'        => 'Team / Peer',
        'departmental'     => 'Departmental',
        'faculty_wide'     => 'Faculty Wide',
        'institution_wide' => 'Institution Wide',
    ];

    /*
    |--------------------------------------------------------------------------
    | Initiative Status Options
    |--------------------------------------------------------------------------
    */

    private array $statusOptions = [
        'idea_designed_only'
            => 'Idea Designed Only',

        'approved_in_progress'
            => 'Approved and In Progress',

        'completed'
            => 'Completed',

        'completed_verified'
            => 'Completed and Verified by Manager / Project Head',
    ];

    /*
    |--------------------------------------------------------------------------
    | Employee - Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $initiatives = GoalInitiative::with('manager')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'admin.goal-initiatives.index',
            compact('initiatives')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Employee - Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.goal-initiatives.create', [
            'natureOptions' => $this->natureOptions,
            'scopeOptions'  => $this->scopeOptions,
            'statusOptions' => $this->statusOptions,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Employee - Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $this->validateInitiative($request);

        /*
         * Evidence
         */
        if ($request->hasFile('evidence_attachment')) {

            $validated['evidence_attachment'] =
                $request->file('evidence_attachment')
                    ->store('initiative-evidence', 'public');
        }

        /*
         * Logged-in employee
         */
        $validated['user_id'] = Auth::id();

        /*
         * Immediately send to manager
         */
        $validated['manager_decision'] = 'submitted';

        $validated['submitted_at'] = now();

        GoalInitiative::create($validated);

        return redirect()
            ->route('goal-initiatives.index')
            ->with(
                'success',
                'Initiative submitted successfully to your Line Manager for validation.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Employee - Show
    |--------------------------------------------------------------------------
    */

    public function show(GoalInitiative $goalInitiative)
    {
        $this->authorizeOwner($goalInitiative);

        $goalInitiative->load('manager');

        return view(
            'admin.goal-initiatives.show',
            compact('goalInitiative')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Employee - Edit
    |--------------------------------------------------------------------------
    */

    public function edit(GoalInitiative $goalInitiative)
    {
        $this->authorizeOwner($goalInitiative);

        /*
         * Once approved OR approved with amendment,
         * employee cannot edit.
         */
        if (in_array(
            $goalInitiative->manager_decision,
            [
                'approved',
                'approved_with_amendment',
            ],
            true
        )) {

            return redirect()
                ->route(
                    'goal-initiatives.show',
                    $goalInitiative
                )
                ->with(
                    'error',
                    'This initiative has already been validated by your Line Manager and cannot be edited.'
                );
        }

        return view('admin.goal-initiatives.edit', [
            'goalInitiative' => $goalInitiative,
            'natureOptions'  => $this->natureOptions,
            'scopeOptions'   => $this->scopeOptions,
            'statusOptions'  => $this->statusOptions,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Employee - Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        GoalInitiative $goalInitiative
    ) {
        $this->authorizeOwner($goalInitiative);

        /*
         * Approved initiatives are locked.
         */
        if (in_array(
            $goalInitiative->manager_decision,
            [
                'approved',
                'approved_with_amendment',
            ],
            true
        )) {

            return redirect()
                ->route(
                    'goal-initiatives.show',
                    $goalInitiative
                )
                ->with(
                    'error',
                    'This initiative has already been validated and cannot be edited.'
                );
        }

        $validated = $this->validateInitiative(
            $request,
            $goalInitiative
        );

        /*
         * Replace evidence
         */
        if ($request->hasFile('evidence_attachment')) {

            if (
                $goalInitiative->evidence_attachment &&
                Storage::disk('public')->exists(
                    $goalInitiative->evidence_attachment
                )
            ) {
                Storage::disk('public')->delete(
                    $goalInitiative->evidence_attachment
                );
            }

            $validated['evidence_attachment'] =
                $request->file('evidence_attachment')
                    ->store('initiative-evidence', 'public');
        }

        /*
         * Re-submit to manager after rejection/edit.
         */
        $validated['manager_decision'] = 'submitted';

        $validated['manager_remarks'] = null;

        $validated['manager_id'] = null;

        $validated['manager_decided_at'] = null;

        $validated['submitted_at'] = now();

        $goalInitiative->update($validated);

        return redirect()
            ->route('goal-initiatives.index')
            ->with(
                'success',
                'Initiative updated and submitted again to your Line Manager.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Employee - Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(
        GoalInitiative $goalInitiative
    ) {
        $this->authorizeOwner($goalInitiative);

        /*
         * Approved / Approved with Amendment
         * cannot be deleted.
         */
        if (in_array(
            $goalInitiative->manager_decision,
            [
                'approved',
                'approved_with_amendment',
            ],
            true
        )) {

            return redirect()
                ->route('goal-initiatives.index')
                ->with(
                    'error',
                    'This initiative has already been validated and cannot be deleted.'
                );
        }

        /*
         * Delete evidence
         */
        if (
            $goalInitiative->evidence_attachment &&
            Storage::disk('public')->exists(
                $goalInitiative->evidence_attachment
            )
        ) {

            Storage::disk('public')->delete(
                $goalInitiative->evidence_attachment
            );
        }

        $goalInitiative->delete();

        return redirect()
            ->route('goal-initiatives.index')
            ->with(
                'success',
                'Initiative deleted successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager - List Pending Initiatives
    |--------------------------------------------------------------------------
    */

    public function managerIndex()
{
    $managerId = Auth::id();

    $initiatives = GoalInitiative::with(['user', 'manager'])
        ->whereHas('user', function ($query) use ($managerId) {
            $query->where('manager_id', $managerId);
        })
        ->latest('submitted_at')
        ->paginate(10);

    // Counts for manager dashboard
    $baseQuery = GoalInitiative::whereHas('user', function ($query) use ($managerId) {
        $query->where('manager_id', $managerId);
    });

    $counts = [
        'total' => (clone $baseQuery)->count(),

        'submitted' => (clone $baseQuery)
            ->where('manager_decision', 'submitted')
            ->count(),

        'approved' => (clone $baseQuery)
            ->where('manager_decision', 'approved')
            ->count(),

        'approved_with_amendment' => (clone $baseQuery)
            ->where('manager_decision', 'approved_with_amendment')
            ->count(),

        'rejected' => (clone $baseQuery)
            ->where('manager_decision', 'rejected')
            ->count(),
    ];

    return view(
        'admin.goal-initiatives.manager-index',
        compact('initiatives', 'counts')
    );
}

    /*
    |--------------------------------------------------------------------------
    | Manager - View Initiative
    |--------------------------------------------------------------------------
    */

    public function managerShow(
        GoalInitiative $goalInitiative
    ) {
        $this->authorizeManager($goalInitiative);

        $goalInitiative->load('user');

        return view(
            'admin.goal-initiatives.manager-show',
            compact('goalInitiative')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager - Approve
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        GoalInitiative $goalInitiative
    ) {
        $this->authorizeManager($goalInitiative);

        $this->validateManagerDecision($request);

        /*
         * Only submitted initiatives can be decided.
         */
        if (
            $goalInitiative->manager_decision !==
            'submitted'
        ) {

            return back()->with(
                'error',
                'This initiative has already been processed.'
            );
        }

        $goalInitiative->update([

            'manager_decision' => 'approved',

            'manager_remarks' =>
                $request->manager_remarks,

            'manager_id' => Auth::id(),

            'manager_decided_at' => now(),
        ]);

        return back()->with(
            'success',
            'Initiative approved successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager - Approve With Amendment
    |--------------------------------------------------------------------------
    */

    public function approveWithAmendment(
        Request $request,
        GoalInitiative $goalInitiative
    ) {
        $this->authorizeManager($goalInitiative);

        $request->validate([
            'manager_remarks' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
         * Only submitted initiatives can be decided.
         */
        if (
            $goalInitiative->manager_decision !==
            'submitted'
        ) {

            return back()->with(
                'error',
                'This initiative has already been processed.'
            );
        }

        $goalInitiative->update([

            'manager_decision'
                => 'approved_with_amendment',

            'manager_remarks'
                => $request->manager_remarks,

            'manager_id'
                => Auth::id(),

            'manager_decided_at'
                => now(),
        ]);

        return back()->with(
            'success',
            'Initiative approved with amendment successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager - Reject
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        GoalInitiative $goalInitiative
    ) {
        $this->authorizeManager($goalInitiative);

        $request->validate([
            'manager_remarks' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
         * Only submitted initiatives can be rejected.
         */
        if (
            $goalInitiative->manager_decision !==
            'submitted'
        ) {

            return back()->with(
                'error',
                'This initiative has already been processed.'
            );
        }

        $goalInitiative->update([

            'manager_decision' => 'rejected',

            'manager_remarks'
                => $request->manager_remarks,

            'manager_id'
                => Auth::id(),

            'manager_decided_at'
                => now(),
        ]);

        return back()->with(
            'success',
            'Initiative rejected successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Initiative Validation
    |--------------------------------------------------------------------------
    */

    private function validateInitiative(
        Request $request,
        ?GoalInitiative $initiative = null
    ): array {

        return $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'from_date' => [
                'required',
                'date',
            ],

            'to_date' => [
                'required',
                'date',
                'after_or_equal:from_date',
            ],

            'nature_of_initiative' => [
                'required',
                Rule::in($this->natureOptions),
            ],

            'nature_other' => [
                'nullable',
                'required_if:nature_of_initiative,Others',
                'string',
                'max:255',
            ],

            'scope' => [
                'required',
                Rule::in(
                    array_keys($this->scopeOptions)
                ),
            ],

            'description' => [
                'required',
                'string',
                'max:10000',
            ],

            'status' => [
                'required',
                Rule::in(
                    array_keys($this->statusOptions)
                ),
            ],

            'outcome' => [
                'nullable',
                'string',
                'max:10000',
            ],

            'impact_reach' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'impact_outcome' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'sustainability' => [
                'nullable',
                Rule::in([
                    'one_off',
                    'adopted_standard_practice',
                ]),
            ],

            'sustainability_field' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'strategic_alignment' => [
                'nullable',
                Rule::in([
                    'not_linked',
                    'linked',
                ]),
            ],

            'strategic_goal' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'supervisor_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'supervisor_designation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'supervisor_department' => [
                'nullable',
                'string',
                'max:255',
            ],

            'evidence_attachment' => [
                'nullable',
                'file',
                'mimes:doc,docx,pdf,png,jpg,jpeg',
                'max:10240',
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Employee Authorization
    |--------------------------------------------------------------------------
    */

    private function authorizeOwner(
        GoalInitiative $goalInitiative
    ): void {

        abort_unless(
            (int) $goalInitiative->user_id ===
            (int) Auth::id(),
            403
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager Authorization
    |--------------------------------------------------------------------------
    */

    private function authorizeManager(
        GoalInitiative $goalInitiative
    ): void {

        $employee = $goalInitiative->user;

        /*
         * Logged-in manager must be the employee's
         * actual line manager.
         */
        abort_unless(
            $employee &&
            (int) $employee->manager_id ===
            (int) Auth::id(),
            403
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manager Decision Validation
    |--------------------------------------------------------------------------
    */

    private function validateManagerDecision(
        Request $request
    ): void {

        $request->validate([
            'manager_remarks' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);
    }
}