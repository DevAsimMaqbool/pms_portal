<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IndicatorsPercentage;

class AssignBadgeController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $submissions = getIndicatorsByScore('>=', 80);
        return view('admin.assign_badge.index', compact('submissions'));
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
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'badge' => 'required|string|in:gold,silver,bronze',
        ]);

        $indicator = IndicatorsPercentage::findOrFail($id);
        $indicator->badge_name = $request->badge;
        $indicator->given_by = Auth::id();
        $indicator->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Badge updated successfully',
            'badge' => $indicator->badge_name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}

