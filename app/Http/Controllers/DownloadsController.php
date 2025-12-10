<?php

namespace App\Http\Controllers;

use App\Models\PmsPolicy;
use Illuminate\Http\Request;

class DownloadsController extends Controller
{

    public function __construct()
    {
    }
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $policies = PmsPolicy::orderBy('created_at', 'desc')->first();
        return view('admin.downloads', compact('policies'));

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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
