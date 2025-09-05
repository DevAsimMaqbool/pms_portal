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
    public function surveyReportDashboard()
    {
        // 🔹 Mock Data — replace these with actual DB queries

        // Survey overview ratings
        $surveyRatings = [
            'Excellent' => 12,
            'Good' => 8,
            'Average' => 5,
            'Poor' => 2,
        ];

        // Participation trend (x: months, y: responses)
        $surveyTrendLabels = ['Jan', 'Feb', 'Mar', 'Apr'];
        $surveyTrendData = [20, 35, 40, 25];

        // Teacher overall ratings
        $teacherNames = ['Ali', 'Sara', 'John'];
        $teacherRatings = [4.5, 4.2, 3.9];

        // Single teacher course breakdown
        $courseNames = ['Math', 'Science', 'History'];
        $courseRatings = [4.7, 4.2, 3.8];

        // Radar chart (teacher strengths/weaknesses)
        $criteriaLabels = ['Knowledge', 'Communication', 'Punctuality', 'Engagement', 'Clarity'];
        $teacherRadarData = [80, 70, 90, 60, 85];

        // Leaderboard (table)
        $teachers = [
            (object) [
                'name' => 'Ali',
                'avg_rating' => 4.5,
                'responses_count' => 50,
                'best_course' => 'Math'
            ],
            (object) [
                'name' => 'Sara',
                'avg_rating' => 4.2,
                'responses_count' => 40,
                'best_course' => 'Science'
            ],
            (object) [
                'name' => 'John',
                'avg_rating' => 3.9,
                'responses_count' => 30,
                'best_course' => 'History'
            ],
        ];

        return view('admin.survey_report_dashboard', [
            // Chart data
            'surveyRatings' => array_values($surveyRatings),
            'surveyLabels' => array_keys($surveyRatings),
            'surveyTrendData' => $surveyTrendData,
            'surveyTrendLabels' => $surveyTrendLabels,
            'teacherRatings' => $teacherRatings,
            'teacherNames' => $teacherNames,
            'courseRatings' => $courseRatings,
            'courseNames' => $courseNames,
            'teacherRadarData' => $teacherRadarData,
            'criteriaLabels' => $criteriaLabels,

            // Table
            'teachers' => $teachers,
        ]);
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

    public function preview($faculty_code)
    {
        $record = DB::select("
            -- Overall Faculty Total (all courses combined, excluding Humility and Service)
            SELECT 
                s.faculty_code,
                s.faculty,
                NULL AS course,
                NULL AS question,
                SUM(CAST(s.answer AS DECIMAL(10,2))) AS obtained_score,
                COUNT(s.answer) * 5 AS max_score,
                ROUND(SUM(CAST(s.answer AS DECIMAL(10,2))) / (COUNT(s.answer) * 5) * 100, 2) AS percentage,
                'FACULTY_TOTAL' AS row_type
            FROM surveys s
            WHERE s.faculty_code = ? 
              AND s.question <> 'Humility and Service'
            GROUP BY s.faculty_code, s.faculty

            UNION ALL

            -- Course total (no question, excluding Humility and Service)
            SELECT 
                s.faculty_code,
                s.faculty,
                s.course,
                NULL AS question,
                SUM(CAST(s.answer AS DECIMAL(10,2))) AS obtained_score,
                COUNT(s.answer) * 5 AS max_score,
                ROUND(SUM(CAST(s.answer AS DECIMAL(10,2))) / (COUNT(s.answer) * 5) * 100, 2) AS percentage,
                'COURSE_TOTAL' AS row_type
            FROM surveys s
            WHERE s.faculty_code = ? 
              AND s.question <> 'Humility and Service'
            GROUP BY s.faculty_code, s.faculty, s.course

            UNION ALL

            -- Question-level detail (excluding Humility and Service)
            SELECT 
                s.faculty_code,
                s.faculty,
                s.course,
                s.question,
                SUM(CAST(s.answer AS DECIMAL(10,2))) AS obtained_score,
                COUNT(s.answer) * 5 AS max_score,
                ROUND(SUM(CAST(s.answer AS DECIMAL(10,2))) / (COUNT(s.answer) * 5) * 100, 2) AS percentage,
                'QUESTION_DETAIL' AS row_type
            FROM surveys s
            WHERE s.faculty_code = ? 
              AND s.question <> 'Humility and Service'
            GROUP BY s.faculty_code, s.faculty, s.course, s.question

            ORDER BY row_type DESC, course, question
        ", [$faculty_code, $faculty_code, $faculty_code]);

        return view('admin.survey_single_report', [
            'record' => collect($record),
            'faculty_code' => $faculty_code
        ]);
    }

    // 🔹 Download directly
    public function downloadPdf($faculty_code)
    {
        $record = DB::select("
            -- Overall Faculty Total (all courses combined, excluding Humility and Service)
            SELECT 
                s.faculty_code,
                s.faculty,
                NULL AS course,
                NULL AS question,
                SUM(CAST(s.answer AS DECIMAL(10,2))) AS obtained_score,
                COUNT(s.answer) * 5 AS max_score,
                ROUND(SUM(CAST(s.answer AS DECIMAL(10,2))) / (COUNT(s.answer) * 5) * 100, 2) AS percentage,
                'FACULTY_TOTAL' AS row_type
            FROM surveys s
            WHERE s.faculty_code = ? 
              AND s.question <> 'Humility and Service'
            GROUP BY s.faculty_code, s.faculty

            UNION ALL

            -- Course total (no question, excluding Humility and Service)
            SELECT 
                s.faculty_code,
                s.faculty,
                s.course,
                NULL AS question,
                SUM(CAST(s.answer AS DECIMAL(10,2))) AS obtained_score,
                COUNT(s.answer) * 5 AS max_score,
                ROUND(SUM(CAST(s.answer AS DECIMAL(10,2))) / (COUNT(s.answer) * 5) * 100, 2) AS percentage,
                'COURSE_TOTAL' AS row_type
            FROM surveys s
            WHERE s.faculty_code = ? 
              AND s.question <> 'Humility and Service'
            GROUP BY s.faculty_code, s.faculty, s.course

            UNION ALL

            -- Question-level detail (excluding Humility and Service)
            SELECT 
                s.faculty_code,
                s.faculty,
                s.course,
                s.question,
                SUM(CAST(s.answer AS DECIMAL(10,2))) AS obtained_score,
                COUNT(s.answer) * 5 AS max_score,
                ROUND(SUM(CAST(s.answer AS DECIMAL(10,2))) / (COUNT(s.answer) * 5) * 100, 2) AS percentage,
                'QUESTION_DETAIL' AS row_type
            FROM surveys s
            WHERE s.faculty_code = ? 
              AND s.question <> 'Humility and Service'
            GROUP BY s.faculty_code, s.faculty, s.course, s.question

            ORDER BY row_type DESC, course, question
        ", [$faculty_code, $faculty_code, $faculty_code]);

        $pdf = Pdf::loadView('admin.download_single_report_pdf', [
            'record' => $record,
            'faculty_code' => $faculty_code,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("Survey_Report_{$faculty_code}.pdf");
    }



}
