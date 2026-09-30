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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EmployeeKpaReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents
{
    protected $kpaList = [];
    protected $categoryList = [];
    protected $indicatorList = [];

    protected $assignments = [];
    protected $indicatorScores = [];
    protected $facultyTargets = [];
    protected $kpaWeights = [];

    protected $achievementCounts = [];

    protected $facultyList = [];
    protected $departmentList = [];

    protected $employeesWithScores = [];

    protected $mergeRanges = [];

    protected $currentExcelRow = 2;

    protected $yearId = 1;

    /*
    |--------------------------------------------------------------------------
    | Selected Report Filters
    |--------------------------------------------------------------------------
    */
    protected $selectedRole = null;
    protected $selectedFacultyId = null;
    protected $selectedDepartmentId = null;
    protected $selectedProgramId = null;

    public function __construct(
        $role = null,
        $facultyId = null,
        $departmentId = null,
        $programId = null
    ) {
        $this->selectedRole = $role;
        $this->selectedFacultyId = $facultyId;
        $this->selectedDepartmentId = $departmentId;
        $this->selectedProgramId = $programId;
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
        | Role KPA Assignments
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
            | KPA Weight
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
            | Indicator Assignment
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

            /*
            |--------------------------------------------------------------------------
            | Employee Has Score
            |--------------------------------------------------------------------------
            |
            | Used only for sorting.
            | Calculation logic is not changed.
            |--------------------------------------------------------------------------
            */
            if ($score->score !== null && $score->score !== '' && (float) $score->score > 0) 
            {
                $this->employeesWithScores[
                    (int) $score->employee_id
                ] = true;
            }
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
        */
        $this->loadAchievementCounts();
    }

    /*
    |--------------------------------------------------------------------------
    | Load Achievement Counts
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
        | Grant Proposals
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
|
| Employees having scores are shown first.
| No calculation or report data is changed.
|--------------------------------------------------------------------------
*/
public function collection()
{
    $allowedRoleIds = [
        19,
        21,
        22,
        23,
        26,
        27,
        28,
        29,
        33,
    ];

    $usersQuery = User::with([
        'roles',
        'facultyyy',
        'departmentttt'
    ])
        ->whereHas('roles', function ($query) use ($allowedRoleIds) {
            $query->whereIn('roles.id', $allowedRoleIds);
        });

    /*
    |--------------------------------------------------------------------------
    | Selected Role
    |--------------------------------------------------------------------------
    |
    | Faculty means teaching roles, matching the existing report selection.
    | Other selections use the selected role id directly.
    |--------------------------------------------------------------------------
    */
    if ($this->selectedRole === 'faculty') {

        $facultyRoleIds = [
            21,
            26,
            27,
            28,
            33,
        ];

        $usersQuery->whereHas('roles', function ($query) use ($facultyRoleIds) {
            $query->whereIn('roles.id', $facultyRoleIds);
        });

    } elseif (
        $this->selectedRole !== null &&
        $this->selectedRole !== ''
    ) {

        $selectedRoleId = (int) $this->selectedRole;

        $usersQuery->whereHas('roles', function ($query) use ($selectedRoleId) {
            $query->where('roles.id', $selectedRoleId);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Selected Faculty / Department / Program
    |--------------------------------------------------------------------------
    */
    if (
        $this->selectedFacultyId !== null &&
        $this->selectedFacultyId !== ''
    ) {
        $usersQuery->where(
            'faculty',
            $this->selectedFacultyId
        );
    }

    if (
        $this->selectedDepartmentId !== null &&
        $this->selectedDepartmentId !== ''
    ) {
        $usersQuery->where(
            'department_id',
            $this->selectedDepartmentId
        );
    }

    if (
        $this->selectedProgramId !== null &&
        $this->selectedProgramId !== ''
    ) {
        $usersQuery->where(
            'program_id',
            $this->selectedProgramId
        );
    }

    $users = $usersQuery->get();

    /*
    |--------------------------------------------------------------------------
    | SCORED EMPLOYEES FIRST
    |--------------------------------------------------------------------------
    |
    | Employees who have an entry in indicators_percentages
    | for the current year will appear first.
    |
    | No score calculation is changed here.
    |--------------------------------------------------------------------------
    */
    return $users
        ->sortByDesc(function ($user) {

            return isset(
                $this->employeesWithScores[(int) $user->id]
            ) ? 1 : 0;

        })
        ->values();
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
        | Employee Information
        |--------------------------------------------------------------------------
        */
        $facultyName =
            $this->facultyList[$user->faculty] ?? 'N/A';

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
            | Group KPA -> Category -> Indicator
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
            | KPA Totals
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

                $kpaWeight =
                    $this->kpaWeights[$roleId][$kpaId]
                    ?? 0;

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
            | Employee Group Start
            |--------------------------------------------------------------------------
            */
            $employeeStartRow =
                $this->currentExcelRow;

            $isFirstOverallRow = true;

            foreach ($kpaGroups as $kpaId => $categories) {

                $kpaName =
                    $this->kpaList[$kpaId] ?? 'N/A';

                $kpaScore =
                    $kpaTotals[$kpaId]['weighted']
                    ?? 0;

                /*
                |--------------------------------------------------------------------------
                | KPA Start Row
                |--------------------------------------------------------------------------
                */
                $kpaStartRow =
                    $this->currentExcelRow;

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

                    /*
                    |--------------------------------------------------------------------------
                    | Category Start Row
                    |--------------------------------------------------------------------------
                    */
                    $categoryStartRow =
                        $this->currentExcelRow;

                    $isFirstCategoryRow = true;

                    foreach ($indicators as $indicatorId => $assignment) {

                        /*
                        |--------------------------------------------------------------------------
                        | Indicator Name
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
                        | Employee Level
                        |--------------------------------------------------------------------------
                        */
                        $displayRole =
                            $isFirstOverallRow
                                ? (
                                    $role->name === 'Teacher'
                                        ? 'Lecturer'
                                        : $role->name
                                )
                                : '';

                        $displayUserName =
                            $isFirstOverallRow
                                ? $user->name
                                : '';

                        $displayEmployeeCode =
                            $isFirstOverallRow
                                ? (
                                    $user->barcode
                                    ?? $user->employee_id
                                    ?? 'N/A'
                                )
                                : '';

                        $displayDesignation =
                            $isFirstOverallRow
                                ? (
                                    $user->job_title
                                    ?? 'N/A'
                                )
                                : '';

                        $displayFaculty =
                            $isFirstOverallRow
                                ? $facultyName
                                : '';

                        $displayDepartment =
                            $isFirstOverallRow
                                ? $departmentName
                                : '';

                        /*
                        |--------------------------------------------------------------------------
                        | KPA Level
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
                        | Category Level
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
                        | Overall Level
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
                        | Final Row
                        |--------------------------------------------------------------------------
                        */
                        $rows[] = [

                            /*
                            |--------------------------------------------------------------------------
                            | Employee
                            |--------------------------------------------------------------------------
                            */
                            $displayRole,
                            $displayUserName,
                            $displayEmployeeCode,
                            $displayDesignation,
                            $displayFaculty,
                            $displayDepartment,

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
                            | Target / Achieved
                            |--------------------------------------------------------------------------
                            */
                            $target,
                            $achieved,

                            /*
                            |--------------------------------------------------------------------------
                            | Indicator Rating
                            |--------------------------------------------------------------------------
                            */
                            $indicatorRating,

                            /*
                            |--------------------------------------------------------------------------
                            | Overall
                            |--------------------------------------------------------------------------
                            */
                            $displayOverallScore,
                            $displayOverallRating,
                        ];

                        /*
                        |--------------------------------------------------------------------------
                        | Move Row
                        |--------------------------------------------------------------------------
                        */
                        $this->currentExcelRow++;

                        $isFirstCategoryRow = false;
                        $isFirstKpaRow = false;
                        $isFirstOverallRow = false;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Save Category Merge Range
                    |--------------------------------------------------------------------------
                    */
                    $categoryEndRow =
                        $this->currentExcelRow - 1;

                    if ($categoryEndRow > $categoryStartRow) {

                        $this->mergeRanges[] =
                            'I' . $categoryStartRow
                            . ':I' . $categoryEndRow;

                        $this->mergeRanges[] =
                            'J' . $categoryStartRow
                            . ':J' . $categoryEndRow;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Save KPA Merge Range
                |--------------------------------------------------------------------------
                */
                $kpaEndRow =
                    $this->currentExcelRow - 1;

                if ($kpaEndRow > $kpaStartRow) {

                    $this->mergeRanges[] =
                        'G' . $kpaStartRow
                        . ':G' . $kpaEndRow;

                    $this->mergeRanges[] =
                        'H' . $kpaStartRow
                        . ':H' . $kpaEndRow;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Employee End Row
            |--------------------------------------------------------------------------
            */
            $employeeEndRow =
                $this->currentExcelRow - 1;

            /*
            |--------------------------------------------------------------------------
            | Employee Information Merge
            |--------------------------------------------------------------------------
            */
            if ($employeeEndRow > $employeeStartRow) {

                foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $column) {

                    $this->mergeRanges[] =
                        $column
                        . $employeeStartRow
                        . ':'
                        . $column
                        . $employeeEndRow;
                }

                /*
                |--------------------------------------------------------------------------
                | Overall Score / Rating Merge
                |--------------------------------------------------------------------------
                */
                $this->mergeRanges[] =
                    'Q'
                    . $employeeStartRow
                    . ':Q'
                    . $employeeEndRow;

                $this->mergeRanges[] =
                    'R'
                    . $employeeStartRow
                    . ':R'
                    . $employeeEndRow;
            }
        }

        return $rows;
    }

    /*
    |--------------------------------------------------------------------------
    | Excel Events
    |--------------------------------------------------------------------------
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet =
                    $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | Header Styling
                |--------------------------------------------------------------------------
                |
                | No colors.
                | Only bold + alignment + border.
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getStyle('A1:R1')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 11,
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,

                            'vertical' =>
                                Alignment::VERTICAL_CENTER,

                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                /*
                |--------------------------------------------------------------------------
                | Header Height
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getRowDimension(1)
                    ->setRowHeight(35);

                /*
                |--------------------------------------------------------------------------
                | Column Widths
                |--------------------------------------------------------------------------
                */
                $widths = [

                    'A' => 18,
                    'B' => 25,
                    'C' => 17,
                    'D' => 25,
                    'E' => 25,
                    'F' => 25,

                    'G' => 30,
                    'H' => 14,

                    'I' => 30,
                    'J' => 16,

                    'K' => 38,
                    'L' => 16,
                    'M' => 17,

                    'N' => 14,
                    'O' => 14,

                    'P' => 18,

                    'Q' => 16,
                    'R' => 18,
                ];

                foreach ($widths as $column => $width) {

                    $sheet
                        ->getColumnDimension($column)
                        ->setWidth($width);
                }

                /*
                |--------------------------------------------------------------------------
                | Used Range
                |--------------------------------------------------------------------------
                */
                $lastRow =
                    max(
                        1,
                        $this->currentExcelRow - 1
                    );

                /*
                |--------------------------------------------------------------------------
                | Main Report Styling
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getStyle(
                        'A1:R' . $lastRow
                    )
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                /*
                |--------------------------------------------------------------------------
                | Wrap Long Text
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getStyle(
                        'A1:R' . $lastRow
                    )
                    ->getAlignment()
                    ->setWrapText(true);

                /*
                |--------------------------------------------------------------------------
                | Borders
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getStyle(
                        'A1:R' . $lastRow
                    )
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                /*
                |--------------------------------------------------------------------------
                | Center Numeric / Rating Columns
                |--------------------------------------------------------------------------
                */
                foreach (
                    [
                        'H',
                        'J',
                        'L',
                        'M',
                        'N',
                        'O',
                        'P',
                        'Q',
                        'R'
                    ] as $column
                ) {

                    $sheet
                        ->getStyle(
                            $column . '2:' . $column . $lastRow
                        )
                        ->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | Indicator Column
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getStyle(
                        'K2:K' . $lastRow
                    )
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    );

                /*
                |--------------------------------------------------------------------------
                | Grouped Columns
                |--------------------------------------------------------------------------
                */
                foreach (
                    ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'I', 'Q', 'R']
                    as $column
                ) {

                    $sheet
                        ->getStyle(
                            $column . '2:' . $column . $lastRow
                        )
                        ->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | Merge Employee / KPA / Category Groups
                |--------------------------------------------------------------------------
                */
                foreach ($this->mergeRanges as $range) {

                    $sheet->mergeCells($range);

                    $sheet
                        ->getStyle($range)
                        ->getAlignment()
                        ->setVertical(
                            Alignment::VERTICAL_CENTER
                        );

                    $sheet
                        ->getStyle($range)
                        ->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    $sheet
                        ->getStyle($range)
                        ->getAlignment()
                        ->setWrapText(true);
                }

                /*
                |--------------------------------------------------------------------------
                | Freeze Header
                |--------------------------------------------------------------------------
                */
                $sheet->freezePane('A2');

                /*
                |--------------------------------------------------------------------------
                | Auto Filter
                |--------------------------------------------------------------------------
                |
                | Keep the native filter on the complete report. The grouped cells remain
                | vertically merged exactly as the report layout requires.
                |--------------------------------------------------------------------------
                */
                $sheet->setAutoFilter(
                    'K1:P' . $lastRow
                );

                /*
                |--------------------------------------------------------------------------
                | Print Setup
                |--------------------------------------------------------------------------
                */
                $sheet
                    ->getPageSetup()
                    ->setOrientation(
                        \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
                    );

                $sheet
                    ->getPageSetup()
                    ->setPaperSize(
                        \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3
                    );

                $sheet
                    ->getPageSetup()
                    ->setFitToWidth(1);

                $sheet
                    ->getPageSetup()
                    ->setFitToHeight(0);

                $sheet
                    ->getPageMargins()
                    ->setTop(0.3);

                $sheet
                    ->getPageMargins()
                    ->setBottom(0.3);

                $sheet
                    ->getPageMargins()
                    ->setLeft(0.3);

                $sheet
                    ->getPageMargins()
                    ->setRight(0.3);
            },
        ];
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
                (
                    (float) $indicatorScore
                    /
                    (float) $indicatorWeight
                ) * 100,
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

        $target =
            $targetRecord &&
            $targetRecord->target !== null
                ? (float) $targetRecord->target
                : null;

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

        if (
            isset(
                $this->achievementCounts[(int) $userId]
            )
            &&
            array_key_exists(
                (int) $indicatorId,
                $this->achievementCounts[(int) $userId]
            )
        ) {

            return $this->achievementCounts[
                (int) $userId
            ][
                (int) $indicatorId
            ];
        }

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
            (
                (float) $achieved
                /
                (float) $target
            ) * 100,
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