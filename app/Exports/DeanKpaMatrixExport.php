<?php

namespace App\Exports;

use App\Models\IndicatorsPercentage;
use App\Models\KeyPerformanceArea;
use App\Models\Faculty;
use App\Models\UserTargetAchieved;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DeanKpaMatrixExport implements WithMultipleSheets
{
    protected $yearId = 1;

    protected $deans = [];
    protected $facultyList = [];
    protected $kpaList = [];
    protected $categoryList = [];
    protected $indicatorList = [];

    protected $assignments = [];
    protected $indicatorScores = [];
    protected $indicatorTargets = [];
    protected $indicatorAchievements = [];

    public function __construct($yearId = 1)
    {
        $this->yearId = $yearId;

        // Load Faculties
        $this->facultyList = Faculty::query()
            ->pluck('name', 'id')
            ->toArray();

        // Load KPAs
        $this->kpaList = KeyPerformanceArea::query()
            ->pluck('performance_area', 'id')
            ->toArray();

        // Load Indicator Categories
        $this->categoryList = DB::table('indicator_categories')
            ->select('id', 'key_performance_area_id', 'indicator_category')
            ->get()
            ->keyBy('id');

        // Load Indicators
        $this->indicatorList = DB::table('indicators')
            ->select('id', 'indicator_category_id', 'indicator')
            ->get()
            ->keyBy('id');

        // Find Dean Role
        $deanRoleIds = DB::table('roles')
            ->where('name', 'Dean')
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        // Load Deans
        if (!empty($deanRoleIds)) {
            $this->deans = DB::table('users')
                ->join(
                    'model_has_roles',
                    'model_has_roles.model_id',
                    '=',
                    'users.id'
                )
                ->where(
                    'model_has_roles.model_type',
                    'App\\Models\\User'
                )
                ->whereIn('model_has_roles.role_id', $deanRoleIds)
                ->select(
                    'users.id',
                    'users.name',
                    'users.employee_id',
                    'users.barcode',
                    'users.faculty'
                )
                ->distinct()
                ->orderBy('users.name')
                ->get()
                ->values()
                ->all();
        }

        // Load Role KPA Assignments
        if (!empty($deanRoleIds)) {
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
                ->whereIn('role_id', $deanRoleIds)
                ->whereIn('status', ['0', '1'])
                ->orderBy('id')
                ->get();

            foreach ($assignments as $assignment) {
                $roleId = (int) $assignment->role_id;

                // NULL user_id means role-level assignment.
                $userId = $assignment->user_id !== null
                    ? (int) $assignment->user_id
                    : 0;

                $key = $roleId . '_' . $userId;

                $indicatorKey =
                    (int) $assignment->key_performance_area_id
                    . '_'
                    . (int) $assignment->indicator_category_id
                    . '_'
                    . (int) $assignment->indicator_id;

                // Latest assignment wins.
                $this->assignments[$key][$indicatorKey] = $assignment;
            }
        }

        // Load Indicator Scores
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

        // Load Dean Targets
        $targets = DB::table('faculty_targets_dean')
            ->select(
                'created_by',
                'indicator_id',
                DB::raw('SUM(target) as total_target')
            )
            ->where('year_id', $this->yearId)
            ->groupBy('created_by', 'indicator_id')
            ->get();

        foreach ($targets as $target) {
            $key = $target->created_by . '_' . $target->indicator_id;

            $this->indicatorTargets[$key] = $target->total_target;
        }

        // Load Employee Achievements
        // users.manager_id matches the Dean's users.id.
        // UserTargetAchieved.employ_id matches users.employee_id.

        $deanIds = collect($this->deans)->pluck('id');

        $employeeIdsByDean = DB::table('users')
            ->whereIn('manager_id', $deanIds)
            ->select('id', 'manager_id', 'employee_id')
            ->get()
            ->groupBy('manager_id');

        $allEmployeeIds = $employeeIdsByDean
            ->flatten(1)
            ->pluck('employee_id')
            ->filter()
            ->unique()
            ->values();

        $achievements = UserTargetAchieved::query()
            ->select(
                'employ_id',
                'indicator_id',
                DB::raw('SUM(acheived) as total_acheived')
            )
            ->where('year_id', $this->yearId)
            ->whereIn('employ_id', $allEmployeeIds)
            ->groupBy('employ_id', 'indicator_id')
            ->get();

        foreach ($this->deans as $dean) {
            $employeeIds = $employeeIdsByDean
                ->get($dean->id, collect())
                ->pluck('employee_id')
                ->filter()
                ->unique();

            foreach ($achievements->whereIn('employ_id', $employeeIds) as $achievement) {
                $key = $dean->id . '_' . $achievement->indicator_id;

                $this->indicatorAchievements[$key] =
                    ($this->indicatorAchievements[$key] ?? 0)
                    + (float) $achievement->total_acheived;
            }
        }
    }

    /**
     * Create one worksheet for each Dean.
     */
    public function sheets(): array
    {
        $sheets = [];
        $usedTitles = [];

        foreach ($this->deans as $dean) {
            $roleId = $this->getDeanRoleId($dean->id);

            if (!$roleId) {
                continue;
            }

            // Role-level assignments
            $roleAssignments = $this->assignments[$roleId . '_0'] ?? [];

            // User-specific assignments
            $userAssignments = $this->assignments[$roleId . '_' . $dean->id] ?? [];

            // User-specific assignments override role-level assignments.
            $effectiveAssignments = $roleAssignments;

            foreach ($userAssignments as $indicatorKey => $assignment) {
                $effectiveAssignments[$indicatorKey] = $assignment;
            }

            $facultyName = $this->facultyList[$dean->faculty] ?? 'N/A';

            $sheetName = $this->makeUniqueSheetTitle(
                $dean->name ?: 'Dean',
                $dean->id,
                $usedTitles
            );

            $sheets[] = new DeanKpaMatrixSheet(
                $dean,
                $roleId,
                $effectiveAssignments,
                $this->kpaList,
                $this->categoryList,
                $this->indicatorList,
                $this->indicatorScores,
                $this->indicatorTargets,
                $this->indicatorAchievements,
                $sheetName,
                $facultyName
            );
        }

        return $sheets;
    }

    /**
     * Get Dean Role ID.
     */
    private function getDeanRoleId($userId)
    {
        $roleId = DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where('model_has_roles.model_id', $userId)
            ->where(
                'model_has_roles.model_type',
                'App\\Models\\User'
            )
            ->where('roles.name', 'Dean')
            ->value('roles.id');

        return $roleId ? (int) $roleId : null;
    }

    /**
     * Generate a valid and unique Excel sheet title.
     */
    private function makeUniqueSheetTitle($name, $id, &$usedTitles)
    {
        $title = preg_replace('/[\\\\\/\?\*\[\]\:]/', ' ', $name);
        $title = trim(preg_replace('/\s+/', ' ', $title));

        if ($title === '') {
            $title = 'Dean';
        }

        $title = mb_substr($title, 0, 31);

        $baseTitle = $title;
        $counter = 1;

        while (in_array(mb_strtolower($title), $usedTitles, true)) {
            $suffix = '-' . $id . ($counter > 1 ? '-' . $counter : '');
            $title = mb_substr($baseTitle, 0, 31 - mb_strlen($suffix)) . $suffix;
            $counter++;
        }

        $usedTitles[] = mb_strtolower($title);

        return $title;
    }
}

