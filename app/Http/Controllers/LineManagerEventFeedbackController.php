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

        // All faculty members under this manager
        $facultyMembers = User::where('manager_id', $employee_id)
            ->get(['id', 'name', 'department', 'job_title']);

        // All feedbacks for these faculty members, grouped by employee_id
        $ratings = LineManagerEventFeedback::whereIn('employee_id', $facultyMembers->pluck('id'))
            ->where('status', 1)
            ->orderBy('created_at', 'desc') // optional, latest first
            ->get()
            ->groupBy('employee_id');

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
            'event_name' => 'required|array|min:1', // must be an array
            'event_name.*' => 'required|string|max:255', // each selected event
            'score' => 'required|numeric|min:0|max:5',
            'remarks' => 'nullable|string',
        ]);

        // Convert rating (1-5 stars to 20-100)
        $convertedRating = $request->score * 20;

        foreach ($request->event_name as $event) {
            LineManagerEventFeedback::updateOrCreate(
                [
                    'employee_id' => $request->employee_id,
                    'event_name' => $event,
                ],
                [
                    'rating' => $convertedRating,
                    'remarks' => $request->remarks,
                ]
            );
        }

        // Return JSON for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'Feedback saved successfully.',
            'redirect' => route('employee.feedback.index'), // optional, if you want to redirect via JS
        ]);
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
        $starScore = $feedback->rating / 20;
        // Get current authenticated user's employee_id
        $user = Auth::user();
        $employee_id = $user->employee_id;

        // Get faculty members under this manager
        $facultyMembers = User::where('manager_id', $employee_id)
            ->get(['id', 'name', 'department', 'job_title']);

        // Pass to view
        return view('admin.form.line_manager_event_feedback_edit', compact('feedback', 'facultyMembers', 'starScore'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'event_name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = LineManagerEventFeedback::where('employee_id', $request->employee_id)
                        ->where('event_name', $value)
                        ->where('id', '<>', $id) // exclude current record
                        ->exists();
                    if ($exists) {
                        $fail('Feedback for this employee and event already exists.');
                    }
                }
            ],
            'score' => 'required|numeric|min:0|max:5',
            'remarks' => 'nullable|string',
        ]);

        $feedback = LineManagerEventFeedback::findOrFail($id);
        $feedback->update([
            'employee_id' => $request->employee_id,
            'event_name' => $request->event_name,
            'rating' => $request->score * 20, // convert to 20–100 scale
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('employee.feedback.index')
            ->with('success', 'Feedback updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LineManagerEventFeedback $lineManagerEventFeedback)
    {
        //
    }
}