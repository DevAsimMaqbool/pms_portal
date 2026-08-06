<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeTask;
use App\Models\IndicatorsPercentage;
use App\Models\User;
use App\Models\ActiveInternationalResearchPartner;
use App\Models\NoOfGrantsSubmitAndWon;
use App\Models\CommercialGainsCounsultancyResearchIncome;
use App\Models\ProductsDeliveredToIndustry;
use App\Models\IntellectualProperty;
use App\Models\AchievementOfResearchPublicationTargetCoAuthor;
use App\Models\SpinOff;
use App\Models\IndustrialProjects;
use App\Models\StudentFeedback;
use App\Models\Employability;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\AlumniSatisfactionRate;
use App\Models\IndustrialVisit;
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

    public function innovationDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = ProductsDeliveredToIndustry::query()
            ->whereIn('products_delivered_to_industries.status', [1, 2, 3]);

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'today':
                $query->whereDate(
                    'products_delivered_to_industries.created_at',
                    Carbon::today()
                );
                break;

            case 'last_30_days':
                $query->whereDate(
                    'products_delivered_to_industries.created_at',
                    '>=',
                    Carbon::now()->subDays(30)
                );
                break;

            case 'quarter':
                $query->whereDate(
                    'products_delivered_to_industries.created_at',
                    '>=',
                    Carbon::now()->subMonths(3)
                );
                break;

            case 'last_six_months':
                $query->whereDate(
                    'products_delivered_to_industries.created_at',
                    '>=',
                    Carbon::now()->subMonths(6)
                );
                break;

            case 'last_one_year':
                $query->whereDate(
                    'products_delivered_to_industries.created_at',
                    '>=',
                    Carbon::now()->subYear()
                );
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween(
                        'products_delivered_to_industries.created_at',
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

        $innovationsDeveloped = (clone $query)->count();

        $prototypeCreated = (clone $query)
            ->where('product_developed', 'NO')
            ->count();

        $productDesignCompleted = (clone $query)
            ->where('product_developed', 'YES')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Innovation Type Distribution
        |--------------------------------------------------------------------------
        */

        $innovationDistribution = [
            [
                'type' => 'Innovations Developed',
                'total' => $innovationsDeveloped
            ],
            [
                'type' => 'Prototype Created',
                'total' => $prototypeCreated
            ],
            [
                'type' => 'Product Designs Completed',
                'total' => $productDesignCompleted
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | Top Faculty
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $query)

            ->join(
                'users',
                'users.id',
                '=',
                'products_delivered_to_industries.created_by'
            )

            ->select(
                'users.name',
                'users.department'
            )

            ->selectRaw("
            COUNT(products_delivered_to_industries.id) as total_projects
        ")

            ->groupBy(
                'users.id',
                'users.name',
                'users.department'
            )

            ->orderByDesc('total_projects')

            ->limit(10)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = (clone $query)

            ->join(
                'users',
                'users.id',
                '=',
                'products_delivered_to_industries.created_by'
            )

            ->select('users.department')

            ->selectRaw("

            COUNT(products_delivered_to_industries.id) as innovations_developed,

            SUM(
                CASE
                WHEN product_developed='NO'
                THEN 1
                ELSE 0
                END
            ) as prototype_created,

            SUM(
                CASE
                WHEN product_developed='YES'
                THEN 1
                ELSE 0
                END
            ) as product_design_completed,

            COUNT(products_delivered_to_industries.id) as total

        ")

            ->groupBy('users.department')

            ->orderBy('users.department')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Researcher
        |--------------------------------------------------------------------------
        */

        $topResearcher = (clone $query)

            ->join(
                'users',
                'users.id',
                '=',
                'products_delivered_to_industries.created_by'
            )

            ->select(
                'users.name',
                'users.department'
            )

            ->selectRaw("
            COUNT(products_delivered_to_industries.id) as total_projects
        ")

            ->groupBy(
                'users.id',
                'users.name',
                'users.department'
            )

            ->orderByDesc('total_projects')

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

            'summary' => [

                'innovations_developed' => $innovationsDeveloped,

                'prototype_created' => $prototypeCreated,

                'product_design_completed' => $productDesignCompleted,

            ],

            'innovation_type_distribution' => $innovationDistribution,

            'top_faculty_by_total_innovation' => $topFaculty,

            'department_wise_summary' => $departmentSummary,

            'top_researcher_by_innovation' => $topResearcher,

        ]);
    }

    public function patentDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = IntellectualProperty::query()
            ->whereIn('intellectual_properties.status', [1, 2, 3]);

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'today':
                $query->whereDate(
                    'intellectual_properties.created_at',
                    Carbon::today()
                );
                break;

            case 'last_30_days':
                $query->whereDate(
                    'intellectual_properties.created_at',
                    '>=',
                    Carbon::now()->subDays(30)
                );
                break;

            case 'quarter':
                $query->whereDate(
                    'intellectual_properties.created_at',
                    '>=',
                    Carbon::now()->subMonths(3)
                );
                break;

            case 'last_six_months':
                $query->whereDate(
                    'intellectual_properties.created_at',
                    '>=',
                    Carbon::now()->subMonths(6)
                );
                break;

            case 'last_one_year':
                $query->whereDate(
                    'intellectual_properties.created_at',
                    '>=',
                    Carbon::now()->subYear()
                );
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween(
                        'intellectual_properties.created_at',
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

        $patentFiled = (clone $query)->count();

        $patentGranted = (clone $query)
            ->where('intellectual_properties.status', 2)
            ->count();

        $copyright = (clone $query)
            ->whereRaw("LOWER(intellectual_properties.patents_ip_type)='copyright'")
            ->count();

        $trademark = (clone $query)
            ->whereRaw("LOWER(intellectual_properties.patents_ip_type)='trademark'")
            ->count();

        $softwareRegistration = 0;

        $licenceAgreement = 0;

        /*
        |--------------------------------------------------------------------------
        | Trend Over Years
        |--------------------------------------------------------------------------
        */

        $trendOverYears = (clone $query)
            ->selectRaw("
        YEAR(created_at) as year,

        COUNT(*) as patent_filed,

        SUM(CASE WHEN intellectual_properties.status=2 THEN 1 ELSE 0 END) as patent_granted,

        SUM(CASE WHEN LOWER(patents_ip_type)='copyright' THEN 1 ELSE 0 END) as copyright_registration,

        SUM(CASE WHEN LOWER(patents_ip_type)='trademark' THEN 1 ELSE 0 END) as trademark_registered
    ")
            ->groupByRaw("YEAR(created_at)")
            ->orderBy("year")
            ->get()
            ->map(function ($r) {

                return [

                    'year' => $r->year,

                    'patent_filed' => $r->patent_filed,

                    'patent_granted' => $r->patent_granted,

                    'copyright_registration' => $r->copyright_registration,

                    'trademarks_registered' => $r->trademark_registered,

                    'software_registration' => 0,

                    'licence_agreement' => 0

                ];

            });

        /*
    |--------------------------------------------------------------------------
    | year On Year Change
    |--------------------------------------------------------------------------
    */

        $yearOnYear = [];

        $previous = null;

        foreach ($trendOverYears as $row) {

            $current = [

                'year' => $row['year'],

                'patent_filed' => 0,

                'patent_granted' => 0,

                'copyright_registration' => 0,

                'trademarks_registered' => 0,

                'software_registration' => 0,

                'licence_agreement' => 0,

            ];

            if ($previous) {

                $current['patent_filed'] = $row['patent_filed'] - $previous['patent_filed'];

                $current['patent_granted'] = $row['patent_granted'] - $previous['patent_granted'];

                $current['copyright_registration'] = $row['copyright_registration'] - $previous['copyright_registration'];

                $current['trademarks_registered'] = $row['trademarks_registered'] - $previous['trademarks_registered'];

            }

            $yearOnYear[] = $current;

            $previous = $row;

        }

        /*
        |--------------------------------------------------------------------------
        | Innovation Type Distribution
        |--------------------------------------------------------------------------
        */

        $ipDistribution = [

            'Patent Filed' => $patentFiled,

            'Patent Granted' => $patentGranted,

            'Copyright Registration' => $copyright,

            'Trademarks Registered' => $trademark,

            'Software Registration' => 0,

            'Licence Agreement' => 0

        ];

        /*
        |--------------------------------------------------------------------------
        | Top Faculty
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $query)

            ->join('users', 'users.id', '=', 'intellectual_properties.created_by')

            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')

            ->selectRaw('

        users.name,

        departments.name as department,

        COUNT(*) total_ip

    ')

            ->groupBy('users.id', 'users.name', 'departments.name')

            ->orderByDesc('total_ip')

            ->limit(10)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = (clone $query)

            ->join('users', 'users.id', '=', 'intellectual_properties.created_by')

            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')

            ->selectRaw('

departments.name department,

COUNT(*) patent_filed,

SUM(CASE WHEN intellectual_properties.status=2 THEN 1 ELSE 0 END) patent_granted,

SUM(CASE WHEN LOWER(patents_ip_type)="copyright" THEN 1 ELSE 0 END) copyright_registration,

SUM(CASE WHEN LOWER(patents_ip_type)="trademark" THEN 1 ELSE 0 END) trademarks_registered

')

            ->groupBy('departments.name')

            ->get()

            ->map(function ($r) {

                return [

                    'department' => $r->department,

                    'Patent Filed' => $r->patent_filed,

                    'Patent Granted' => $r->patent_granted,

                    'Copyright Registration' => $r->copyright_registration,

                    'Trademarks Registered' => $r->trademarks_registered,

                    'Software Registration' => 0,

                    'Licence Agreement' => 0,

                    'total' => $r->patent_filed

                ];

            });

        /*
        |--------------------------------------------------------------------------
        | Top Researcher
        |--------------------------------------------------------------------------
        */

        $topResearcher = (clone $query)

            ->join('users', 'users.id', '=', 'intellectual_properties.created_by')

            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')

            ->selectRaw('

users.name,

departments.name department,

COUNT(*) total_ip

')

            ->groupBy(

                'users.id',

                'users.name',

                'departments.name'

            )

            ->orderByDesc('total_ip')

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

                'patent_filed' => $patentFiled,

                'patent_granted' => $patentGranted,

                'copyright_registration' => $copyright,

                'trademarks_registered' => $trademark,

                'software_registration' => $softwareRegistration,

                'licence_agreement' => $licenceAgreement,

                'trend_over_years' => $trendOverYears,

                'year_on_year_change' => $yearOnYear,

                'ip_asset_distribution' => $ipDistribution,

                'top_faculty' => $topFaculty,

                'department_summary' => $departmentSummary,

                'top_researcher' => $topResearcher

            ]

        ]);
    }

    public function spinOffDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = SpinOff::query()
            ->whereIn('spin_offs.status', [1, 2, 3]);

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'today':
                $query->whereDate(
                    'spin_offs.created_at',
                    Carbon::today()
                );
                break;

            case 'last_30_days':
                $query->whereDate(
                    'spin_offs.created_at',
                    '>=',
                    Carbon::now()->subDays(30)
                );
                break;

            case 'quarter':
                $query->whereDate(
                    'spin_offs.created_at',
                    '>=',
                    Carbon::now()->subMonths(3)
                );
                break;

            case 'last_six_months':
                $query->whereDate(
                    'spin_offs.created_at',
                    '>=',
                    Carbon::now()->subMonths(6)
                );
                break;

            case 'last_one_year':
                $query->whereDate(
                    'spin_offs.created_at',
                    '>=',
                    Carbon::now()->subYear()
                );
                break;

            case 'custom':

                if ($request->filled('from_date') && $request->filled('to_date')) {

                    $query->whereBetween(
                        'spin_offs.created_at',
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

        $spinOffCreated = (clone $query)
            ->where('spin_offs.status', 2)
            ->count();

        $technologyCommercialized = 0;

        $licensingRevenue = 0;

        $industryAdoption = 0;

        $startupFormation = 0;

        $technologyTransfer = 0;

        $commercializationSuccess = 0;

        /*
        |--------------------------------------------------------------------------
        | Trend Over Years
        |--------------------------------------------------------------------------
        */

        $trendOverYears = (clone $query)

            ->selectRaw('

        YEAR(spin_offs.created_at) year,

        SUM(CASE WHEN spin_offs.status=2 THEN 1 ELSE 0 END) spin_off_created

    ')

            ->groupByRaw('YEAR(spin_offs.created_at)')

            ->orderBy('year')

            ->get()

            ->map(function ($row) {

                return [

                    'year' => $row->year,

                    'technology_commercialized' => 0,

                    'licensing_revenue' => 0,

                    'industry_adoption_of_innovation' => 0,

                    'spin_off_companies_created' => $row->spin_off_created,

                    'startup_formation_from_research' => 0,

                    'technology_transfer_agreements' => 0

                ];

            });

        /*
    |--------------------------------------------------------------------------
    | year On Year Change
    |--------------------------------------------------------------------------
    */

        $yearOnYear = [];

        $previous = null;

        foreach ($trendOverYears as $row) {

            $current = [

                'year' => $row['year'],

                'technology_commercialized' => 0,

                'licensing_revenue' => 0,

                'industry_adoption_of_innovation' => 0,

                'spin_off_companies_created' => 0,

                'startup_formation_from_research' => 0,

                'technology_transfer_agreements' => 0,

                'commercialization_success' => 0

            ];

            if ($previous) {

                $current['spin_off_companies_created'] =
                    $row['spin_off_companies_created'] -
                    $previous['spin_off_companies_created'];

            }

            $yearOnYear[] = $current;

            $previous = $row;

        }

        /*
        |--------------------------------------------------------------------------
        | Innovation Type Distribution
        |--------------------------------------------------------------------------
        */

        $distribution = [

            'Technology Commercialized' => 0,

            'Licensing Revenue' => 0,

            'Industry Adoption of Innovation' => 0,

            'Spin Off Companies Created' => $spinOffCreated,

            'Startup Formation From Research' => 0,

            'Technology Transfer Agreements' => 0,

            'Commercialization Success' => 0

        ];

        /*
        |--------------------------------------------------------------------------
        | Top Faculty
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $query)

            ->join('users', 'users.id', '=', 'spin_offs.created_by')

            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')

            ->selectRaw('

users.name,

departments.name department,

SUM(CASE WHEN spin_offs.status=2 THEN 1 ELSE 0 END) spin_off_companies_created,

SUM(CASE WHEN spin_offs.status=2 THEN 1 ELSE 0 END) commercialization_score

')

            ->groupBy(

                'users.id',

                'users.name',

                'departments.name'

            )

            ->orderByDesc('commercialization_score')

            ->limit(10)

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = (clone $query)

            ->join('users', 'users.id', '=', 'spin_offs.created_by')

            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')

            ->selectRaw('

departments.name department,

SUM(CASE WHEN spin_offs.status=2 THEN 1 ELSE 0 END) spin_off_created

')

            ->groupBy('departments.name')

            ->get()

            ->map(function ($row) {

                return [

                    'department' => $row->department,

                    'Technology Commercialized' => 0,

                    'Licensing Revenue' => 0,

                    'Industry Adoption of Innovation' => 0,

                    'Spin Off Companies Created' => $row->spin_off_created,

                    'Startup Formation From Research' => 0,

                    'Technology Transfer Agreements' => 0,

                    'Commercialization Success' => 0

                ];

            });

        $topResearcher = (clone $query)

            ->join('users', 'users.id', '=', 'spin_offs.created_by')

            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')

            ->selectRaw('

users.name,

departments.name department,

0 licensing_revenue,

SUM(CASE WHEN spin_offs.status=2 THEN 1 ELSE 0 END) commercialization_score

')

            ->groupBy(

                'users.id',

                'users.name',

                'departments.name'

            )

            ->orderByDesc('commercialization_score')

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

                'technology_commercialized' => $technologyCommercialized,

                'licensing_revenue' => $licensingRevenue,

                'industry_adoption_of_innovation' => $industryAdoption,

                'spin_off_companies_created' => $spinOffCreated,

                'startup_formation_from_research' => $startupFormation,

                'technology_transfer_agreements' => $technologyTransfer,

                'commercialization_success_rate' => $commercializationSuccess,

                'trend_over_years' => $trendOverYears,

                'year_on_year_change' => $yearOnYear,

                'commercialization_output_distribution' => $distribution,

                'top_faculty' => $topFaculty,

                'department_summary' => $departmentSummary,

                'top_researcher' => $topResearcher

            ]

        ]);
    }
    private function applyDateFilter($query, Request $request)
    {
        switch ($request->filter) {

            case 'today':
                $query->whereDate('created_at', today());
                break;

            case 'last_30_days':
                $query->whereDate('created_at', '>=', now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate('created_at', '>=', now()->subMonths(3));
                break;

            case 'last_six_months':
                $query->whereDate('created_at', '>=', now()->subMonths(6));
                break;

            case 'last_one_year':
                $query->whereDate('created_at', '>=', now()->subYear());
                break;

            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($request->from_date)->startOfDay(),
                        Carbon::parse($request->to_date)->endOfDay(),
                    ]);
                }
                break;

            case 'all_time':
            default:
                break;
        }

        return $query;
    }
    public function industryProjectDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */
        $industryQuery = IndustrialProjects::query()
            ->where('industrial_projects.status', 2);

        $consultancyQuery = CommercialGainsCounsultancyResearchIncome::query()
            ->where('commercial_gains_counsultancy_research_incomes.status', 2);

        /*
        |--------------------------------------------------------------------------
        | Date Filters
        |--------------------------------------------------------------------------
        */

        $this->applyDateFilter($industryQuery, $request);
        $this->applyDateFilter($consultancyQuery, $request);

        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $industryCompleted = (clone $industryQuery)->count();

        $consultancyProjects = (clone $consultancyQuery)->count();

        /*
        |--------------------------------------------------------------------------
        | Trend Over Years
        |--------------------------------------------------------------------------
        */

        $industryTrend = (clone $industryQuery)
            ->selectRaw('YEAR(created_at) year, COUNT(*) total')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year');

        $consultancyTrend = (clone $consultancyQuery)
            ->selectRaw('YEAR(created_at) year, COUNT(*) total')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year');

        $years = collect($industryTrend->keys())
            ->merge($consultancyTrend->keys())
            ->unique()
            ->sort();

        $trend = [];

        foreach ($years as $year) {

            $trend[] = [
                'year' => $year,
                'industry_project_completed' => $industryTrend[$year] ?? 0,
                'consultancy_projects' => $consultancyTrend[$year] ?? 0,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Top Faculty
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $industryQuery)
            ->join('users', 'users.id', '=', 'industrial_projects.created_by')
            ->selectRaw("
        users.name,
        users.department,
        COUNT(*) industry_projects,
        0 impact_score
    ")
            ->groupBy('users.id', 'users.name', 'users.department')
            ->orderByDesc('industry_projects')
            ->limit(10)
            ->get();

        $consultancyFaculty = (clone $consultancyQuery)
            ->join('users', 'users.id', '=', 'commercial_gains_counsultancy_research_incomes.created_by')
            ->selectRaw("
        users.name,
        users.department,
        COUNT(*) consultancy_projects
    ")
            ->groupBy('users.id', 'users.name', 'users.department')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departments = User::select('department')
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        $departmentSummary = [];

        foreach ($departments as $department) {

            $industry = (clone $industryQuery)
                ->join('users', 'users.id', '=', 'industrial_projects.created_by')
                ->where('users.department', $department)
                ->count();

            $consultancy = (clone $consultancyQuery)
                ->join('users', 'users.id', '=', 'commercial_gains_counsultancy_research_incomes.created_by')
                ->where('users.department', $department)
                ->count();

            $departmentSummary[] = [

                'department' => $department,

                'industry_project_completed' => $industry,

                'consultancy_projects' => $consultancy,

            ];
        }

        /*
    |--------------------------------------------------------------------------
    | Top Researcher
    |--------------------------------------------------------------------------
    */

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'filter' => $request->filter ?? 'all_time',
            'data' => [

                'summary' => [
                    'industry_project_completed' => $industryCompleted,
                    'consultancy_projects' => $consultancyProjects,
                ],

                'trend_over_years' => $trend,

                'impact_distribution' => [
                    [
                        'name' => 'Industry Project Completed',
                        'value' => $industryCompleted,
                    ],
                    [
                        'name' => 'Consultancy Projects',
                        'value' => $consultancyProjects,
                    ]
                ],

                'top_faculty' => $topFaculty,

                'department_summary' => $departmentSummary,

                'top_researcher' => $topFaculty
            ]

        ]);
    }

    private function applyDateFilterNew($query, Request $request, $column = 'created_at')
    {
        switch ($request->filter) {

            case 'today':
                $query->whereDate($column, today());
                break;

            case 'last_30_days':
                $query->whereDate($column, '>=', now()->subDays(30));
                break;

            case 'quarter':
                $query->whereDate($column, '>=', now()->subMonths(3));
                break;

            case 'last_6_months':
                $query->whereDate($column, '>=', now()->subMonths(6));
                break;

            case 'last_1_year':
                $query->whereDate($column, '>=', now()->subYear());
                break;

            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $query->whereBetween($column, [
                        Carbon::parse($request->from_date)->startOfDay(),
                        Carbon::parse($request->to_date)->endOfDay(),
                    ]);
                }
                break;

            case 'all_time':
            default:
                break;
        }

        return $query;
    }

    public function activeResearchDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Research Query
        |--------------------------------------------------------------------------
        | Base Table:
        | achievement_of_research_publications_target_co_author
        */

        $researchQuery = AchievementOfResearchPublicationTargetCoAuthor::query()
            ->join(
                'users',
                'users.employee_id',
                '=',
                'achievement_of_research_publications_target_co_author.created_by'
            )
            ->whereNotNull('users.department_id');

        /*
        |--------------------------------------------------------------------------
        | Apply Date Filter
        |--------------------------------------------------------------------------
        */

        $this->applyDateFilterNew(
            $researchQuery,
            $request,
            'achievement_of_research_publications_target_co_author.created_at'
        );

        /*
        |--------------------------------------------------------------------------
        | Active Research Centers
        |--------------------------------------------------------------------------
        | Distinct Departments
        */

        $activeResearchCenters = (clone $researchQuery)
            ->distinct('users.department_id')
            ->count('users.department_id');

        /*
        |--------------------------------------------------------------------------
        | Active Research Faculty %
        |--------------------------------------------------------------------------
        */

        $totalFaculty = User::whereNotNull('faculty_id')->count();

        $activeFaculty = (clone $researchQuery)
            ->distinct(
                'achievement_of_research_publications_target_co_author.created_by'
            )
            ->count(
                'achievement_of_research_publications_target_co_author.created_by'
            );

        $activeResearchFacultyPercentage = $totalFaculty > 0
            ? round(($activeFaculty / $totalFaculty) * 100, 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Postgraduate Research Completion
        |--------------------------------------------------------------------------
        */

        $postGraduateResearch = (clone $researchQuery)
            ->where(
                'achievement_of_research_publications_target_co_author.career',
                'PG'
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | International Research Collaborations
        |--------------------------------------------------------------------------
        */

        $internationalQuery = ActiveInternationalResearchPartner::query()
            ->where('status', 2);

        $this->applyDateFilterNew(
            $internationalQuery,
            $request,
            'created_at'
        );

        $internationalResearchCollaborations = (clone $internationalQuery)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Total Research Records
        |--------------------------------------------------------------------------
        */

        $totalResearchRecords = (clone $researchQuery)->count();

        /*
    |--------------------------------------------------------------------------
    | Total Research Records
    |--------------------------------------------------------------------------
    */

        $totalResearchRecords = (clone $researchQuery)->count();

        /*
        |--------------------------------------------------------------------------
        | Top Faculty by Research
        |--------------------------------------------------------------------------
        |
        | Base Table:
        | achievement_of_research_publications_target_co_author
        |
        | Join:
        | users.employee_id = co_author.created_by
        |
        |--------------------------------------------------------------------------
        */

        $topFaculty = (clone $researchQuery)

            ->select(
                'users.employee_id',
                'users.name',
                'users.department',
                DB::raw('COUNT(*) as total_research')
            )

            ->groupBy(
                'users.employee_id',
                'users.name',
                'users.department'
            )

            ->orderByDesc('total_research')

            ->get()

            ->map(function ($faculty) use ($totalResearchRecords) {

                return [

                    'employee_id' => $faculty->employee_id,

                    'faculty_name' => $faculty->name,

                    'department' => $faculty->department,

                    'total_research' => (int) $faculty->total_research,

                    'research_percentage' => $totalResearchRecords > 0
                        ? round(($faculty->total_research / $totalResearchRecords) * 100, 2)
                        : 0,

                ];

            });

        /*
        |--------------------------------------------------------------------------
        | Top 10 Faculties (Optional)
        |--------------------------------------------------------------------------
        */

        $topFaculty = $topFaculty->take(10)->values();
        /*
        |--------------------------------------------------------------------------
        | Department Wise Summary
        |--------------------------------------------------------------------------
        */

        $departments = User::select('department_id', 'department')
            ->whereNotNull('department_id')
            ->distinct()
            ->orderBy('department')
            ->get();

        $departmentSummary = $departments->map(function ($department) use ($researchQuery, $internationalQuery) {

            // Employees of current department
            $employeeIds = User::where('department_id', $department->department_id)
                ->pluck('employee_id');

            /*
            |--------------------------------------------------------------------------
            | Active Research Centers
            |--------------------------------------------------------------------------
            | Distinct faculty/researchers in this department
            */

            $activeResearchCenters = (clone $researchQuery)
                ->whereIn(
                    'achievement_of_research_publications_target_co_author.created_by',
                    $employeeIds
                )
                ->distinct(
                    'achievement_of_research_publications_target_co_author.created_by'
                )
                ->count(
                    'achievement_of_research_publications_target_co_author.created_by'
                );

            /*
            |--------------------------------------------------------------------------
            | Faculty Percentage
            |--------------------------------------------------------------------------
            */

            $departmentFaculty = User::where('department_id', $department->department_id)
                ->whereNotNull('faculty_id')
                ->count();

            $activeFaculty = (clone $researchQuery)
                ->whereIn(
                    'achievement_of_research_publications_target_co_author.created_by',
                    $employeeIds
                )
                ->distinct(
                    'achievement_of_research_publications_target_co_author.created_by'
                )
                ->count(
                    'achievement_of_research_publications_target_co_author.created_by'
                );

            $facultyPercentage = $departmentFaculty > 0
                ? round(($activeFaculty / $departmentFaculty) * 100, 2)
                : 0;

            /*
            |--------------------------------------------------------------------------
            | Postgraduate Research
            |--------------------------------------------------------------------------
            */

            $pgResearch = (clone $researchQuery)
                ->whereIn(
                    'achievement_of_research_publications_target_co_author.created_by',
                    $employeeIds
                )
                ->where(
                    'achievement_of_research_publications_target_co_author.career',
                    'PG'
                )
                ->count();

            /*
            |--------------------------------------------------------------------------
            | International Collaborations
            |--------------------------------------------------------------------------
            */

            $international = (clone $internationalQuery)
                ->whereIn(
                    'active_international_research_partners.created_by',
                    $employeeIds
                )
                ->count();

            return [

                'department_id' => $department->department_id,

                'department_name' => $department->department,

                'active_research_centers' => $activeResearchCenters,

                'active_research_faculty_percentage' => $facultyPercentage,

                'postgraduate_research_completion' => $pgResearch,

                'international_research_collaborations' => $international,

            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Final Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filters' => [

                'filter' => $request->filter ?? 'all_time',

                'from_date' => $request->from_date,

                'to_date' => $request->to_date,

            ],

            'data' => [

                'summary_cards' => [

                    'active_research_centers' => $activeResearchCenters,

                    'active_research_faculty_percentage' => $activeResearchFacultyPercentage,

                    'postgraduate_research_completion' => $postGraduateResearch,

                    'international_research_collaborations' => $internationalResearchCollaborations,

                ],

                'top_faculty_by_research' => $topFaculty,

                'department_summary' => $departmentSummary,

            ],

        ]);
    }

    public function studentResearchDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Publications By MS Students
        |--------------------------------------------------------------------------
        */

        $msStudentsQuery = AchievementOfResearchPublicationTargetCoAuthor::query()
            ->where('your_role', 'Student')
            ->where('career', 'MS');

        $this->applyDateFilterNew(
            $msStudentsQuery,
            $request,
            'achievement_of_research_publications_target_co_author.created_at'
        );

        $publicationsByMSStudents = (clone $msStudentsQuery)
            ->whereNotNull('student_roll_no')
            ->distinct('student_roll_no')
            ->count('student_roll_no');

        /*
        |--------------------------------------------------------------------------
        | Student Satisfaction
        |--------------------------------------------------------------------------
        */

        $feedbackQuery = StudentFeedback::query();

        // Apply only if created_at exists
        // $this->applyDateFilter($feedbackQuery,$request,'created_at');

        $studentSatisfactionScore = round(
            (clone $feedbackQuery)
                ->selectRaw("
                AVG(
                    CAST(REPLACE(overall,'%','') AS DECIMAL(10,2))
                ) as avg_score
            ")
                ->value('avg_score'),
            2
        );

        return response()->json([

            'success' => true,

            'filters' => [

                'filter' => $request->filter ?? 'all_time',

                'from_date' => $request->from_date,

                'to_date' => $request->to_date,

            ],

            'data' => [

                'summary_cards' => [

                    'publications_by_ms_students' => $publicationsByMSStudents,

                    'student_satisfaction_score' => $studentSatisfactionScore,

                ]

            ]

        ]);
    }

    public function employabilityDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = Employability::query();

        $this->applyDateFilterNew(
            $query,
            $request,
            'employabilities.created_at'
        );

        /*
        |--------------------------------------------------------------------------
        | Employer Satisfaction Score
        |--------------------------------------------------------------------------
        */

        $employerSatisfactionScore = round(
            (clone $query)
                ->whereNotNull('employer_satisfaction')
                ->avg('employer_satisfaction'),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Job Placements
        |--------------------------------------------------------------------------
        */

        $totalGraduates = (clone $query)->count();

        $jobPlacements = (clone $query)
            ->whereNotNull('date_of_appointment')
            ->count();

        $jobPlacementPercentage = $totalGraduates > 0
            ? round(($jobPlacements / $totalGraduates) * 100, 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Faculty Summary
        |--------------------------------------------------------------------------
        */

        $facultySummary = Faculty::orderBy('name')
            ->get()
            ->map(function ($faculty) use ($query) {

                $facultyQuery = (clone $query)
                    ->where('faculty_id', $faculty->id);

                $total = (clone $facultyQuery)->count();

                $placements = (clone $facultyQuery)
                    ->whereNotNull('date_of_appointment')
                    ->count();

                return [

                    'faculty_id' => $faculty->id,

                    'faculty_name' => $faculty->name,

                    'employer_satisfaction_score' => round(
                        (clone $facultyQuery)
                            ->whereNotNull('employer_satisfaction')
                            ->avg('employer_satisfaction'),
                        2
                    ),

                    'job_placements' => $placements,

                    'job_placement_percentage' => $total > 0
                        ? round(($placements / $total) * 100, 2)
                        : 0,

                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Department Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = Department::orderBy('name')
            ->get()
            ->map(function ($department) use ($query) {

                $departmentQuery = (clone $query)
                    ->where('department_id', $department->id);

                $total = (clone $departmentQuery)->count();

                $placements = (clone $departmentQuery)
                    ->whereNotNull('date_of_appointment')
                    ->count();

                return [

                    'department_id' => $department->id,

                    'department_name' => $department->name,

                    'job_placements' => $placements,

                    'job_placement_percentage' => $total > 0
                        ? round(($placements / $total) * 100, 2)
                        : 0,

                    'employer_satisfaction_score' => round(
                        (clone $departmentQuery)
                            ->whereNotNull('employer_satisfaction')
                            ->avg('employer_satisfaction'),
                        2
                    ),

                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filters' => [

                'filter' => $request->filter ?? 'all_time',

                'from_date' => $request->from_date,

                'to_date' => $request->to_date,

            ],

            'data' => [

                'summary_cards' => [

                    'employer_satisfaction_score' => $employerSatisfactionScore,

                    'job_placements' => $jobPlacements,

                    'job_placement_percentage' => $jobPlacementPercentage,

                ],

                'faculty_summary' => $facultySummary,

                'department_summary' => $departmentSummary,

            ],

        ]);
    }

    public function alumniSatisfactionDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = AlumniSatisfactionRate::query()
            ->whereNotNull('satisfaction_rate');

        $this->applyDateFilter($query, $request);

        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $avgPercentage = (clone $query)->avg('satisfaction_rate');

        $alumniSatisfactionScore = $avgPercentage
            ? round(($avgPercentage / 100) * 5, 2)
            : 0;

        $surveyResponses = (clone $query)->count();

        /*
        |--------------------------------------------------------------------------
        | Faculty Wise Summary
        |--------------------------------------------------------------------------
        */

        $faculties = Faculty::orderBy('name')->get();

        $facultySummary = $faculties->map(function ($faculty) use ($query) {

            $facultyQuery = (clone $query)
                ->where('faculty_id', $faculty->id);

            $avg = $facultyQuery->avg('satisfaction_rate');

            return [

                'faculty_name' => $faculty->name,

                'alumni_satisfaction_score' => $avg
                    ? round(($avg / 100) * 5, 2)
                    : 0,

                'alumni_survey_response' => (clone $facultyQuery)->count(),

            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Department Wise Summary
        |--------------------------------------------------------------------------
        */

        $departments = Department::orderBy('department_name')->get();

        $departmentSummary = $departments->map(function ($department) use ($query) {

            $departmentQuery = (clone $query)
                ->where('department_id', $department->id);

            $avg = $departmentQuery->avg('satisfaction_rate');

            return [

                'department_name' => $department->department_name,

                'alumni_satisfaction_score' => $avg
                    ? round(($avg / 100) * 5, 2)
                    : 0,

                'alumni_survey_response' => (clone $departmentQuery)->count(),

            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filters' => [

                'filter' => $request->filter ?? 'all_time',

                'from_date' => $request->from_date,

                'to_date' => $request->to_date,

            ],

            'data' => [

                'summary_cards' => [

                    'alumni_satisfaction_score' => $alumniSatisfactionScore,

                    'alumni_survey_response' => $surveyResponses,

                ],

                'faculty_summary' => $facultySummary,

                'department_summary' => $departmentSummary,

            ],

        ]);
    }

    public function industryVisitsDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = IndustrialVisit::query();

        $this->applyDateFilter($query, $request);

        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $industryVisits = (clone $query)->count();

        /*
        |--------------------------------------------------------------------------
        | Engagement Activities Distribution
        |--------------------------------------------------------------------------
        */

        $engagementActivities = (clone $query)
            ->select(
                'visit_category',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('visit_category')
            ->orderBy('visit_category')
            ->get()
            ->map(function ($row) use ($industryVisits) {

                return [

                    'visit_category' => $row->visit_category,

                    'count' => (int) $row->total,

                    'percentage' => $industryVisits > 0
                        ? round(($row->total / $industryVisits) * 100, 2)
                        : 0,

                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Faculty Wise Summary
        |--------------------------------------------------------------------------
        */

        $faculties = Faculty::orderBy('name')->get();

        $facultySummary = $faculties->map(function ($faculty) use ($query) {

            $employeeIds = DB::table('users')
                ->where('faculty_id', $faculty->id)
                ->pluck('employee_id');

            $visits = (clone $query)
                ->whereIn('created_by', $employeeIds)
                ->count();

            return [

                'faculty_name' => $faculty->name,

                'industry_visits' => $visits,

            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Department Wise Summary
        |--------------------------------------------------------------------------
        */

        $departments = Department::orderBy('department_name')->get();

        $departmentSummary = $departments->map(function ($department) use ($query) {

            $employeeIds = DB::table('users')
                ->where('department_id', $department->id)
                ->pluck('employee_id');

            $visits = (clone $query)
                ->whereIn('created_by', $employeeIds)
                ->count();

            return [

                'department_name' => $department->department_name,

                'industry_visits' => $visits,

            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'filters' => [

                'filter' => $request->filter ?? 'all_time',

                'from_date' => $request->from_date,

                'to_date' => $request->to_date,

            ],

            'data' => [

                'summary_cards' => [

                    'industry_visits' => $industryVisits,

                ],

                'engagement_activities_distribution' => $engagementActivities,

                'faculty_summary' => $facultySummary,

                'department_summary' => $departmentSummary,

            ],

        ]);
    }

    public function industryCollaborationDashboard(Request $request)
    {
        $industryProjectsQuery = IndustrialProjects::query()
            ->whereIn('status', ['1', '2', '3', '4', '5', '6']);

        $consultancyProjectsQuery = CommercialGainsCounsultancyResearchIncome::query()
            ->where('status', '2');

        $this->applyDateFilterNew($industryProjectsQuery, $request, 'industrial_projects.created_at');
        $this->applyDateFilterNew($consultancyProjectsQuery, $request, 'commercial_gains_counsultancy_research_incomes.created_at');

        $industryFundedProjects = (clone $industryProjectsQuery)->count();
        $jointResearchProjects = $industryFundedProjects; // same table currently
        $consultancyProjects = (clone $consultancyProjectsQuery)->count();
        $appliedResearchInitiatives = $industryFundedProjects + $jointResearchProjects + $consultancyProjects;

        $distribution = [
            ['type' => 'Industry Funded Projects', 'count' => $industryFundedProjects],
            ['type' => 'Joint Research Projects', 'count' => $jointResearchProjects],
            ['type' => 'Consultancy Projects', 'count' => $consultancyProjects],
            ['type' => 'Applied Research Initiatives', 'count' => $appliedResearchInitiatives],
        ];

        $facultySummary = $this->buildGroupedCollaborationSummary(
            $request,
            groupColumn: 'faculty_id',
            joinTable: 'faculties',
            joinOnColumn: 'faculties.id',
            nameColumn: 'faculties.name',
            idKey: 'faculty_id',
            nameKey: 'faculty_name'
        );

        $departmentSummary = $this->buildGroupedCollaborationSummary(
            $request,
            groupColumn: 'department_id',
            joinTable: 'departments',
            joinOnColumn: 'departments.id',
            nameColumn: 'departments.name',
            idKey: 'department_id',
            nameKey: 'department_name'
        );

        return response()->json([
            'success' => true,
            'summary_cards' => [
                'industry_funded_projects' => (int) $industryFundedProjects,
                'joint_research_projects' => (int) $jointResearchProjects,
                'consultancy_projects' => (int) $consultancyProjects,
                'applied_research_initiatives' => (int) $appliedResearchInitiatives,
            ],
            'distribution_by_project_type' => $distribution,
            'faculty_wise_summary' => $facultySummary,
            'department_wise_summary' => $departmentSummary,
        ]);
    }

    /**
     * Build a faculty- or department-wise collaboration summary.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function buildGroupedCollaborationSummary(
        Request $request,
        string $groupColumn,
        string $joinTable,
        string $joinOnColumn,
        string $nameColumn,
        string $idKey,
        string $nameKey
    ): \Illuminate\Support\Collection {
        $industryRows = $this->groupedIndustryProjects(
            $request,
            $groupColumn,
            $joinTable,
            $joinOnColumn,
            $nameColumn
        );

        $consultancyRows = $this->groupedConsultancyProjects(
            $request,
            $groupColumn,
            $joinTable,
            $joinOnColumn,
            $nameColumn
        );

        $ids = collect($industryRows->keys())
            ->merge($consultancyRows->keys())
            ->unique()
            ->values();

        $summary = $ids->map(function ($id) use ($industryRows, $consultancyRows, $idKey, $nameKey, $nameColumn) {
            $industryRow = $industryRows->get($id);
            $consultancyRow = $consultancyRows->get($id);

            $industry = (int) (optional($industryRow)->industry_funded_projects ?? 0);
            $joint = $industry; // currently same source
            $consultancy = (int) (optional($consultancyRow)->consultancy_projects ?? 0);
            $applied = $industry + $joint + $consultancy;

            $nameField = last(explode('.', $nameColumn));

            return [
                $idKey => $id,
                $nameKey => optional($industryRow)->{$nameField}
                    ?? optional($consultancyRow)->{$nameField}
                    ?? 'N/A',
                'industry_funded_projects' => $industry,
                'joint_research_projects' => $joint,
                'consultancy_projects' => $consultancy,
                'applied_research_initiatives' => $applied,
                'total' => $applied,
            ];
        });

        return $summary->sortByDesc('total')->values();
    }

    /**
     * @return \Illuminate\Support\Collection<int|string, object>
     */
    private function groupedIndustryProjects(
        Request $request,
        string $groupColumn,
        string $joinTable,
        string $joinOnColumn,
        string $nameColumn
    ): \Illuminate\Support\Collection {
        $query = IndustrialProjects::query()
            ->join('users', 'users.employee_id', '=', 'industrial_projects.created_by')
            ->join($joinTable, $joinOnColumn, '=', "users.{$groupColumn}")
            ->select(
                "users.{$groupColumn}",
                DB::raw("{$nameColumn} as " . last(explode('.', $nameColumn))),
                DB::raw('COUNT(industrial_projects.id) as industry_funded_projects')
            )
            ->whereIn('industrial_projects.status', ['1', '2', '3', '4', '5', '6'])
            ->groupBy("users.{$groupColumn}", $nameColumn);

        $this->applyDateFilterNew($query, $request, 'industrial_projects.created_at');

        return $query->get()->keyBy($groupColumn);
    }

    /**
     * @return \Illuminate\Support\Collection<int|string, object>
     */
    private function groupedConsultancyProjects(
        Request $request,
        string $groupColumn,
        string $joinTable,
        string $joinOnColumn,
        string $nameColumn
    ): \Illuminate\Support\Collection {
        $query = CommercialGainsCounsultancyResearchIncome::query()
            ->join('users', 'users.employee_id', '=', 'commercial_gains_counsultancy_research_incomes.created_by')
            ->join($joinTable, $joinOnColumn, '=', "users.{$groupColumn}")
            ->select(
                "users.{$groupColumn}",
                DB::raw("{$nameColumn} as " . last(explode('.', $nameColumn))),
                DB::raw('COUNT(commercial_gains_counsultancy_research_incomes.id) as consultancy_projects')
            )
            ->where('commercial_gains_counsultancy_research_incomes.status', '2')
            ->groupBy("users.{$groupColumn}", $nameColumn);

        $this->applyDateFilterNew($query, $request, 'commercial_gains_counsultancy_research_incomes.created_at');

        return $query->get()->keyBy($groupColumn);
    }

    public function activeInternationalResearchPartnershipDashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = ActiveInternationalResearchPartner::query()
            ->where('status', '2');

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        $this->applyDateFilterNew(
            $query,
            $request,
            'active_international_research_partners.created_at'
        );

        /*
        |--------------------------------------------------------------------------
        | Summary Card
        |--------------------------------------------------------------------------
        */

        $activeInternationalResearchPartnerships = (clone $query)->count();

        /*
        |--------------------------------------------------------------------------
        | Faculty Wise Summary
        |--------------------------------------------------------------------------
        */

        $facultySummary = ActiveInternationalResearchPartner::query()
            ->join(
                'users',
                'users.employee_id',
                '=',
                'active_international_research_partners.created_by'
            )
            ->join(
                'faculties',
                'faculties.id',
                '=',
                'users.faculty_id'
            )
            ->select(
                'users.faculty_id',
                'faculties.name as faculty_name',
                DB::raw('COUNT(active_international_research_partners.id) as active_international_research_partnerships')
            )
            ->where('active_international_research_partners.status', '2')
            ->groupBy(
                'users.faculty_id',
                'faculties.name'
            );

        $this->applyDateFilterNew(
            $facultySummary,
            $request,
            'active_international_research_partners.created_at'
        );

        $facultySummary = $facultySummary
            ->orderByDesc('active_international_research_partnerships')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Department Wise Summary
        |--------------------------------------------------------------------------
        */

        $departmentSummary = ActiveInternationalResearchPartner::query()
            ->join(
                'users',
                'users.employee_id',
                '=',
                'active_international_research_partners.created_by'
            )
            ->join(
                'departments',
                'departments.id',
                '=',
                'users.department_id'
            )
            ->select(
                'users.department_id',
                'departments.name',
                DB::raw('COUNT(active_international_research_partners.id) as active_international_research_partnerships')
            )
            ->where('active_international_research_partners.status', '2')
            ->groupBy(
                'users.department_id',
                'departments.name'
            );

        $this->applyDateFilterNew(
            $departmentSummary,
            $request,
            'active_international_research_partners.created_at'
        );

        $departmentSummary = $departmentSummary
            ->orderByDesc('active_international_research_partnerships')
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
                'summary_cards' => [
                    'active_international_research_partnerships' => (int) $activeInternationalResearchPartnerships,
                ],

                'faculty_wise_summary' => $facultySummary,

                'department_wise_summary' => $departmentSummary,
            ]

        ]);
    }

}
