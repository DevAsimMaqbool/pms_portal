<?php

namespace App\Exports;

use App\Models\NewGoal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OverallGoalsReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithEvents
{
    protected $managerId;

    public function __construct()
    {
        $this->managerId = Auth::id();
    }

    public function collection()
    {
        $employeeIds = User::where('manager_id', $this->managerId)
            ->pluck('id');

        return NewGoal::query()
            ->select([
                'id',
                'user_id',
                's2r_driver_enabler_alignment',
                'goal',
                'target',
            ])
            ->whereIn('user_id', $employeeIds)
            ->with([
                's2rDriver:id,driver_name',
                'user:id,name',
                'latestSelfReport',
            ])
            ->orderBy('s2r_driver_enabler_alignment')
            ->orderBy('user_id')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['Employee Performance Report'],
            [
                'S2R Driver / Enabler',
                'Goal',
                'Goal Target',
                'Achieved / Progress',
                'Owner',
            ],
        ];
    }

    public function map($goal): array
    {

        return [
            $goal->s2rDriver->driver_name ?? 'No Driver',
            $goal->goal ?? '',
            $goal->target ?? '',
            $goal->latestSelfReport->progress_against_goal ?? 'No Self Report',
            $goal->user->name ?? 'N/A',    
        ];
    }

  public function styles(Worksheet $sheet): array
{
    return [
        // Employee Performance Report title
        1 => [
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ],

        // Column headers
        2 => [
            'font' => [
                'bold' => true,
            ],
        ],
    ];
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {

            $sheet = $event->sheet->getDelegate();
            $lastRow = $sheet->getHighestRow();

            if ($lastRow < 2) {
                return;
            }

            $startRow = 2;
            $previousDriver = $sheet->getCell('A2')->getValue();

            for ($row = 3; $row <= $lastRow + 1; $row++) {

                $currentDriver = $row <= $lastRow
                    ? $sheet->getCell("A{$row}")->getValue()
                    : null;

                if (
                    $row > $lastRow ||
                    $currentDriver !== $previousDriver
                ) {
                    $endRow = $row - 1;

                    if ($endRow > $startRow) {
                        $sheet->mergeCells(
                            "A{$startRow}:A{$endRow}"
                        );
                    }

                    $sheet->getStyle("A{$startRow}:A{$endRow}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER);

                    if ($row <= $lastRow) {
                        $startRow = $row;
                        $previousDriver = $currentDriver;
                    }
                }
            }
        },
    ];
}
}
