<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\Survey;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use PDF;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexbk()
    {
        try {
            $users = Survey::limit(5)->get();
            return view('admin.form.teaching_learning', compact('users'));
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), [], false, 500, '');
        }
    }

    public function index(Request $request)
    {
        try {
            $kfa = Survey::all();
            if ($request->ajax()) {
                return response()->json($kfa);
            }
            return view('admin.survey_data');
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
    public function update(Request $request, $id)
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

    public function report(Request $request)
    {
        try {
            $kfa = DB::table('surveys as s')
                ->select(
                    's.campus',
                    's.faculty_code',
                    's.faculty as faculty_name',
                    DB::raw('COUNT(DISTINCT s.course) as total_courses'),
                    DB::raw('COUNT(DISTINCT s.student_id) as total_respondents'),
                    DB::raw('SUM(CAST(s.answer AS DECIMAL)) as obtained_score'),
                    DB::raw('COUNT(s.answer) * 5 as max_score'),
                    DB::raw('ROUND((SUM(CAST(s.answer AS DECIMAL)) / (COUNT(s.answer) * 5)) * 100, 2) as percentage_score'),
                    DB::raw('ROUND(AVG(CAST(s.answer AS DECIMAL)), 2) as avg_score')
                )
                ->where('s.answer_type', '<>', 'Free text')
                ->groupBy('s.campus', 's.faculty_code', 's.faculty')
                // ->orderBy('s.campus')
                // ->orderBy('faculty_name')
                ->orderBy('percentage_score', 'desc')
                ->get();

            if ($request->ajax()) {
                return response()->json($kfa);
            }
            return view('admin.teacher_overall_survey_report', compact('kfa'));
        } catch (\Exception $e) {
            return apiResponse(
                'Oops! Something went wrong',
                [],
                false,
                500,
                $e->getMessage()
            );
        }
    }

    // app/Http/Controllers/SurveyController.php
    public function exportPdf()
    {
        $data = DB::table('surveys as s')
            ->select(
                's.campus',
                's.faculty_code',
                's.faculty as faculty_name',
                DB::raw('COUNT(DISTINCT s.course) as total_courses'),
                DB::raw('COUNT(DISTINCT s.student_id) as total_respondents'),
                DB::raw('SUM(CAST(s.answer AS DECIMAL)) as obtained_score'),
                DB::raw('MAX(s.answer) as max_score'),
                DB::raw('ROUND(AVG(CAST(s.answer AS DECIMAL)),2) as avg_score')
            )
            ->groupBy('s.campus', 's.faculty_code', 's.faculty')
            ->get();

        $pdf = PDF::loadView('admin.survey_report', compact('data'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->download('survey_report.pdf');
    }


}