/*
|--------------------------------------------------------------------------
| Individual Dean Worksheet
|--------------------------------------------------------------------------
*/

class DeanKpaMatrixSheet implements
    FromCollection,
    WithHeadings,
    WithEvents,
    WithTitle
{
    protected $dean;
    protected $roleId;
    protected $assignments;

    protected $kpaList;
    protected $categoryList;
    protected $indicatorList;

    protected $indicatorScores;
    protected $indicatorTargets;
    protected $indicatorAchievements;

    protected $sheetName;
    protected $facultyName;

    protected $mergeRanges = [];
    protected $summaryRows = [];
    protected $currentExcelRow = 2;

    public function __construct(
        $dean,
        $roleId,
        $assignments,
        $kpaList,
        $categoryList,
        $indicatorList,
        $indicatorScores,
        $indicatorTargets,
        $indicatorAchievements,
        $sheetName,
        $facultyName
    ) {
        $this->dean = $dean;
        $this->roleId = $roleId;
        $this->assignments = $assignments;

        $this->kpaList = $kpaList;
        $this->categoryList = $categoryList;
        $this->indicatorList = $indicatorList;

        $this->indicatorScores = $indicatorScores;
        $this->indicatorTargets = $indicatorTargets;
        $this->indicatorAchievements = $indicatorAchievements;

        $this->sheetName = $sheetName;
        $this->facultyName = $facultyName;
    }

    /**
     * Excel worksheet title.
     */
    public function title(): string
    {
        return $this->sheetName;
    }

    /**
     * Excel headings.
     */
    public function headings(): array
    {
        return [
            'Key Performance Area',
            'Indicator Category',
            'Indicator',
            'Target',
            'Achieved',
            'Weight',
            'Score',
            'Rating',
        ];
    }

    /**
     * Get Indicator Score Record.
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

    /**
 * Get Overall Rating Based on Overall Score.
 */
    private function getOverallRating($score)
    {
        if ($score >= 90) {
            return 'OS';
        } elseif ($score >= 80) {
            return 'EE';
        } elseif ($score >= 70) {
            return 'ME';
        } elseif ($score >= 60) {
            return 'NI';
        }

        return 'BE';
    }

    /**
     * Generate worksheet rows.
     */
    public function collection()
    {
        $rows = [];

        if (empty($this->assignments)) {
            return collect($rows);
        }

        /*
        |--------------------------------------------------------------------------
        | Build KPA / Category / Indicator Matrix
        |--------------------------------------------------------------------------
        */

        $matrix = [];

        foreach ($this->assignments as $assignment) {
            $kpaId = (int) $assignment->key_performance_area_id;
            $categoryId = (int) $assignment->indicator_category_id;
            $indicatorId = (int) $assignment->indicator_id;

            $matrix[$kpaId][$categoryId][$indicatorId] = $assignment;
        }

        $overallTotal = 0;

        /*
        |--------------------------------------------------------------------------
        | Generate Rows
        |--------------------------------------------------------------------------
        */

        foreach ($matrix as $kpaId => $categories) {
            $kpaName = $this->kpaList[$kpaId] ?? 'N/A';

            $kpaStartRow = $this->currentExcelRow;
            $kpaFirstRow = true;

            $kpaScoreTotal = 0;
            $kpaWeightage = 0;

            foreach ($categories as $categoryId => $indicators) {
                $categoryName =
                    $this->categoryList[$categoryId]->indicator_category
                    ?? 'N/A';

                $categoryStartRow = $this->currentExcelRow;
                $categoryFirstRow = true;

                foreach ($indicators as $indicatorId => $assignment) {
                    $indicatorName =
                        $this->indicatorList[$indicatorId]->indicator
                        ?? 'N/A';

                    $scoreRecord = $this->getScoreRecord(
                        $this->dean->id,
                        $this->roleId,
                        $kpaId,
                        $categoryId,
                        $indicatorId
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Target and Achieved
                    |--------------------------------------------------------------------------
                    */

                    $targetKey = $this->dean->id . '_' . $indicatorId;

                    $target = $this->indicatorTargets[$targetKey] ?? null;

                    if ($target !== null) {
                        // When target exists, show actual achievement.
                        $achieved = $this->indicatorAchievements[$targetKey] ?? 0;
                    } else {
                        // When target does not exist, show without-weight score.
                        $achieved = $scoreRecord
                            && $scoreRecord->with_out_weight_score !== null
                            && $scoreRecord->with_out_weight_score !== ''
                                ? (float) $scoreRecord->with_out_weight_score
                                : '';

                        $target = '';
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Weight, Score and Rating
                    |--------------------------------------------------------------------------
                    */

                    $weight = $assignment->indicator_weightage ?? '';

                    /*
                    |--------------------------------------------------------------------------
                    | Weight, Score and Rating
                    |--------------------------------------------------------------------------
                    |
                    | If a target exists, calculate the indicator score from the
                    | achieved percentage and indicator weight:
                    |
                    | Score = (Achieved / Target) * Indicator Weight
                    |
                    | The score is capped at the indicator weight so that an
                    | indicator cannot contribute more than its assigned weight.
                    |
                    | If no target exists, keep the existing IndicatorsPercentage
                    | score unchanged.
                    */

                    if ($target !== '' && $target !== null) {
                        $targetValue = (float) $target;
                        $achievedValue = is_numeric($achieved) ? (float) $achieved : 0;
                        $weightValue = is_numeric($weight) ? (float) $weight : 0;

                        if ($targetValue > 0) {
                            $score = ($achievedValue / $targetValue) * $weightValue;

                            // Maximum indicator score cannot exceed its weight.
                            $score = min($score, $weightValue);
                        } else {
                            // Avoid division by zero when a target is zero.
                            $score = 0;
                        }
                    } else {
                        $score = $scoreRecord
                            && $scoreRecord->score !== null
                            && $scoreRecord->score !== ''
                                ? (float) $scoreRecord->score
                                : '';
                    }

                    // Round indicator score to 2 decimal places.
                    if ($score !== '') {
                        $score = round((float) $score, 2);
                    }

                    // Keep the existing stored rating unchanged.
                    $rating = $scoreRecord->rating ?? '';

                    /*
                    |--------------------------------------------------------------------------
                    | KPA Score Calculation
                    |--------------------------------------------------------------------------
                    |
                    | Add the final indicator score (target-based weighted score
                    | where a target exists, otherwise the existing score).
                    | KPA weightage is applied once below, as before.
                    */

                    if ($score !== '') {
                        $kpaScoreTotal += (float) $score;
                    }

                    // Effective assignment KPA weightage.
                    $kpaWeightage = (float) ($assignment->kpa_weightage ?? 0);

                    /*
                    |--------------------------------------------------------------------------
                    | Add Indicator Row
                    |--------------------------------------------------------------------------
                    */

                    $rows[] = [
                        $kpaFirstRow ? $kpaName : '',
                        $categoryFirstRow ? $categoryName : '',
                        $indicatorName,
                        $target !== '' && $target !== null
                            ? (float) $target
                            : '',
                        $achieved,
                        $weight !== '' && $weight !== null
                            ? (float) $weight
                            : '',
                        $score,
                        $rating,
                    ];

                    $this->currentExcelRow++;

                    $kpaFirstRow = false;
                    $categoryFirstRow = false;
                }

                /*
                |--------------------------------------------------------------------------
                | Merge Category Cells
                |--------------------------------------------------------------------------
                */

                $categoryEndRow = $this->currentExcelRow - 1;

                if ($categoryEndRow > $categoryStartRow) {
                    $this->mergeRanges[] =
                        'B' . $categoryStartRow
                        . ':B' . $categoryEndRow;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Merge KPA Cells
            |--------------------------------------------------------------------------
            */

            $kpaEndRow = $this->currentExcelRow - 1;

            if ($kpaEndRow > $kpaStartRow) {
                $this->mergeRanges[] =
                    'A' . $kpaStartRow
                    . ':A' . $kpaEndRow;
            }

            /*
            |--------------------------------------------------------------------------
            | KPA Total
            |--------------------------------------------------------------------------
            */

            // Existing calculation: sum already-weighted indicator scores,
            // then apply KPA weightage once.
            $weightedKpaTotal = round(($kpaScoreTotal * $kpaWeightage) / 100,2);

            $overallTotal += $weightedKpaTotal;

            $rows[] = [
                'KPA Total - ' . $kpaName,
                '',
                '',
                '',
                '',
                '',
                (float) $weightedKpaTotal,
                '',
            ];

            $this->summaryRows[] = $this->currentExcelRow;
            $this->currentExcelRow++;
        }

        /*
        |--------------------------------------------------------------------------
        | Overall Total
        |--------------------------------------------------------------------------
        */

        if (!empty($matrix)) {

            // Round overall score to 2 decimal places.
            $overallTotal = round($overallTotal, 2);

            // Calculate overall rating.
            $overallRating = $this->getOverallRating($overallTotal);

            $rows[] = [
                'OVERALL TOTAL SCORE',
                '',
                '',
                '',
                '',
                '',
                $overallTotal,
                $overallRating,
            ];

            $this->summaryRows[] = $this->currentExcelRow;
            $this->currentExcelRow++;
        }

        return collect($rows);
    }

    /**
     * Excel Styling and Page Setup.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastColumn = 'H';

                $lastRow = max(
                    1,
                    $this->currentExcelRow - 1
                );

                /*
                |--------------------------------------------------------------------------
                | Header Styling
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A1:' . $lastColumn . '1')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 11,
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                $sheet->getRowDimension(1)->setRowHeight(35);

                /*
                |--------------------------------------------------------------------------
                | Column Widths
                |--------------------------------------------------------------------------
                */

                $sheet->getColumnDimension('A')->setWidth(32);
                $sheet->getColumnDimension('B')->setWidth(38);
                $sheet->getColumnDimension('C')->setWidth(48);

                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(15);
                $sheet->getColumnDimension('F')->setWidth(15);
                $sheet->getColumnDimension('G')->setWidth(15);
                $sheet->getColumnDimension('H')->setWidth(18);

                /*
                |--------------------------------------------------------------------------
                | Main Table Styling
                |--------------------------------------------------------------------------
                */

                if ($lastRow >= 2) {
                    $sheet
                        ->getStyle('A1:H' . $lastRow)
                        ->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);

                    $sheet
                        ->getStyle('A1:H' . $lastRow)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);

                    $sheet
                        ->getStyle('A2:C' . $lastRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                    $sheet
                        ->getStyle('D2:H' . $lastRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                /*
                |--------------------------------------------------------------------------
                | Merge KPA and Category Cells
                |--------------------------------------------------------------------------
                */

                foreach ($this->mergeRanges as $range) {
                    $sheet->mergeCells($range);

                    $sheet
                        ->getStyle($range)
                        ->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                        ->setWrapText(true);
                }

                /*
                |--------------------------------------------------------------------------
                | Highlight Summary Rows
                |--------------------------------------------------------------------------
                */

                foreach ($this->summaryRows as $summaryRow) {
                    $sheet
                        ->getStyle('A' . $summaryRow . ':H' . $summaryRow)
                        ->getFont()
                        ->setBold(true);
                }

                /*
                |--------------------------------------------------------------------------
                | Freeze Header and Fixed Columns
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('D2');

                /*
                |--------------------------------------------------------------------------
                | Auto Filter
                |--------------------------------------------------------------------------
                */

                $sheet->setAutoFilter(
                    'A1:H' . $lastRow
                );

                /*
                |--------------------------------------------------------------------------
                | Print Setup
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                $sheet
                    ->getPageSetup()
                    ->setPaperSize(PageSetup::PAPERSIZE_A3);

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
}