<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTask;
use App\Models\IndicatorsPercentage;
use App\Models\User;
use App\Models\ActiveInternationalResearchPartner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OricApiController extends Controller
{

    public function researchPublicationDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = DB::table('achievement_of_research_publications_target as rpt')
            ->whereIn('rpt.status', ['1', '2', '3']);

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'today':
                $query->whereDate('rpt.created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subMonths(3));
                break;

            case 'last_six_months':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subMonths(6));
                break;

            case 'last_one_year':
                $query->whereDate('rpt.created_at', '>=', Carbon::now()->subYear());
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween('rpt.created_at', [
                        Carbon::parse($request->from_date)->startOfDay(),
                        Carbon::parse($request->to_date)->endOfDay()
                    ]);
                }

                break;

            case 'all_time':
            default:
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Cards
        |--------------------------------------------------------------------------
        */

        $totalPublications = (clone $query)->count();

        $facultyCount = (clone $query)
            ->distinct()
            ->count('rpt.created_by');

        $publicationPerFaculty = $facultyCount > 0
            ? round($totalPublications / $facultyCount, 2)
            : 0;

        // Placeholder
        $publicationPerPhdFaculty = 0;

        $hec = (clone $query)
            ->where('rpt.target_category', 'HEC')
            ->count();

        $scopus = (clone $query)
            ->where('rpt.target_category', 'Scopus-Indexed')
            ->count();

        $wos = (clone $query)
            ->where('rpt.target_category', 'WoS')
            ->count();

        $q1q2 = (clone $query)
            ->whereIn('rpt.journal_clasification', ['Q1', 'Q2'])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Trend Over Years
        |--------------------------------------------------------------------------
        */

        $trend = (clone $query)
            ->selectRaw("
            YEAR(rpt.created_at) as year,
            COUNT(*) as total
        ")
            ->groupBy(DB::raw('YEAR(rpt.created_at)'))
            ->orderBy('year')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Publication Category Distribution
        |--------------------------------------------------------------------------
        */

        $distribution = (clone $query)
            ->select(
                'rpt.target_category',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('rpt.target_category')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Faculty Members
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $query)
            ->join('users', 'users.id', '=', 'rpt.created_by')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(*) as total_publications')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_publications')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = (clone $query)
            ->join('users', 'users.id', '=', 'rpt.created_by')
            ->join('departments', 'departments.id', '=', 'users.department_id')

            ->select(
                'departments.id',
                'departments.name',

                DB::raw("SUM(CASE WHEN rpt.target_category='HEC' THEN 1 ELSE 0 END) as hec"),

                DB::raw("SUM(CASE WHEN rpt.target_category='Scopus-Indexed' THEN 1 ELSE 0 END) as scopus"),

                DB::raw("SUM(CASE WHEN rpt.target_category='WoS' THEN 1 ELSE 0 END) as wos"),

                DB::raw("SUM(CASE WHEN rpt.journal_clasification IN ('Q1','Q2') THEN 1 ELSE 0 END) as q1_q2"),

                DB::raw("COUNT(*) as total")
            )

            ->groupBy('departments.id', 'departments.name')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Researchers by Category
        |--------------------------------------------------------------------------
        */

        $topResearchers = (clone $query)
            ->join('users', 'users.id', '=', 'rpt.created_by')

            ->select(
                'users.id',
                'users.name',

                DB::raw("SUM(CASE WHEN rpt.target_category='HEC' THEN 1 ELSE 0 END) as hec"),

                DB::raw("SUM(CASE WHEN rpt.target_category='Scopus-Indexed' THEN 1 ELSE 0 END) as scopus"),

                DB::raw("SUM(CASE WHEN rpt.target_category='WoS' THEN 1 ELSE 0 END) as wos"),

                DB::raw("SUM(CASE WHEN rpt.journal_clasification IN ('Q1','Q2') THEN 1 ELSE 0 END) as q1_q2"),

                DB::raw("COUNT(*) as total")
            )

            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filter' => $request->filter ?? 'all_time',

            'data' => [

                'total_publications' => $totalPublications,

                'publication_per_faculty_member' => $publicationPerFaculty,

                'publication_per_phd_faculty_member' => $publicationPerPhdFaculty,

                'hec_indexed_publications' => $hec,

                'scopus_indexed_publications' => $scopus,

                'web_of_science_publications' => $wos,

                'q1_q2_publications' => $q1q2,

                'publication_trend' => $trend,

                'publication_category_distribution' => $distribution,

                'top_faculty_members' => $topFaculty,

                'department_summary' => $departmentSummary,

                'top_researchers_by_category' => $topResearchers,

            ]

        ]);
    }

    public function publicationMetrics(Request $request)
    {
        $request->validate([
            'doi' => 'required'
        ]);

        $metrics = getPublicationMetrics($request->doi);

        if (!$metrics || isset($metrics['error'])) {

            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch publication.'
            ], 404);
        }

        return response()->json([

            'success' => true,

            'data' => $metrics

        ]);
    }

    public function internationalCollaborations(Request $request)
    {
        $query = ActiveInternationalResearchPartner::query()
            ->whereIn('active_international_research_partners.status', [1, 2, 3]);

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'today':
                $query->whereDate('active_international_research_partners.created_at', Carbon::today());
                break;

            case 'last_30_days':
                $query->whereDate(
                    'active_international_research_partners.created_at',
                    '>=',
                    Carbon::now()->subDays(30)
                );
                break;

            case 'quarter':
                $query->whereDate(
                    'active_international_research_partners.created_at',
                    '>=',
                    Carbon::now()->subMonths(3)
                );
                break;

            case 'last_six_months':
                $query->whereDate(
                    'active_international_research_partners.created_at',
                    '>=',
                    Carbon::now()->subMonths(6)
                );
                break;

            case 'last_one_year':
                $query->whereDate(
                    'active_international_research_partners.created_at',
                    '>=',
                    Carbon::now()->subYear()
                );
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween(
                        'active_international_research_partners.created_at',
                        [
                            Carbon::parse($request->from_date)->startOfDay(),
                            Carbon::parse($request->to_date)->endOfDay()
                        ]
                    );

                }

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $summary = (clone $query)
            ->selectRaw('
            COUNT(*) as total_partnerships,
            SUM(target) as total_target,
            SUM(achieved_target) as total_achieved,
            AVG(achieved_target) as average_achievement
        ')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Progress %
        |--------------------------------------------------------------------------
        */

        $achievementPercentage = 0;

        if ($summary->total_target > 0) {

            $achievementPercentage = round(
                ($summary->total_achieved / $summary->total_target) * 100,
                2
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Department Wise
        |--------------------------------------------------------------------------
        */

        $departmentWise = (clone $query)
            ->join('users', 'users.id', '=', 'active_international_research_partners.created_by')
            ->select(
                'users.department'
            )
            ->selectRaw('
            COUNT(*) as total_partnerships,
            SUM(target) as total_target,
            SUM(achieved_target) as achieved_target
        ')
            ->groupBy('users.department')
            ->orderByDesc('total_partnerships')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Faculty
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $query)
            ->join('users', 'users.id', '=', 'active_international_research_partners.created_by')
            ->select(
                'users.name',
                'users.department'
            )
            ->selectRaw('
            COUNT(*) as partnerships,
            SUM(target) as total_target,
            SUM(achieved_target) as achieved_target
        ')
            ->groupBy(
                'users.id',
                'users.name',
                'users.department'
            )
            ->orderByDesc('partnerships')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Trend Over Years
        |--------------------------------------------------------------------------
        */

        $trend = (clone $query)
            ->selectRaw('
            YEAR(created_at) as year,
            COUNT(*) as partnerships,
            SUM(achieved_target) as achieved
        ')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Status Distribution
        |--------------------------------------------------------------------------
        */

        $statusDistribution = (clone $query)
            ->select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filter' => $request->filter ?? 'all_time',

            'summary' => [

                'total_partnerships' => (int) $summary->total_partnerships,

                'total_target' => (int) $summary->total_target,

                'total_achieved' => (int) $summary->total_achieved,

                'average_achievement' => round($summary->average_achievement ?? 0, 2),

                'achievement_percentage' => $achievementPercentage

            ],

            'department_wise_summary' => $departmentWise,

            'top_faculty' => $topFaculty,

            'trend_over_years' => $trend,

            'status_distribution' => $statusDistribution

        ]);
    }

}
