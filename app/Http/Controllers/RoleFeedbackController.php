<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LineManagerFeedback;
use Illuminate\Support\Facades\Auth;

class RoleFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $authUser = Auth::user();

            // Upward: get manager if exists
            $manager = $authUser->manager ? collect([$authUser->manager]) : collect();

            // Downward: get subordinates if any
            $subordinates = $authUser->subordinates ?? collect();

            // Combine both into a single collection
            $facultyMembers = $manager->merge($subordinates);

            return view(
                'admin.form.role-feedback',
                compact('facultyMembers')
            );
        } catch (\Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                ''
            );
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rating = LineManagerFeedback::findOrFail($id);
        $authUser = Auth::user();

        // Upward: get manager if exists
        $manager = $authUser->manager ? collect([$authUser->manager]) : collect();

        // Downward: get subordinates if any
        $subordinates = $authUser->subordinates ?? collect();

        // Combine both into a single collection
        $facultyMembers = $manager->merge($subordinates);
        return view('admin.form.role-feedback_edit', compact('rating', 'facultyMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
