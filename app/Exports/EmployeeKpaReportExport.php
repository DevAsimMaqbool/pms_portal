<?php

namespace App\Exports;

use App\Models\User;
use App\Models\IndicatorsPercentage;
use App\Models\KeyPerformanceArea;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeKpaReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kpaList = [];
    protected $categoryList = [];
    protected $indicatorList = [];

    protected $assignments = [];
    protected $indicatorScores = [];
    protected $facultyTargets = [];
    protected $kpaWeights = [];

    /*
    |--------------------------------------------------------------------------
    | Achievement Counts
    |--------------------------------------------------------------------------
    |
    | Stored as:
    |
    | [
    |     user_id => [
    |         indicator_id => count
    |     ]
    | ]
    |
    |--------------------------------------------------------------------------
    */
    protected $achievementCounts = [];

    protected $facultyList = [];
    protected $departmentList = [];

    /*
    |--------------------------------------------------------------------------
    | Current PMS Year
    |--------------------------------------------------------------------------
    */
    protected $yearId = 1;

    public function __construct()
    {
        /*
        |--------------------------------------------------------------------------
        | KPA List
        |--------------------------------------------------------------------------
        */
        $this->kpaList = KeyPerformanceArea::query()
            ->pluck('performance_area', 'id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Faculty List
        |--------------------------------------------------------------------------
        */
        $this->facultyList = Faculty::query()
            ->pluck('name', 'id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Department List
        |--------------------------------------------------------------------------
        */
        $this->departmentList = Department::query()
            ->pluck('name', 'id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Indicator Categories
        |--------------------------------------------------------------------------
        */
        $this->categoryList = DB::table('indicator_categories')
            ->select(
                'id',
                'key_performance_area_id',
                'indicator_category'
            )
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Indicators
        |--------------------------------------------------------------------------
        */
        $this->indicatorList = DB::table('indicators')
            ->select(
                'id',
                'indicator_category_id',
                'indicator'
            )
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Role KPA Assignments + KPA Weightage
        |--------------------------------------------------------------------------
        */
        $assignments = DB::table('role_kpa_assignments')
            ->select(
                'id',
                'role_id',
                'user_id',
                'key_performance_area_id',
                'kpa_weightage',
                'indicator_category_id',
                'indicator_category_weightage',
                'indicator_id',
                'indicator_weightage',
                'form_status',
                'status'
            )
            ->whereIn('status', ['0', '1'])
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Build Assignment Map
        |--------------------------------------------------------------------------
        */
        foreach ($assignments as $assignment) {

            $roleId = (int) $assignment->role_id;

            $userId = $assignment->user_id !== null
                ? (int) $assignment->user_id
                : 0;

            $key = $roleId . '_' . $userId;

            if (!isset($this->assignments[$key])) {
                $this->assignments[$key] = [];
            }

            /*
            |--------------------------------------------------------------------------
            | Save KPA Weight
            |--------------------------------------------------------------------------
            */
            $kpaId = (int) $assignment->key_performance_area_id;

            if (
                !isset($this->kpaWeights[$roleId][$kpaId]) ||
                $assignment->kpa_weightage !== null
            ) {
                $this->kpaWeights[$roleId][$kpaId] =
                    (float) $assignment->kpa_weightage;
            }

            /*
            |--------------------------------------------------------------------------
            | Unique Indicator Assignment
            |--------------------------------------------------------------------------
            */
            $indicatorKey =
                $kpaId
                . '_'
                . (int) $assignment->indicator_category_id
                . '_'
                . (int) $assignment->indicator_id;

            $this->assignments[$key][$indicatorKey] = $assignment;
        }

        /*
        |--------------------------------------------------------------------------
        | Indicator Scores
        |--------------------------------------------------------------------------
        */
        $scores = IndicatorsPercentage::query()
            ->select(
                'employee_id',
                'role_id',
                'key_performance_area_id',
                'indicator_category_id',
                'indicator_id',
                'score',
                'with_out_weight_score',
                'rating',
                'color',
                'year_id'
            )
            ->where('year_id', $this->yearId)
            ->get();

        foreach ($scores as $score) {

            $key =
                $score->employee_id
                . '_'
                . $score->role_id
                . '_'
                . $score->key_performance_area_id
                . '_'
                . $score->indicator_category_id
                . '_'
                . $score->indicator_id;

            $this->indicatorScores[$key] = $score;
        }

        /*
        |--------------------------------------------------------------------------
        | Faculty Targets
        |--------------------------------------------------------------------------
        */
        $targets = DB::table('faculty_targets')
            ->select(
                'user_id',
                'indicator_id',
                'target',
                'year_id',
                'status'
            )
            ->where('year_id', $this->yearId)
            ->where('status', '1')
            ->get();

        foreach ($targets as $target) {

            $key =
                $target->user_id
                . '_'
                . $target->indicator_id;

            $this->facultyTargets[$key] = $target;
        }

        /*
        |--------------------------------------------------------------------------
        | Achievement Counts
        |--------------------------------------------------------------------------
        |
        | Achievement is calculated from created_by count.
        |
        | All these tables contain:
        | - indicator_id
        | - created_by
        | - year_id
        |
        |--------------------------------------------------------------------------
        */
        $this->loadAchievementCounts();
    }

    /*
    |--------------------------------------------------------------------------
    | Load Achievement Counts
    |--------------------------------------------------------------------------
    |
    | Preload all achievement counts so that no query is executed inside
    | map() for every user/indicator row.
    |
    |--------------------------------------------------------------------------
    */
    private function loadAchievementCounts()
    {
        /*
        |--------------------------------------------------------------------------
        | Research Publications
        |--------------------------------------------------------------------------
        */
        $publicationCounts = DB::table(
            'achievement_of_research_publications_target'
        )
            ->select(
                'created_by',
                'indicator_id',
                DB::raw('COUNT(*) as total')
            )
            ->where('year_id', $this->yearId)
            ->groupBy(
                'created_by',
                'indicator_id'
            )
            ->get();

        foreach ($publicationCounts as $row) {

            $this->achievementCounts[
                (int) $row->created_by
            ][
                (int) $row->indicator_id
            ] = (int) $row->total;
        }

        /*
        |--------------------------------------------------------------------------
        | Industrial Visits
        |--------------------------------------------------------------------------
        */
        $industrialVisitCounts = DB::table('industrial_visits')
            ->select(
                'created_by',
                'indicator_id',
                DB::raw('COUNT(*) as total')
            )
            ->where('year_id', $this->yearId)
            ->groupBy(
                'created_by',
                'indicator_id'
            )
            ->get();

        foreach ($industrialVisitCounts as $row) {

            $this->achievementCounts[
                (int) $row->created_by
            ][
                (int) $row->indicator_id
            ] = (int) $row->total;
        }

        /*
        |--------------------------------------------------------------------------
        | Number of Knowledge Products
        |--------------------------------------------------------------------------
        */
        $knowledgeProductCounts = DB::table(
            'number_of_knowledge_products'
        )
            ->select(
                'created_by',
                'indicator_id',
                DB::raw('COUNT(*) as total')
            )
            ->where('year_id', $this->yearId)
            ->groupBy(
                'created_by',
                'indicator_id'
            )
            ->get();

        foreach ($knowledgeProductCounts as $row) {

            $this->achievementCounts[
                (int) $row->created_by
            ][
                (int) $row->indicator_id
            ] = (int) $row->total;
        }

        /*
        |--------------------------------------------------------------------------
        | Multidisciplinary Projects
        |--------------------------------------------------------------------------
        */
        $multidisciplinaryProjectCounts = DB::table(
            'no_achievement_of_multidisciplinary_projects_targets'
        )
            ->select(
                'created_by',
                'indicator_id',
                DB::raw('COUNT(*) as total')
            )
            ->where('year_id', $this->yearId)
            ->groupBy(
                'created_by',
                'indicator_id'
            )
            ->get();

        foreach ($multidisciplinaryProjectCounts as $row) {

            $this->achievementCounts[
                (int) $row->created_by
            ][
                (int) $row->indicator_id
            ] = (int) $row->total;
        }

        /*
        |--------------------------------------------------------------------------
        | Grant Proposals Submitted / Won
        |--------------------------------------------------------------------------
        */
        $grantCounts = DB::table(
            'no_of_grants_submit_and_wons'
        )
            ->select(
                'created_by',
                'indicator_id',
                DB::raw('COUNT(*) as total')
            )
            ->where('year_id', $this->yearId)
            ->groupBy(
                'created_by',
                'indicator_id'
            )
            ->get();

        foreach ($grantCounts as $row) {

            $this->achievementCounts[
                (int) $row->created_by
            ][
                (int) $row->indicator_id
            ] = (int) $row->total;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Collection
    |--------------------------------------------------------------------------
    */
    public function collection()
    {
        return User::with([
            'roles',
            'facultyyy',
            'departmentttt'
        ])
            ->whereHas('roles')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Headings
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            'Role',
            'User Name',
            'Employee Code',
            'Designation',
            'Faculty',
            'Department',

            'Key Performance Area',
            'KPA Score',

            'Indicator Category',
            'Category Score',

            'Indicator',
            'Indicator Score',
            'Indicator Weight',

            'Target',
            'Achieved',

            'Indicator Rating',

            'Overall Score',
            'Overall Rating',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Map
    |--------------------------------------------------------------------------
    */
    public function map($user): array
    {
        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | Faculty
        |--------------------------------------------------------------------------
        */
        $facultyName =
            $this->facultyList[$user->faculty] ?? 'N/A';

        /*
        |--------------------------------------------------------------------------
        | Department
        |--------------------------------------------------------------------------
        */
        $departmentName =
            $this->departmentList[$user->department_id] ?? 'N/A';

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */
        foreach ($user->roles as $role) {

            $roleId = (int) $role->id;

            /*
            |--------------------------------------------------------------------------
            | User Specific Assignments
            |--------------------------------------------------------------------------
            */
            $userAssignmentKey =
                $roleId . '_' . $user->id;

            /*
            |--------------------------------------------------------------------------
            | Role Default Assignments
            |--------------------------------------------------------------------------
            */
            $roleAssignmentKey =
                $roleId . '_0';

            $userAssignments =
                $this->assignments[$userAssignmentKey] ?? [];

            $roleAssignments =
                $this->assignments[$roleAssignmentKey] ?? [];

            /*
            |--------------------------------------------------------------------------
            | Effective Assignments
            |--------------------------------------------------------------------------
            */
            $effectiveAssignments =
                $roleAssignments;

            foreach ($userAssignments as $indicatorKey => $assignment) {
                $effectiveAssignments[$indicatorKey] =
                    $assignment;
            }

            if (empty($effectiveAssignments)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Group By KPA → Category → Indicator
            |--------------------------------------------------------------------------
            */
            $kpaGroups = [];

            foreach ($effectiveAssignments as $assignment) {

                $kpaId =
                    (int) $assignment->key_performance_area_id;

                $categoryId =
                    (int) $assignment->indicator_category_id;

                $indicatorId =
                    (int) $assignment->indicator_id;

                $kpaGroups[$kpaId][$categoryId][$indicatorId] =
                    $assignment;
            }

            /*
            |--------------------------------------------------------------------------
            | KPA Raw + Weighted Totals
            |--------------------------------------------------------------------------
            */
            $kpaTotals = [];

            foreach ($kpaGroups as $kpaId => $categories) {

                $rawKpaScore = 0;

                foreach ($categories as $categoryId => $indicators) {

                    foreach ($indicators as $indicatorId => $assignment) {

                        $score =
                            $this->getIndicatorScore(
                                $user->id,
                                $roleId,
                                $kpaId,
                                $categoryId,
                                $indicatorId
                            );

                        $rawKpaScore += $score;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | KPA Weight
                |--------------------------------------------------------------------------
                */
                $kpaWeight =
                    $this->kpaWeights[$roleId][$kpaId]
                    ?? 0;

                /*
                |--------------------------------------------------------------------------
                | Weighted KPA Score
                |--------------------------------------------------------------------------
                */
                $weightedKpaScore =
                    $rawKpaScore * ($kpaWeight / 100);

                $kpaTotals[$kpaId] = [
                    'raw' =>
                        round($rawKpaScore, 2),

                    'weight' =>
                        $kpaWeight,

                    'weighted' =>
                        round($weightedKpaScore, 2),
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Overall Score
            |--------------------------------------------------------------------------
            |
            | Overall Score =
            | KPA1 Weighted + KPA2 Weighted + KPA3 Weighted ...
            |
            |--------------------------------------------------------------------------
            */
            $overallScore = 0;

            foreach ($kpaTotals as $kpaTotal) {
                $overallScore +=
                    (float) $kpaTotal['weighted'];
            }

            $overallScore =
                round($overallScore, 2);

            /*
            |--------------------------------------------------------------------------
            | Overall Rating
            |--------------------------------------------------------------------------
            */
            $overallRating =
                $this->calculateRating($overallScore);

            /*
            |--------------------------------------------------------------------------
            | Create Indicator Rows
            |--------------------------------------------------------------------------
            */
            $isFirstOverallRow = true;

            foreach ($kpaGroups as $kpaId => $categories) {

                $kpaName =
                    $this->kpaList[$kpaId] ?? 'N/A';

                /*
                |--------------------------------------------------------------------------
                | Weighted KPA Score
                |--------------------------------------------------------------------------
                */
                $kpaScore =
                    $kpaTotals[$kpaId]['weighted']
                    ?? 0;

                $isFirstKpaRow = true;

                foreach ($categories as $categoryId => $indicators) {

                    $categoryName =
                        $this->categoryList[$categoryId]
                            ->indicator_category
                        ?? 'N/A';

                    /*
                    |--------------------------------------------------------------------------
                    | Category Score
                    |--------------------------------------------------------------------------
                    */
                    $categoryScore = 0;

                    foreach ($indicators as $indicatorId => $assignment) {

                        $categoryScore +=
                            $this->getIndicatorScore(
                                $user->id,
                                $roleId,
                                $kpaId,
                                $categoryId,
                                $indicatorId
                            );
                    }

                    $categoryScore =
                        round($categoryScore, 2);

                    $isFirstCategoryRow = true;

                    foreach ($indicators as $indicatorId => $assignment) {

                        /*
                        |--------------------------------------------------------------------------
                        | Indicator
                        |--------------------------------------------------------------------------
                        */
                        $indicatorName =
                            $this->indicatorList[$indicatorId]
                                ->indicator
                            ?? 'N/A';

                        /*
                        |--------------------------------------------------------------------------
                        | Score Record
                        |--------------------------------------------------------------------------
                        */
                        $scoreRecord =
                            $this->getScoreRecord(
                                $user->id,
                                $roleId,
                                $kpaId,
                                $categoryId,
                                $indicatorId
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | Indicator Score
                        |--------------------------------------------------------------------------
                        */
                        $indicatorScore =
                            $scoreRecord
                                ? (float) $scoreRecord->score
                                : 0;

                        /*
                        |--------------------------------------------------------------------------
                        | Indicator Weight
                        |--------------------------------------------------------------------------
                        */
                        $indicatorWeight =
                            $assignment->indicator_weightage !== null
                                ? (float) $assignment->indicator_weightage
                                : null;

                        /*
                        |--------------------------------------------------------------------------
                        | Indicator Percentage
                        |--------------------------------------------------------------------------
                        */
                        $indicatorPercentage =
                            $this->calculateIndicatorPercentage(
                                $indicatorScore,
                                $indicatorWeight,
                                $scoreRecord
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | Indicator Rating
                        |--------------------------------------------------------------------------
                        */
                        $indicatorRating =
                            $this->calculateRating(
                                $indicatorPercentage
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | Target + Achievement
                        |--------------------------------------------------------------------------
                        */
                        $targetData =
                            $this->getTarget(
                                $user,
                                $indicatorId
                            );

                        $target =
                            $targetData['target'];

                        $achieved =
                            $targetData['achieved'];

                        /*
                        |--------------------------------------------------------------------------
                        | Achievement Percentage
                        |--------------------------------------------------------------------------
                        */
                        $achievementPercentage =
                            $this->calculateAchievementPercentage(
                                $target,
                                $achieved
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | KPA Values
                        |--------------------------------------------------------------------------
                        */
                        $displayKpaName =
                            $isFirstKpaRow
                                ? $kpaName
                                : '';

                        $displayKpaScore =
                            $isFirstKpaRow
                                ? $kpaScore
                                : '';

                        /*
                        |--------------------------------------------------------------------------
                        | Category Values
                        |--------------------------------------------------------------------------
                        */
                        $displayCategoryName =
                            $isFirstCategoryRow
                                ? $categoryName
                                : '';

                        $displayCategoryScore =
                            $isFirstCategoryRow
                                ? $categoryScore
                                : '';

                        /*
                        |--------------------------------------------------------------------------
                        | Overall Values
                        |--------------------------------------------------------------------------
                        */
                        $displayOverallScore =
                            $isFirstOverallRow
                                ? $overallScore
                                : '';

                        $displayOverallRating =
                            $isFirstOverallRow
                                ? $overallRating
                                : '';

                        /*
                        |--------------------------------------------------------------------------
                        | Add Row
                        |--------------------------------------------------------------------------
                        */
                        $rows[] = [

                            $role->name,

                            $user->name,

                            $user->employee_code
                                ?? $user->employee_id
                                ?? 'N/A',

                            $user->job_title
                                ?? 'N/A',

                            $facultyName,

                            $departmentName,

                            /*
                            |--------------------------------------------------------------------------
                            | KPA
                            |--------------------------------------------------------------------------
                            */
                            $displayKpaName,

                            $displayKpaScore,

                            /*
                            |--------------------------------------------------------------------------
                            | Category
                            |--------------------------------------------------------------------------
                            */
                            $displayCategoryName,

                            $displayCategoryScore,

                            /*
                            |--------------------------------------------------------------------------
                            | Indicator
                            |--------------------------------------------------------------------------
                            */
                            $indicatorName,

                            $indicatorScore,

                            $indicatorWeight,

                            /*
                            |--------------------------------------------------------------------------
                            | Target
                            |--------------------------------------------------------------------------
                            */
                            $target,

                            /*
                            |--------------------------------------------------------------------------
                            | Achieved
                            |--------------------------------------------------------------------------
                            */
                            $achieved,

                            /*
                            |--------------------------------------------------------------------------
                            | Achievement %
                            |--------------------------------------------------------------------------
                            */
                            
                            /*
                            |--------------------------------------------------------------------------
                            | Indicator Rating
                            |--------------------------------------------------------------------------
                            */
                            $indicatorRating,

                            /*
                            |--------------------------------------------------------------------------
                            | Overall Score
                            |--------------------------------------------------------------------------
                            */
                            $displayOverallScore,

                            /*
                            |--------------------------------------------------------------------------
                            | Overall Rating
                            |--------------------------------------------------------------------------
                            */
                            $displayOverallRating,
                        ];

                        $isFirstCategoryRow = false;
                        $isFirstKpaRow = false;
                        $isFirstOverallRow = false;
                    }
                }
            }
        }

        return $rows;
    }

    /*
    |--------------------------------------------------------------------------
    | Get Indicator Score
    |--------------------------------------------------------------------------
    */
    private function getIndicatorScore(
        $employeeId,
        $roleId,
        $kpaId,
        $categoryId,
        $indicatorId
    ): float {

        $record =
            $this->getScoreRecord(
                $employeeId,
                $roleId,
                $kpaId,
                $categoryId,
                $indicatorId
            );

        return $record
            ? (float) $record->score
            : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Get Score Record
    |--------------------------------------------------------------------------
    */
    private function getScoreRecord(
        $employeeId,
        $roleId,
        $kpaId,
        $categoryId,
        $indicatorId
    ) {

        $key =
            $employeeId
            . '_'
            . $roleId
            . '_'
            . $kpaId
            . '_'
            . $categoryId
            . '_'
            . $indicatorId;

        return $this->indicatorScores[$key] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | Calculate Indicator Percentage
    |--------------------------------------------------------------------------
    |
    | Indicator Score is already weighted.
    |
    | Example:
    |
    | Score  = 5.48
    | Weight = 6
    |
    | Percentage = 5.48 / 6 × 100 = 91.33%
    |
    |--------------------------------------------------------------------------
    */
    private function calculateIndicatorPercentage(
        $indicatorScore,
        $indicatorWeight,
        $scoreRecord = null
    ) {
        if (
            $indicatorWeight !== null &&
            (float) $indicatorWeight > 0
        ) {
            return round(
                ((float) $indicatorScore / (float) $indicatorWeight) * 100,
                2
            );
        }

        if ($scoreRecord) {
            return round(
                (float) $scoreRecord->with_out_weight_score,
                2
            );
        }

        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Get Target + Achievement
    |--------------------------------------------------------------------------
    */
    private function getTarget($user, $indicatorId): array
    {
        $key =
            $user->id
            . '_'
            . $indicatorId;

        $targetRecord =
            $this->facultyTargets[$key] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Target
        |--------------------------------------------------------------------------
        */
        $target =
            $targetRecord && $targetRecord->target !== null
                ? (float) $targetRecord->target
                : null;

        /*
        |--------------------------------------------------------------------------
        | Achievement
        |--------------------------------------------------------------------------
        |
        | For the specified indicators achievement comes from
        | COUNT(created_by) of the relevant table.
        |
        |--------------------------------------------------------------------------
        */
        $achieved =
            $this->getAchievementCount(
                $user->id,
                $indicatorId
            );

        return [
            'target' => $target,
            'achieved' => $achieved,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Get Achievement Count
    |--------------------------------------------------------------------------
    */
    private function getAchievementCount(
        $userId,
        $indicatorId
    ) {
        /*
        |--------------------------------------------------------------------------
        | If this indicator has an achievement table and records exist,
        | return the created_by count.
        |--------------------------------------------------------------------------
        */
        if (
            isset($this->achievementCounts[(int) $userId])
            &&
            array_key_exists(
                (int) $indicatorId,
                $this->achievementCounts[(int) $userId]
            )
        ) {
            return $this->achievementCounts[(int) $userId][(int) $indicatorId];
        }

        /*
        |--------------------------------------------------------------------------
        | No achievement source for this indicator
        |--------------------------------------------------------------------------
        |
        | Return NULL rather than 0 because NULL means that this indicator
        | does not have a configured achievement source.
        |
        |--------------------------------------------------------------------------
        */
        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Achievement Percentage
    |--------------------------------------------------------------------------
    */
    private function calculateAchievementPercentage(
        $target,
        $achieved
    ) {
        if (
            $target === null ||
            $achieved === null ||
            (float) $target <= 0
        ) {
            return null;
        }

        return round(
            ((float) $achieved / (float) $target) * 100,
            2
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */
    private function calculateRating($score)
    {
        $score = (float) $score;

        if ($score >= 90) {
            return 'OS';
        }

        if ($score >= 80) {
            return 'EE';
        }

        if ($score >= 70) {
            return 'ME';
        }

        if ($score >= 60) {
            return 'NI';
        }

        return 'BE';
    }
}
