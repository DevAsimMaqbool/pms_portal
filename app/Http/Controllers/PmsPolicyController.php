<?php

namespace App\Http\Controllers;

use App\Models\PmsPolicy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PmsPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $policies = PmsPolicy::orderBy('created_at', 'desc')->get();
        return view('admin.policy.policy_view', compact('policies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.policy.policy_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'sop_file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480', // 20MB
            'policy_file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480', // 20MB
        ]);

        $filePath = $request->file('sop_file')->store('policies', 'public');
        $policyPath = $request->file('policy_file')->store('policies', 'public');

        PmsPolicy::create([
            'sop_file' => $filePath,
            'policy_file' => $policyPath,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Policy uploaded successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $policy = PmsPolicy::findOrFail($id);
        return view('admin.policy.policy_edit', compact('policy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $policy = PmsPolicy::findOrFail($id);

        // Validate files (both optional if you allow update without changing them)
        $request->validate([
            'sop_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480',
            'policy_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:20480',
        ]);

        // Handle SOP file
        if ($request->hasFile('sop_file')) {
            if ($policy->sop_file && Storage::disk('public')->exists($policy->sop_file)) {
                Storage::disk('public')->delete($policy->sop_file);
            }
            $policy->sop_file = $request->file('sop_file')->store('policies', 'public');
        }

        // Handle Policy file
        if ($request->hasFile('policy_file')) {
            if ($policy->policy_file && Storage::disk('public')->exists($policy->policy_file)) {
                Storage::disk('public')->delete($policy->policy_file);
            }
            $policy->policy_file = $request->file('policy_file')->store('policies', 'public');
        }

        // Update type and updated_by
        $policy->updated_by = Auth::id();
        $policy->save();

        return back()->with('success', 'Policy updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $policy = PmsPolicy::findOrFail($id);

        // Delete SOP file if exists
        if ($policy->sop_file && Storage::disk('public')->exists($policy->sop_file)) {
            Storage::disk('public')->delete($policy->sop_file);
        }

        // Delete Policy file if exists
        if ($policy->policy_file && Storage::disk('public')->exists($policy->policy_file)) {
            Storage::disk('public')->delete($policy->policy_file);
        }

        // Delete the policy record
        $policy->delete();

        return back()->with('success', 'Policy deleted successfully!');
    }
}