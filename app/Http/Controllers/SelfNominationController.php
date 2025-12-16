<?php

namespace App\Http\Controllers;

use App\Models\SelfNomination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SelfNominationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = SelfNomination::with('user')->get();
        return view('admin.self_nomination.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeeId = Auth::user()->employee_id;
        $submission = SelfNomination::where('employee_id', $employeeId)->first();
        return view('admin.self_nomination.add', compact('submission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sitara_qiyadat_awards' => 'nullable|array',
            'sitara_qiyadat_why' => 'nullable|string',

            'fakhr_karkardagi_awards' => 'nullable|array',
            'fakhr_karkardagi_why' => 'nullable|string',

            'tamgha_tahqeeq_awards' => 'nullable|array',
            'tamgha_tahqeeq_why' => 'nullable|string',

            'chaudhry_akram_awards' => 'nullable|array',
            'chaudhry_akram_why' => 'nullable|string',

            'service_superheroes_awards' => 'nullable|array',
            'service_superheroes_why' => 'nullable|string',

            'disclaimer' => 'required|boolean',
        ]);
        $employeeId = $request->employee_id;
        $existing = SelfNomination::where('created_by', $employeeId)
            ->first();

        if ($existing) {
            return redirect()->route('nomination.index')
                ->with('error', 'You have already submitted for this year.');
        }
        SelfNomination::create([
            'employee_id' => $employeeId,

            'sitara_qiyadat_awards' => $request->sitara_qiyadat_awards,
            'sitara_qiyadat_why' => $request->sitara_qiyadat_why,

            'fakhr_karkardagi_awards' => $request->fakhr_karkardagi_awards,
            'fakhr_karkardagi_why' => $request->fakhr_karkardagi_why,

            'tamgha_tahqeeq_awards' => $request->tamgha_tahqeeq_awards,
            'tamgha_tahqeeq_why' => $request->tamgha_tahqeeq_why,

            'chaudhry_akram_awards' => $request->chaudhry_akram_awards,
            'chaudhry_akram_why' => $request->chaudhry_akram_why,

            'service_superheroes_awards' => $request->service_superheroes_awards,
            'service_superheroes_why' => $request->service_superheroes_why,

            'disclaimer' => $request->disclaimer,
            'created_by' => $employeeId,
            'updated_by' => $employeeId,
        ]);
        return redirect()
            ->route('nomination.create')
            ->with('success', 'Self-Nomination saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $submission = SelfNomination::with('user')->findOrFail($id);
        return view('admin.self_nomination.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $submission = SelfNomination::findOrFail($id);
        return view('policy.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $submission = SelfNomination::findOrFail($id);

        $request->validate([
            'sitara_qiyadat_awards' => 'nullable|array',
            'sitara_qiyadat_why' => 'nullable|string',

            'fakhr_karkardagi_awards' => 'nullable|array',
            'fakhr_karkardagi_why' => 'nullable|string',

            'tamgha_tahqeeq_awards' => 'nullable|array',
            'tamgha_tahqeeq_why' => 'nullable|string',

            'chaudhry_akram_awards' => 'nullable|array',
            'chaudhry_akram_why' => 'nullable|string',

            'service_superheroes_awards' => 'nullable|array',
            'service_superheroes_why' => 'nullable|string',

            'disclaimer' => 'required|boolean',
        ]);

        $submission->update([
            'sitara_qiyadat_awards' => $request->sitara_qiyadat_awards,
            'sitara_qiyadat_why' => $request->sitara_qiyadat_why,

            'fakhr_karkardagi_awards' => $request->fakhr_karkardagi_awards,
            'fakhr_karkardagi_why' => $request->fakhr_karkardagi_why,

            'tamgha_tahqeeq_awards' => $request->tamgha_tahqeeq_awards,
            'tamgha_tahqeeq_why' => $request->tamgha_tahqeeq_why,

            'chaudhry_akram_awards' => $request->chaudhry_akram_awards,
            'chaudhry_akram_why' => $request->chaudhry_akram_why,

            'service_superheroes_awards' => $request->service_superheroes_awards,
            'service_superheroes_why' => $request->service_superheroes_why,

            'disclaimer' => $request->disclaimer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $submission = SelfNomination::findOrFail($id);
        $submission->delete();
    }

    public function download($id)
    {
        $submission = SelfNomination::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('admin.self_nomination.print', compact('submission'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Self-Nomination-' . $submission->user->barcode . '.pdf');
    }
}

