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
    protected $kpaList;

    public function __construct()
    {
        // KPA list (id => name)
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
            $kpaHeadings[] = $kpaName . ' Weighted Score';
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

        foreach ($user->roles as $role) {

            $facultyName = Faculty::where('id', (int) $user->faculty)->value('name') ?? 'N/A';
            $departmentName = Department::where('id', (string) $user->department_id)->value('name') ?? 'N/A';

            // Get weightages per role
            $kpaWeights = DB::table('role_kpa_assignments')
                ->where('role_id', $role->id)
                ->pluck('kpa_weightage', 'key_performance_area_id')
                ->toArray();

            $row = [
                $role->name,
                $user->name,
                $user->job_title,
                $facultyName,
                $departmentName
            ];

            $weightedSum = 0;

            foreach ($this->kpaList as $kpaId => $kpaName) {

                // Get KPA data
                $kpaQuery = IndicatorsPercentage::where('employee_id', $user->id)
                    ->where('role_id', $role->id)
                    ->where('key_performance_area_id', $kpaId);

                $totalScoreKpa = $kpaQuery->sum('score');
                $indicatorCount = $kpaQuery->count();

                // Normalize
                $normalized = $indicatorCount > 0
                    ? ($totalScoreKpa / $indicatorCount)
                    : 0;

                // Weight
                $weight = $kpaWeights[$kpaId] ?? 0;
                $weightFactor = $weight / 100;

                // Weighted KPA score
                $weightedKpaScore = $normalized * $weightFactor;

                // Add to total
                $weightedSum += $weightedKpaScore;

                // Excel column (weighted score per KPA)
                $row[] = round($weightedKpaScore, 2);
            }

            // Final Score
            $totalScore = round($weightedSum, 2);

            $row[] = $totalScore;
            $row[] = $this->calculateRating($totalScore);

            $rows[] = $row;
        }

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