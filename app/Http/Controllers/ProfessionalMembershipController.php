<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfessionalMembershipController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = ProfessionalMembership::all();
            if ($request->ajax()) {
                return response()->json($data);
            }
            return view('indicator_forms.employability');
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
        try {
            // Validate form
            $request->validate([
                'type_of_membership' => 'required|string',
                'name_of_professional_body' => 'required|string|max:255',
                'category_of_body' => 'required|string',
                'discipline' => 'required|string',
                'level' => 'required|string',
                'country' => 'nullable|string|max:100',
                'membership_status' => 'required|string',
                'membership_start_date' => 'required|date',
                'membership_valid_until' => 'required|date|after_or_equal:membership_start_date',
                'evidence_type' => 'nullable|array',
                'document_link' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip',
                'declaration' => 'accepted',
            ]);

            // Handle file upload
            $documentPath = null;
            if ($request->hasFile('document_link')) {
                $documentPath = $request->file('document_link')->store('professional_memberships', 'public');
            }

            // Save to database
            $membership = ProfessionalMembership::create([
                'form_status' => $request->form_status,
                'indicator_id' => $request->indicator_id,
                'type_of_membership' => $request->type_of_membership,
                'name_of_professional_body' => $request->name_of_professional_body,
                'category_of_body' => $request->category_of_body,
                'discipline' => $request->discipline,
                'level' => $request->level,
                'country' => $request->country,
                'membership_status' => $request->membership_status,
                'membership_start_date' => $request->membership_start_date,
                'membership_valid_until' => $request->membership_valid_until,
                'evidence_type' => $request->input('evidence_type', []),
                'document_link' => $documentPath,
                'declaration' => $request->has('declaration'),
            ]);

            return response()->json([
                'message' => 'Professional Membership saved successfully',
                'data' => $membership
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Oops! Something went wrong'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProfessionalMembership::findOrFail($id);
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'key_performance_area' => 'required',
        ]);
        $userId = session('user_id');
        $data = ProfessionalMembership::findOrFail($id);
        $data->performance_area = $request->key_performance_area;
        $data->updated_by = $userId;
        $data->save();
        return response()->json(['message' => 'data update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $kfa = ProfessionalMembership::findOrFail($id);
            $kfa->delete();
            return response()->json(['status' => 'success', 'message' => 'Survey deleted successfully']);
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
    public function report($id)
    {
        $area = ProfessionalMembership::with('indicatorCategories.indicators')->findOrFail($id);
        return view('admin.performance', compact('area'));
    }
}

