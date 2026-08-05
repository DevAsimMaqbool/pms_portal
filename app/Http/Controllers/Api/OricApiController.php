<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTask;
use App\Models\IndicatorsPercentage;
use App\Models\User;
use App\Models\ActiveInternationalResearchPartner;
use App\Models\NoOfGrantsSubmitAndWon;
use App\Models\CommercialGainsCounsultancyResearchIncome;
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

    public function researchGrantsDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Queries
        |--------------------------------------------------------------------------
        */

        $grants = NoOfGrantsSubmitAndWon::query()
            ->whereIn('no_of_grants_submit_and_wons.status', [1, 2, 3]);

        $funding = CommercialGainsCounsultancyResearchIncome::query()
            ->where('commercial_gains_counsultancy_research_incomes.status', 2);

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        $applyFilter = function ($query, $column) use ($request) {

            switch ($request->filter) {

                case 'today':
                    $query->whereDate($column, Carbon::today());
                    break;

                case 'last_30_days':
                    $query->whereDate($column, '>=', Carbon::now()->subDays(30));
                    break;

                case 'quarter':
                    $query->whereDate($column, '>=', Carbon::now()->subMonths(3));
                    break;

                case 'last_six_months':
                    $query->whereDate($column, '>=', Carbon::now()->subMonths(6));
                    break;

                case 'last_one_year':
                    $query->whereDate($column, '>=', Carbon::now()->subYear());
                    break;

                case 'custom':

                    if ($request->filled('from_date') && $request->filled('to_date')) {

                        $query->whereBetween($column, [
                            Carbon::parse($request->from_date)->startOfDay(),
                            Carbon::parse($request->to_date)->endOfDay()
                        ]);

                    }

                    break;
            }

            return $query;

        };

        $applyFilter($grants, 'no_of_grants_submit_and_wons.created_at');
        $applyFilter($funding, 'commercial_gains_counsultancy_research_incomes.created_at');

        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $grantsSecured = (clone $grants)
            ->where('grant_status', 'Won')
            ->count();

        $submitted = (clone $grants)->count();

        $international = (clone $grants)
            ->where('grant_status', 'Won')
            ->where('is_international', 1)
            ->count();

        $successRate = $submitted > 0
            ? round(($grantsSecured / $submitted) * 100, 2)
            : 0;

        $totalFunding = (clone $funding)
            ->sum(DB::raw('CAST(consultancy_fee AS DECIMAL(18,2))'));

        /*
        |--------------------------------------------------------------------------
        | Industry Funded Research
        |--------------------------------------------------------------------------
        */

        $fundingSource = (clone $grants)
            ->where('grant_status', 'Won')
            ->select(
                'funding_agency',
                DB::raw('COUNT(*) as total_grants')
            )
            ->groupBy('funding_agency')
            ->orderByDesc('total_grants')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Funding Trend
        |--------------------------------------------------------------------------
        */

        $fundingTrend = (clone $funding)
            ->selectRaw("
            YEAR(created_at) year,
            SUM(CAST(consultancy_fee AS DECIMAL(18,2))) total_funding
        ")
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Faculty
        |--------------------------------------------------------------------------
        */

        $topFaculty = DB::table('users')
            ->leftJoin(
                'commercial_gains_counsultancy_research_incomes as c',
                function ($join) {

                    $join->on('users.id', '=', 'c.created_by')
                        ->where('c.status', 2);

                }
            )

            ->leftJoin(
                'no_of_grants_submit_and_wons as g',
                function ($join) {

                    $join->on('users.id', '=', 'g.created_by')
                        ->whereIn('g.status', [1, 2, 3])
                        ->where('g.grant_status', 'Won');

                }
            )

            ->select(
                'users.name',
                'users.department'
            )

            ->selectRaw("
            SUM(CAST(c.consultancy_fee AS DECIMAL(18,2))) total_funding,
            COUNT(DISTINCT g.id) no_of_grants,
            (SUM(CAST(c.consultancy_fee AS DECIMAL(18,2))) + COUNT(DISTINCT g.id)) total
        ")

            ->groupBy(
                'users.id',
                'users.name',
                'users.department'
            )

            ->orderByDesc('total_funding')

            ->limit(10)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = DB::table('users')

            ->leftJoin(
                'no_of_grants_submit_and_wons as g',
                'users.id',
                '=',
                'g.created_by'
            )

            ->leftJoin(
                'commercial_gains_counsultancy_research_incomes as c',
                'users.id',
                '=',
                'c.created_by'
            )

            ->select('users.department')

            ->selectRaw("

            COUNT(DISTINCT CASE
                WHEN g.grant_status='Won'
                THEN g.id END) no_of_grants,

            COUNT(DISTINCT CASE
                WHEN g.grant_status='Won'
                AND g.is_international=1
                THEN g.id END) international_grants,

            SUM(
                CASE
                WHEN c.status=2
                THEN CAST(c.consultancy_fee AS DECIMAL(18,2))
                ELSE 0 END
            ) total_funding,

            ROUND(

                COUNT(DISTINCT CASE
                WHEN g.grant_status='Won'
                THEN g.id END)

                /

                NULLIF(COUNT(DISTINCT g.id),0)

            *100,2) success_rate,

            (
                SUM(
                    CASE
                    WHEN c.status=2
                    THEN CAST(c.consultancy_fee AS DECIMAL(18,2))
                    ELSE 0 END
                )

                +

                COUNT(DISTINCT CASE
                WHEN g.grant_status='Won'
                THEN g.id END)

            ) total

        ")

            ->groupBy('users.department')

            ->orderBy('users.department')

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

                'research_grants_secured' => $grantsSecured,

                'total_funding_obtained' => $totalFunding,

                'international_grants' => $international,

                'grant_success_rate' => $successRate

            ],

            'industry_funded_research' => $fundingSource,

            'funding_trend_over_years' => $fundingTrend,

            'top_faculty' => $topFaculty,

            'department_wise_summary' => $departmentSummary

        ]);
    }

}
