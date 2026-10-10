<?php

namespace App\Exports;

use App\Models\IndicatorsPercentage;
use App\Models\KeyPerformanceArea;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Faculty;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DeanKpaMatrixExport implements
    FromCollection,
    WithHeadings,
    WithEvents
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

    protected $mergeRanges = [];
    protected $currentExcelRow = 2;

    public function __construct($yearId = 1)
    {
        $this->yearId = $yearId;

        /*
        |--------------------------------------------------------------------------
        | Load Faculties
        |--------------------------------------------------------------------------
        */

        $this->facultyList = Faculty::query()
            ->pluck('name', 'id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Load KPA List
        |--------------------------------------------------------------------------
        */

        $this->kpaList = KeyPerformanceArea::query()
            ->pluck('performance_area', 'id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Load Indicator Categories
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
        | Load Indicators
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
        | Find Dean Role Dynamically
        |--------------------------------------------------------------------------
        */

        $deanRoleIds = DB::table('roles')
            ->where('name', 'Dean')
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Load All Deans
        |--------------------------------------------------------------------------
        */

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
                ->whereIn(
                    'model_has_roles.role_id',
                    $deanRoleIds
                )
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

        /*
        |--------------------------------------------------------------------------
        | Load Role KPA Assignments
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Load Indicator Scores
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
        | Load Dean Targets
        |--------------------------------------------------------------------------
        | One target column will be added for each Dean.
        | The latest record wins if duplicate records exist for
        | the same Dean, indicator, and year.
        */

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
    }

    /*
    |--------------------------------------------------------------------------
    | Excel Headings
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        $headings = [
            'Key Performance Area',
            'Indicator Category',
            'Indicator',
        ];

        foreach ($this->deans as $dean) {
            $facultyName = $this->facultyList[$dean->faculty] ?? 'N/A';

            $deanName = $dean->name
                . '-' . $dean->employee_id
                . ' (' . $facultyName . ')';

            // Two columns for each Dean.
            $headings[] = $deanName . ' - Score';
            $headings[] = $deanName . ' - Target';
        }

        return $headings;
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Excel Matrix
    |--------------------------------------------------------------------------
    */

    public function collection()
    {
        $rows = [];

        if (empty($this->deans)) {
            return collect($rows);
        }

        /*
        |--------------------------------------------------------------------------
        | Build Effective Assignments for Each Dean
        |--------------------------------------------------------------------------
        | Role-level assignments are used first.
        | User-specific assignments override role-level assignments.
        */

        $deanEffectiveAssignments = [];

        foreach ($this->deans as $dean) {
            $roleId = $this->getDeanRoleId($dean->id);

            if (!$roleId) {
                $deanEffectiveAssignments[$dean->id] = null;
                continue;
            }

            $roleAssignments =
                $this->assignments[$roleId . '_0'] ?? [];

            $userAssignments =
                $this->assignments[$roleId . '_' . $dean->id] ?? [];

            $effectiveAssignments = $roleAssignments;

            foreach ($userAssignments as $indicatorKey => $assignment) {
                $effectiveAssignments[$indicatorKey] = $assignment;
            }

            $deanEffectiveAssignments[$dean->id] = [
                'role_id' => $roleId,
                'assignments' => $effectiveAssignments,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Build Union of All Assigned Indicators
        |--------------------------------------------------------------------------
        */

        $matrix = [];

        foreach ($deanEffectiveAssignments as $deanData) {
            if (!$deanData) {
                continue;
            }

            foreach ($deanData['assignments'] as $assignment) {
                $kpaId = (int) $assignment->key_performance_area_id;
                $categoryId = (int) $assignment->indicator_category_id;
                $indicatorId = (int) $assignment->indicator_id;

                $matrix[$kpaId][$categoryId][$indicatorId] = true;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Matrix Rows
        |--------------------------------------------------------------------------
        */

        foreach ($matrix as $kpaId => $categories) {
            $kpaName = $this->kpaList[$kpaId] ?? 'N/A';

            $kpaStartRow = $this->currentExcelRow;
            $kpaFirstRow = true;

            foreach ($categories as $categoryId => $indicators) {
                $categoryName =
                    $this->categoryList[$categoryId]->indicator_category
                    ?? 'N/A';

                $categoryStartRow = $this->currentExcelRow;
                $categoryFirstRow = true;

                foreach ($indicators as $indicatorId => $unused) {
                    $indicatorName =
                        $this->indicatorList[$indicatorId]->indicator
                        ?? 'N/A';

                    $row = [
                        $kpaFirstRow ? $kpaName : '',
                        $categoryFirstRow ? $categoryName : '',
                        $indicatorName,
                    ];

                    /*
                    |--------------------------------------------------------------------------
                    | Add Score and Target for Every Dean
                    |--------------------------------------------------------------------------
                    */

                    foreach ($this->deans as $dean) {
                        $deanData =
                            $deanEffectiveAssignments[$dean->id] ?? null;

                        $assignmentKey =
                            $kpaId
                            . '_'
                            . $categoryId
                            . '_'
                            . $indicatorId;

                        /*
                        |--------------------------------------------------------------------------
                        | Score
                        |--------------------------------------------------------------------------
                        | Preserve the existing score logic.
                        | If the indicator is not assigned to this Dean,
                        | display a blank score.
                        */

                        if (
                            $deanData &&
                            isset(
                                $deanData['assignments'][$assignmentKey]
                            )
                        ) {
                            $roleId = $deanData['role_id'];

                            $scoreRecord = $this->getScoreRecord(
                                $dean->id,
                                $roleId,
                                $kpaId,
                                $categoryId,
                                $indicatorId
                            );

                            $row[] = $scoreRecord
                                && $scoreRecord->with_out_weight_score !== null
                                && $scoreRecord->with_out_weight_score !== ''
                                    ? (float) $scoreRecord->with_out_weight_score
                                    : '';
                        } else {
                            $row[] = '';
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Target
                        |--------------------------------------------------------------------------
                        | Target is retrieved independently of the score.
                        | It is matched by Dean user ID and indicator ID.
                        */
                         $targetKey = $dean->id . '_' . $indicatorId;

                        $row[] = isset($this->indicatorTargets[$targetKey])
                            ? (float) $this->indicatorTargets[$targetKey]
                            : '';

                       
                    }

                    $rows[] = $row;

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
        }

        return collect($rows);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Dean Role ID
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | Get Indicator Score Record
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
    | Excel Styling and Page Setup
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Three fixed columns + two columns per Dean.
                $lastColumnIndex = 3 + (count($this->deans) * 2);

                $lastColumn = Coordinate::stringFromColumnIndex(
                    max(3, $lastColumnIndex)
                );

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

                $sheet->getRowDimension(1)->setRowHeight(45);

                /*
                |--------------------------------------------------------------------------
                | Column Widths
                |--------------------------------------------------------------------------
                */

                $sheet->getColumnDimension('A')->setWidth(32);
                $sheet->getColumnDimension('B')->setWidth(38);
                $sheet->getColumnDimension('C')->setWidth(42);

                for ($i = 4; $i <= $lastColumnIndex; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);

                    $sheet->getColumnDimension($column)->setWidth(18);
                }

                /*
                |--------------------------------------------------------------------------
                | Main Table Styling
                |--------------------------------------------------------------------------
                */

                if ($lastRow >= 2) {
                    $sheet
                        ->getStyle('A1:' . $lastColumn . $lastRow)
                        ->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);

                    $sheet
                        ->getStyle('A1:' . $lastColumn . $lastRow)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);

                    // KPA, category, and indicator: left aligned.
                    $sheet
                        ->getStyle('A2:C' . $lastRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                    // All Dean score and target columns: centered.
                    if ($lastColumnIndex >= 4) {
                        $sheet
                            ->getStyle('D2:' . $lastColumn . $lastRow)
                            ->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
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
                | Freeze Fixed Columns and Header
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('D2');

                /*
                |--------------------------------------------------------------------------
                | Auto Filter
                |--------------------------------------------------------------------------
                */

                $sheet->setAutoFilter(
                    'A1:' . $lastColumn . $lastRow
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