<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // $authUser = auth()->user();
            // $records = SelfAssessmentWorking::orderBy('created_at', 'asc')
            //     ->where('created_by', $authUser->id)
            //     ->get()
            //     ->keyBy(function ($item) {
            //         return $item->kpa;
            //     });
            // $rating = LineManagerFeedback::where('created_by', $authUser->id)
            //     ->where('status', 1)
            //     ->first();
            return view('admin.form.role-feedback');
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
        //
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
