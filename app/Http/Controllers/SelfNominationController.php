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
        $awardFields = [
            'sitara_qiyadat_awards' => 'Sitara Qiyadat',
            'fakhr_karkardagi_awards' => 'Fakhr-e-Karkardagi',
            'tamgha_tahqeeq_awards' => 'Tamgha-e-Tahqeeq',
            'chaudhry_akram_awards' => 'Chaudhry Akram',
            'service_superheroes_awards' => 'Service Superheroes',
        ];

        $submissions = SelfNomination::with('user')
            ->get()
            ->flatMap(function ($submission) use ($awardFields) {

                $rows = collect();

                foreach ($awardFields as $field => $awardName) {

                    if (!empty($submission->{$field})) {

                        $awards = is_array($submission->{$field})
                            ? $submission->{$field}
                            : json_decode($submission->{$field}, true);

                        if (!empty($awards)) {

                            $row = clone $submission;

                            $row->display_award = $awardName;

                            $row->display_award_values = collect($awards)
                                ->map(function ($award) {
                                    return ucwords(
                                        str_replace('_', ' ', $award)
                                    );
                                })
                                ->values();

                            $rows->push($row);
                        }
                    }
                }

                return $rows;
            })
            ->values();

        return view(
            'admin.self_nomination.index',
            compact('submissions')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employeeId = Auth::user()->employee_id;

        $submissions = SelfNomination::where('employee_id', $employeeId)->get();

        $sitaraSubmission = $submissions->first(function ($submission) {
            return !empty($submission->sitara_qiyadat_awards);
        });

        $fakhrSubmission = $submissions->first(function ($submission) {
            return !empty($submission->fakhr_karkardagi_awards);
        });

        $tamghaSubmission = $submissions->first(function ($submission) {
            return !empty($submission->tamgha_tahqeeq_awards);
        });

        $chaudhrySubmission = $submissions->first(function ($submission) {
            return !empty($submission->chaudhry_akram_awards);
        });

        $serviceSubmission = $submissions->first(function ($submission) {
            return !empty($submission->service_superheroes_awards);
        });

        return view('admin.self_nomination.add', compact(
            'sitaraSubmission',
            'fakhrSubmission',
            'tamghaSubmission',
            'chaudhrySubmission',
            'serviceSubmission'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',

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

        /*
        |--------------------------------------------------------------------------
        | Determine which award category is being submitted
        |--------------------------------------------------------------------------
        */

        $categories = [
            'sitara_qiyadat' => [
                'awards' => $request->sitara_qiyadat_awards,
                'why' => $request->sitara_qiyadat_why,
                'awards_column' => 'sitara_qiyadat_awards',
                'why_column' => 'sitara_qiyadat_why',
            ],

            'fakhr_karkardagi' => [
                'awards' => $request->fakhr_karkardagi_awards,
                'why' => $request->fakhr_karkardagi_why,
                'awards_column' => 'fakhr_karkardagi_awards',
                'why_column' => 'fakhr_karkardagi_why',
            ],

            'tamgha_tahqeeq' => [
                'awards' => $request->tamgha_tahqeeq_awards,
                'why' => $request->tamgha_tahqeeq_why,
                'awards_column' => 'tamgha_tahqeeq_awards',
                'why_column' => 'tamgha_tahqeeq_why',
            ],

            'chaudhry_akram' => [
                'awards' => $request->chaudhry_akram_awards,
                'why' => $request->chaudhry_akram_why,
                'awards_column' => 'chaudhry_akram_awards',
                'why_column' => 'chaudhry_akram_why',
            ],

            'service_superheroes' => [
                'awards' => $request->service_superheroes_awards,
                'why' => $request->service_superheroes_why,
                'awards_column' => 'service_superheroes_awards',
                'why_column' => 'service_superheroes_why',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Find submitted category
        |--------------------------------------------------------------------------
        */

        $submittedCategory = null;

        foreach ($categories as $category => $data) {

            if (!empty($data['awards'])) {
                $submittedCategory = $category;
                break;
            }
        }

        if (!$submittedCategory) {
            return redirect()
                ->route('nomination.create')
                ->with('error', 'Please select at least one award.');
        }

        $categoryData = $categories[$submittedCategory];

        /*
        |--------------------------------------------------------------------------
        | Remove duplicate awards
        |--------------------------------------------------------------------------
        */

        $awards = array_values(
            array_unique($categoryData['awards'])
        );

        /*
        |--------------------------------------------------------------------------
        | Find existing nomination for this employee + category
        |--------------------------------------------------------------------------
        */

        $existing = SelfNomination::where('employee_id', $employeeId)
            ->whereNotNull($categoryData['awards_column'])
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Update existing category
        |--------------------------------------------------------------------------
        */

        if ($existing) {

            $existing->update([
                $categoryData['awards_column'] => $awards,
                $categoryData['why_column'] => $categoryData['why'],
                'disclaimer' => $request->disclaimer,
                'updated_by' => $employeeId,
            ]);

        } else {

            /*
            |--------------------------------------------------------------------------
            | Create new category
            |--------------------------------------------------------------------------
            */

            SelfNomination::create([
                'employee_id' => $employeeId,

                $categoryData['awards_column'] => $awards,
                $categoryData['why_column'] => $categoryData['why'],

                'disclaimer' => $request->disclaimer,

                'created_by' => $employeeId,
                'updated_by' => $employeeId,
            ]);
        }

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

