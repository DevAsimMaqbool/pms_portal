<?php

namespace App\Http\Controllers;

use App\Models\SelfAssessmentWorking;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelfAssessmentWorkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $records = SelfAssessmentWorking::orderBy('created_at', 'asc')
                ->get()
                ->keyBy(function ($item) {
                    return $item->kpa;
                });
            return view('admin.self_assessment', compact('records'));
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
        $term = $request->input('term');
        $data = $request->input('data', []);

        $kpas = [
            0 => 'Teaching and Learning',
            1 => 'Research, Innovation and Commercialisation',
            2 => 'Institutional Engagement (Core only)',
            3 => 'Institutional Engagement (Operational+ Character Strengths)',
        ];

        $insertData = [];
        foreach ($data as $index => $row) {
            if (!empty($row['challenge']) || !empty($row['working'])) {
                $insertData[] = [
                    'kpa' => $kpas[$index],
                    'term' => $term, // ✅ single chosen term for all rows
                    'general_comments' => $row['general_comments'] ?? null,
                    'challenge' => $row['challenge'] ?? null,
                    'strength' => $row['strength'] ?? null,
                    'working' => $row['working'] ?? null,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($insertData)) {
            SelfAssessmentWorking::upsert(
                $insertData,
                ['kpa', 'term'], // unique per KPA + Term
                ['general_comments', 'challenge', 'strength', 'working', 'updated_at']
            );
        }

        return redirect()->route('self-assessment.index')
            ->with('success', 'Data saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SelfAssessmentWorking $selfAssessmentWorking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = SelfAssessmentWorking::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'term' => 'required',
            'general_comments' => '',
            'challenge' => 'required',
            'strength' => '',
            'working' => 'required',
        ]);
        $userId = Auth::id();
        $data = SelfAssessmentWorking::findOrFail($id);
        $data->term = $request->term;
        $data->general_comments = $request->general_comments;
        $data->challenge = $request->challenge;
        $data->strength = $request->strength;
        $data->working = $request->working;
        $data->updated_by = $userId;
        $data->save();
        return response()->json(['message' => 'Data update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        try {
            $data = SelfAssessmentWorking::findOrFail($id);
            $data->delete();
            return response()->json(['status' => 'success', 'message' => 'Data deleted successfully']);
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
}
