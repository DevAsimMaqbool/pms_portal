<?php

namespace App\Http\Controllers;

use App\Models\LineManagerEventFeedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LineManagerEventFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $employee_id = $user->employee_id;

        $facultyMembers = User::where('manager_id', $employee_id)
            ->get(['id', 'name', 'department', 'job_title']);

        // Feedback mapped by employee_id
        $ratings = LineManagerEventFeedback::whereIn('employee_id', $facultyMembers->pluck('id'))
            ->where('status', 1)
            ->get()
            ->keyBy('employee_id');

        // Counts
        $total = $facultyMembers->count();
        $completed = $ratings->count();
        $notCompleted = $total - $completed;

        return view(
            'admin.form.line_manager_event_feedback_view',
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
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'event_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:20|max:100',
            'remarks' => 'nullable|string',
        ]);

        LineManagerEventFeedback::create($request->all());

        return redirect()->route('employee.feedback.index')
            ->with('success', 'Feedback saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LineManagerEventFeedback $lineManagerEventFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        // Fetch the existing feedback
        $feedback = LineManagerEventFeedback::findOrFail($id);

        // Get current authenticated user's employee_id
        $user = Auth::user();
        $employee_id = $user->employee_id;

        // Get faculty members under this manager
        $facultyMembers = User::where('manager_id', $employee_id)
            ->get(['id', 'name', 'department', 'job_title']);

        // Pass to view
        return view('admin.form.line_manager_event_feedback_edit', compact('feedback', 'facultyMembers'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $feedback = LineManagerEventFeedback::findOrFail($id);

        // Validate request
        $data = $request->validate([
            'employee_id' => 'required|integer|exists:users,id',
            'event_name' => 'required|string',
            'rating' => 'required|integer|in:20,40,60,80,100',
            'remarks' => 'nullable|string',
        ]);

        // Update the feedback
        $feedback->update($data);

        return redirect()->route('employee.feedback.index')
            ->with('success', 'Feedback updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LineManagerEventFeedback $lineManagerEventFeedback)
    {
        //
    }
}