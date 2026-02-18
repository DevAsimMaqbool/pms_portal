<?php

namespace App\Http\Controllers;

use App\Models\LineManagerFeedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LineManagerFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = Auth::user();

        // Upward: get manager if exists
        $manager = $authUser->manager ? collect([$authUser->manager]) : collect();

        // Downward: get subordinates if any
        $subordinates = $authUser->subordinates ?? collect();

        // Combine both into a single collection
        $facultyMembers = $manager->merge($subordinates);

        // Feedback mapped by employee_id
        $ratings = LineManagerFeedback::whereIn('employee_id', $facultyMembers->pluck('id'))
            ->where('status', 1)
            ->get()
            ->keyBy('employee_id');

        // Counts
        $total = $facultyMembers->count();
        $completed = $ratings->count();
        $notCompleted = $total - $completed;

        return view(
            'admin.form.line_manager_satisfaction_feedback_view',
            compact('facultyMembers', 'ratings', 'total', 'completed', 'notCompleted')
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
            'year' => 'nullable',
            'responsibility_accountability_1' => 'nullable|integer',
            'responsibility_accountability_2' => 'nullable|integer',
            'empathy_compassion_1' => 'nullable|integer',
            'empathy_compassion_2' => 'nullable|integer',
            'humility_service_1' => 'nullable|integer',
            'humility_service_2' => 'nullable|integer',
            'honesty_integrity_1' => 'nullable|integer',
            'honesty_integrity_2' => 'nullable|integer',
            'inspirational_leadership_1' => 'nullable|integer',
            'inspirational_leadership_2' => 'nullable|integer',
            'strength' => 'nullable|string',
            'area_of_improvement' => 'nullable|string',
            'remarks' => 'nullable|string',

        ]);

        $employeeId = $request->employee_id;
        $year = $request->year;

        // Check if the employee has already submitted feedback for this year
        $existing = LineManagerFeedback::where('created_by', $employeeId)
            ->where('year', $year)
            ->first();

        if ($existing) {
            return redirect()->route('self-assessment.index')
                ->with('error', 'You have already submitted feedback for this year.');
        }
        if ($request->assessment_type) {
            unset($data['employee_id']);
            $data['assessment_type'] = $request->assessment_type;
            if ($request->has('strength')) {
                $data['strength'] = $request->strength ? json_encode(explode(',', $request->strength)) : null;
            }
            if ($request->has('area_of_improvement')) {
                $data['area_of_improvement'] = $request->area_of_improvement ? json_encode(explode(',', $request->area_of_improvement)) : null;
            }
        }
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $rating = LineManagerFeedback::create($data);
        if ($request->assessment_type) {
            return redirect()->route('self-assessment.index')
                ->with('success', 'Assessment saved successfully!');
        }
        return redirect()->route('employee.rating.index')
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
        $rating = LineManagerFeedback::findOrFail($id);
        $authUser = Auth::user();

        // Upward: get manager if exists
        $manager = $authUser->manager ? collect([$authUser->manager]) : collect();

        // Downward: get subordinates if any
        $subordinates = $authUser->subordinates ?? collect();

        // Combine both into a single collection
        $facultyMembers = $manager->merge($subordinates);
        return view('admin.form.line_manager_satisfaction_feedback_edit', compact('rating', 'facultyMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rating = LineManagerFeedback::findOrFail($id);

        $data = $request->validate([
            'employee_id' => 'nullable|integer',
            'year' => 'nullable',
            'responsibility_accountability_1' => 'nullable|integer',
            'responsibility_accountability_2' => 'nullable|integer',
            'empathy_compassion_1' => 'nullable|integer',
            'empathy_compassion_2' => 'nullable|integer',
            'humility_service_1' => 'nullable|integer',
            'humility_service_2' => 'nullable|integer',
            'honesty_integrity_1' => 'nullable|integer',
            'honesty_integrity_2' => 'nullable|integer',
            'inspirational_leadership_1' => 'nullable|integer',
            'inspirational_leadership_2' => 'nullable|integer',
            'remarks' => 'nullable|string',
        ]);

        $rating->update($data);
        return redirect()->route('employee.rating.index')
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
