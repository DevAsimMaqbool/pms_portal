<?php

namespace App\Http\Controllers;

use App\Models\RoleKpaAssignment;
use App\Models\Role;
use Illuminate\Http\Request;

class UserKPAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$roleId = $request->user()->role_id; // Assuming you get this from the login API and store in DB
        $roleName = 'QEC';

        $role = Role::where('name', $roleName)->firstOrFail();

        $roleId = $role->id;
        $assignments = RoleKpaAssignment::with(['keyPerformanceArea', 'category', 'indicator'])
            ->where('role_id', $roleId)
            ->get();

        return view('user.kpa', compact('assignments'));
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
    public function show(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleKpaAssignment $roleKpaAssignment)
    {
        //
    }
}
