<?php

namespace App\Http\Controllers;

use App\Models\LineManagerFeedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LineManagerGoalFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = Auth::user();

        // Manager
        $manager = $authUser->manager
            ? collect([$authUser->manager])
            : collect();

        // Subordinates
        $subordinates = $authUser->subordinates ?? collect();

        // Manager + Subordinates
        $facultyMembers = $manager->merge($subordinates);

        /*
         * Only get feedback submitted by the logged-in user.
         *
         * employee_id = person who received feedback
         * created_by  = person who submitted feedback
         */
        $ratings = LineManagerFeedback::where('created_by', $authUser->id)
            ->whereIn('employee_id', $facultyMembers->pluck('id'))
            ->where('status', 1)
            ->get()
            ->keyBy('employee_id');

        // Counts
        $total = $facultyMembers->count();
        $completed = $ratings->count();
        $notCompleted = $total - $completed;

        return view(
            'admin.form.goal_feedback.line_manager_satisfaction_feedback_view',
            compact(
                'facultyMembers',
                'ratings',
                'total',
                'completed',
                'notCompleted'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'nullable|integer',
            'year_id' => 'required',
            'responsibility_accountability_1' => 'nullable|integer',
            'responsibility_accountability_2' => 'nullable|integer',
            'responsibility_accountability_3' => 'nullable|integer',
            'honesty_integrity_1' => 'nullable|integer',
            'honesty_integrity_2' => 'nullable|integer',
            'honesty_integrity_3' => 'nullable|integer',
            'empathy_compassion_1' => 'nullable|integer',
            'empathy_compassion_2' => 'nullable|integer',
            'humility_service_1' => 'nullable|integer',
            'humility_service_2' => 'nullable|integer',
            'humility_service_3' => 'nullable|integer',
            'inspirational_leadership_1' => 'nullable|integer',
            'inspirational_leadership_2' => 'nullable|integer',
            'inspirational_leadership_3' => 'nullable|integer',
            'remarks' => 'nullable|string',

        ]);

        $employeeId = $request->employee_id;
        $year = $request->year_id;

        // Check if the employee has already submitted feedback for this year
        $existing = LineManagerFeedback::where('created_by', Auth::id())
            ->where('employee_id', $employeeId)
            ->where('year_id', $year)
            ->first();

        if ($existing) {
            return redirect()->route('linemanager.feedback')
                ->with('error', 'You have already submitted feedback for this year.');
        }
        
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $rating = LineManagerFeedback::create($data);
        return redirect()->route('employee.goalfeedback.index')
            ->with('success', 'Rating saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LineManagerFeedback $lineManagerFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $authUser = Auth::user();

        $feedback = LineManagerFeedback::where('id', $id)
            ->where('created_by', $authUser->id)
            ->firstOrFail();

        $manager = $authUser->manager
            ? collect([$authUser->manager])
            : collect();

        $subordinates = $authUser->subordinates ?? collect();

        $facultyMembers = $manager->merge($subordinates);

        return view(
            'admin.form.goal_feedback.line_manager_satisfaction_feedback_edit',
            compact('feedback', 'facultyMembers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $authUser = Auth::user();

        $rating = LineManagerFeedback::where('id', $id)
            ->where('created_by', $authUser->id)
            ->firstOrFail();

        $data = $request->validate([
            'employee_id' => 'nullable|integer',
            'year_id' => 'required',
            'responsibility_accountability_1' => 'nullable|integer',
            'responsibility_accountability_2' => 'nullable|integer',
            'responsibility_accountability_3' => 'nullable|integer',
            'empathy_compassion_1' => 'nullable|integer',
            'empathy_compassion_2' => 'nullable|integer',
            'humility_service_1' => 'nullable|integer',
            'humility_service_2' => 'nullable|integer',
            'humility_service_3' => 'nullable|integer',
            'honesty_integrity_1' => 'nullable|integer',
            'honesty_integrity_2' => 'nullable|integer',
            'honesty_integrity_3' => 'nullable|integer',
            'inspirational_leadership_1' => 'nullable|integer',
            'inspirational_leadership_2' => 'nullable|integer',
            'inspirational_leadership_3' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ]);

        $rating->update($data);

        return redirect()->route('employee.goalfeedback.index')
            ->with('success', 'Rating updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LineManagerFeedback $lineManagerFeedback)
    {
        //
    }
}
