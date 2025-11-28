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
        $ratings = LineManagerFeedback::with('employee')->get();
        return view('admin.form.line_manager_satisfaction_feedback_view', compact('ratings'));
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

        $rating = LineManagerFeedback::create($data);

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
        $user = Auth::user();
        $employee_id = $user->employee_id;
        $facultyMembers = User::where('manager_id', $employee_id)->get(['id', 'name', 'department', 'job_title']);
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
