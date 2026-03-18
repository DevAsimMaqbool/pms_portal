<?php

namespace App\Exports;

use App\Models\User;
use App\Models\IndicatorsPercentage;
use App\Models\KeyPerformanceArea;
use App\Models\Faculty;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeKpaReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kpaList;

    public function __construct()
    {
        // Fetch all KPAs (id => performance_area)
        $this->kpaList = KeyPerformanceArea::pluck('performance_area', 'id')->toArray();
    }

    public function collection()
    {
        return User::with(['roles', 'facultyyy', 'departmentttt'])
            ->whereHas('indicatorsPercentages')
            ->get();
    }

    public function headings(): array
    {
        $kpaHeadings = [];
        foreach ($this->kpaList as $kpaName) {
            $kpaHeadings[] = $kpaName . ' Total Score';
        }

        return array_merge([
            'Role',
            'User Name',
            'Designation',
            'Faculty',
            'Department'
        ], $kpaHeadings, [
            'Total Score',
            'Rating'
        ]);
    }

    public function map($user): array
    {
        $rows = [];

        // Loop through all roles for the user
        foreach ($user->roles as $role) {

            $facultyName = Faculty::where('id', (int) $user->faculty)->value('name') ?? 'N/A';
            $departmentName = Department::where('id', (string) $user->department_id)->value('name') ?? 'N/A';

            // Filter KPAs by this role
            $kpaScores = IndicatorsPercentage::where('employee_id', $user->id)
                ->where('role_id', $role->id)
                ->groupBy('key_performance_area_id')
                ->selectRaw('key_performance_area_id, SUM(score) as total_score')
                ->pluck('total_score', 'key_performance_area_id')
                ->toArray();

            $row = [
                $role->name,
                $user->name,
                $user->job_title,
                $facultyName,
                $departmentName
            ];

            $allScores = [];

            foreach ($this->kpaList as $kpaId => $kpaName) {
                $score = $kpaScores[$kpaId] ?? null;
                $row[] = $score ?? 0;

                if ($score !== null) {
                    $allScores[] = $score;
                }
            }

            $totalScore = count($allScores) > 0 ? array_sum($allScores) / count($allScores) : 0;

            $row[] = round($totalScore, 2);
            $row[] = $this->calculateRating($totalScore);

            $rows[] = $row;
        }

        // Return only the first row? Excel expects 1 row per map call
        // So we flatten rows for the export by overriding FromCollection
        return $rows;
    }

    private function calculateRating($totalScore)
    {
        if ($totalScore >= 90)
            return 'OS';
        if ($totalScore >= 80)
            return 'EE';
        if ($totalScore >= 70)
            return 'ME';
        if ($totalScore >= 60)
            return 'NI';
        return 'BE';
    }
}