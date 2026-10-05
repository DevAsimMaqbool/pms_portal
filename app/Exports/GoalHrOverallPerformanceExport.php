<?php

namespace App\Exports;

use App\Models\LineManagerFeedback;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Barryvdh\DomPDF\Facade\Pdf;

class GoalHrOverallPerformanceExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    protected array $departments = [];

    public function __construct($departments = null)
    {
        if (!is_array($departments)) {
            $departments = [$departments];
        }

        $this->departments = collect($departments)
            ->filter(function ($department) {
                return filled($department)
                    && !in_array(
                        strtolower(trim($department)),
                        ['all', 'all departments'],
                        true
                    );
            })
            ->unique()
            ->values()
            ->toArray();
    }

    public function collection(): Collection
    {
        $query = User::query()
            ->with([
                'goalSelfReports' => function ($q) {
                    $q->where('status', 'manager_approved')
                        ->with('reviews')
                        ->orderByDesc('id');
                },
                'goalOverallReviews' => function ($q) {
                    $q->latest('id');
                },
            ])
            ->orderBy('name');

        if (!empty($this->departments)) {

    $query->where(function ($q) {

        foreach ($this->departments as $department) {

            if (
                $department ===
                'Superior University, Lahore / Rector Secretariat'
            ) {

                $q->orWhere(
                    'hr_department_name',
                    $department
                )
                ->orWhere('manager_id', 20055)
                ->orWhereIn('employee_id', [
                    '40110',
                    '40298',
                    '130211',
                ]);

            } else {

                $q->orWhere(
                    'hr_department_name',
                    $department
                );
            }
        }
    });
}

        $employees = $query->get();

        $feedbackMap = LineManagerFeedback::query()
            ->whereIn(
                'employee_id',
                $employees->pluck('id')
            )
            ->where('status', 1)
            ->orderByDesc('id')
            ->get()
            ->groupBy('employee_id')
            ->map(function ($items) {
                return $items->first();
            });

        return $employees->map(function ($employee) use ($feedbackMap) {
            $reports = $employee->goalSelfReports;

            $selfRatings = $reports
                ->pluck('rating')
                ->filter(function ($value) {
                    return $value !== null
                        && is_numeric($value);
                })
                ->map(function ($value) {
                    return (float) $value;
                });

            $selfOverallRating = $selfRatings->count()
                ? round($selfRatings->avg(), 2)
                : 0;

            $overallReview = $employee->goalOverallReviews
                ->sortByDesc('id')
                ->first();

            /*
            |--------------------------------------------------------------------------
            | MANAGER OVERALL RATING — WEIGHTED SCORE SUM
            |--------------------------------------------------------------------------
            */

            $managerWeightedReports = $reports
                ->filter(function ($report) {
                    return $report->manager_rating !== null
                        && is_numeric($report->manager_rating)
                        && $report->weightage !== null
                        && is_numeric($report->weightage);
                });

            $managerOverallRating = $managerWeightedReports->count()
                ? round(
                    $managerWeightedReports->sum(function ($report) {
                        return (float) $report->manager_rating
                            * ((float) $report->weightage / 100);
                    }),
                    2
                )
                : 0;

            $hrOverallRating = 0;

            if (
                $overallReview &&
                $overallReview->hr_overall_rating !== null &&
                is_numeric($overallReview->hr_overall_rating)
            ) {
                $hrOverallRating =
                    (float) $overallReview->hr_overall_rating;
            }

            $lineManagerFeedback =
                $feedbackMap->get($employee->id);

            $virtueScores = [
                $this->averageValues(
                    $lineManagerFeedback,
                    [
                        'honesty_integrity_1',
                        'honesty_integrity_2',
                        'honesty_integrity_3',
                    ]
                ),

                $this->averageValues(
                    $lineManagerFeedback,
                    [
                        'responsibility_accountability_1',
                        'responsibility_accountability_2',
                        'responsibility_accountability_3',
                    ]
                ),

                $this->averageValues(
                    $lineManagerFeedback,
                    [
                        'humility_service_1',
                        'humility_service_2',
                        'humility_service_3',
                    ]
                ),

                $this->averageValues(
                    $lineManagerFeedback,
                    [
                        'empathy_compassion_1',
                        'empathy_compassion_2',
                    ]
                ),

                $this->averageValues(
                    $lineManagerFeedback,
                    [
                        'inspirational_leadership_1',
                        'inspirational_leadership_2',
                        'inspirational_leadership_3',
                    ]
                ),
            ];

            $validVirtueScores = collect($virtueScores)
                ->filter(function ($score) {
                    return $score !== null;
                });

            $virtueOverall = $validVirtueScores->count()
                ? round($validVirtueScores->avg(), 2)
                : 0;

            $selfScore100 = round(
                $selfOverallRating * 20,
                2
            );

            $managerScore100 = round(
                $managerOverallRating * 20,
                2
            );

            $feedbackScore100 = round(
                $virtueOverall,
                2
            );

            $hrScore100 = round(
                $hrOverallRating,
                2
            );

            // Total Score = Manager 70% + Manager Feedback 30%
            $weightedManagerScore = round(
                $managerScore100 * 0.70,
                2
            );

            $weightedFeedbackScore = round(
                $feedbackScore100 * 0.30,
                2
            );

            $totalScore = round(
                $weightedManagerScore +
                $weightedFeedbackScore,
                2
            );

            // Final Score = HR Score
            $finalScore = $hrScore100;

            // Final Rating = Rating based on HR Score
            $finalRating = $this->getRating(
                $finalScore
            );

            /*
            |--------------------------------------------------------------------------
            | TOTAL MANAGER-APPROVED GOALS & WEIGHTAGE
            |--------------------------------------------------------------------------
            */

            $approvedGoals = $reports->unique('new_goal_id');

            $totalApprovedGoals = $approvedGoals->count();

            $totalWeightage = round(
                $approvedGoals->sum(function ($report) {
                    return is_numeric($report->weightage)
                        ? (float) $report->weightage
                        : 0;
                }),
                2
            );

            $department =
                $employee->hr_department_name
                ?? $employee->department
                ?? '—';

            return [
                'Name' =>
                    $employee->name ?? '—',

                'Employee ID' =>
                    $employee->barcode ?? '—',

                'Designation' =>
                    $employee->job_title ?? '—',

                'Department' =>
                    $department,
                'Total Goals' => $totalApprovedGoals,
                'Total Weightage' => number_format($totalWeightage,2),
                'Self Score' =>
                    number_format(
                        $selfScore100,
                        2
                    ),

                'Manager Score' =>
                    number_format(
                        $managerScore100,
                        2
                    ),

                'Manager Feedback' =>
                    number_format(
                        $feedbackScore100,
                        2
                    ),

                'Total Score' =>
                    number_format(
                        $totalScore,
                        2
                    ),

                'HR Score' =>
                    number_format(
                        $hrScore100,
                        2
                    ),

                'Final Score' =>
                    number_format(
                        $finalScore,
                        2
                    ),

                'Rating' =>
                    $finalRating,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Employee ID',
            'Designation',
            'Department',
            'Total Goals',
            'Total Weightage',
            'Self Score',
            'Manager Score',
            'Manager Feedback',
            'Manager Final Score',
            'HR Score',
            'Final Score',
            'Rating',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet
            ->getStyle(
                "A1:{$highestColumn}1"
            )
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
                'fill' => [
                    'fillType' =>
                        Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '1F4E79',
                    ],
                ],
                'alignment' => [
                    'horizontal' =>
                        Alignment::HORIZONTAL_CENTER,
                    'vertical' =>
                        Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]);

        /*
        |--------------------------------------------------------------------------
        | Total Score Header
        |--------------------------------------------------------------------------
        | Main title remains bold/larger.
        | Formula text is smaller for better presentation.
        */
        $richText = new RichText();

        $mainText = $richText->createTextRun('Total Score');
        $mainText->getFont()->setBold(true);
        $mainText->getFont()->setSize(12);
        $mainText
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF');

        $subText = $richText->createTextRun(
            "\n70% Goal + 30% Feedback"
        );
        $subText->getFont()->setBold(false);
        $subText->getFont()->setSize(8);
        $subText
            ->getFont()
            ->getColor()
            ->setARGB('FFFFFF');

        $sheet
            ->getCell('H1')
            ->setValue($richText);

        $sheet
            ->getStyle('H1')
            ->getAlignment()
            ->setWrapText(true);

        $sheet
            ->getStyle('H1')
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_CENTER
            );

        $sheet
            ->getStyle('H1')
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );

        if ($highestRow > 1) {
            $sheet
                ->getStyle(
                    "A2:{$highestColumn}{$highestRow}"
                )
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

            $sheet
                ->getStyle(
                    "E2:K{$highestRow}"
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );

            for (
                $row = 2;
                $row <= $highestRow;
                $row++
            ) {
                $rating =
                    $sheet
                        ->getCell("K{$row}")
                        ->getValue();

                $color = match ($rating) {
                    'OS' => '6EA8FE',
                    'EE' => '96E2B4',
                    'ME' => 'FFCB9A',
                    'NI' => 'FD7E13',
                    'BE' => 'FF4C51',
                    default => 'ADB5BD',
                };

                $sheet
                    ->getStyle("K{$row}")
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => [
                                'rgb' => $color,
                            ],
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
            }
        }

        $sheet
            ->getRowDimension(1)
            ->setRowHeight(32);

        return [];
    }

    private function averageValues(
        $model,
        array $fields
    ): ?float {
        if (!$model) {
            return null;
        }

        $values = collect($fields)
            ->map(function ($field) use ($model) {
                $value =
                    $model->{$field} ?? null;

                return is_numeric($value)
                    ? (float) $value
                    : null;
            })
            ->filter(function ($value) {
                return $value !== null;
            });

        return $values->count()
            ? round($values->avg(), 2)
            : null;
    }

    private function getRating(
        $percentage
    ): string {
        $percentage =
            is_numeric($percentage)
                ? (float) $percentage
                : 0;

        if ($percentage >= 90) {
            return 'OS';
        }

        if ($percentage >= 80) {
            return 'EE';
        }

        if ($percentage >= 70) {
            return 'ME';
        }

        if ($percentage >= 60) {
            return 'NI';
        }

        return 'BE';
    }

    public function exportPdf(Request $request)
{
    $department = $request->input('department');

    $departmentName = $department
        ? preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '_',
            $department
        )
        : 'All_Departments';

    /*
    |--------------------------------------------------------------------------
    | Use the exact same data/calculations as Excel report
    |--------------------------------------------------------------------------
    */
    $rows = (new GoalHrOverallPerformanceExport($department))
        ->collection();

    $pdf = Pdf::loadView(
        'admin.goal_hr.overall_performance_pdf',
        [
            'rows' => $rows,
            'department' => $department,
        ]
    )
        ->setPaper('a4', 'landscape');

    $filename =
        'Overall_Performance_Report_' .
        $departmentName .
        '_' .
        now()->format('Y-m-d') .
        '.pdf';

    return $pdf->download($filename);
}
}