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
    protected $kpaWeights = [];
    protected $indicatorScores = [];
    protected $facultyList = [];
    protected $departmentList = [];

    public function __construct()
    {
        /*
        |--------------------------------------------------------------------------
        | KPA List
        |--------------------------------------------------------------------------
        */
        $this->kpaList = KeyPerformanceArea::pluck(
            'performance_area',
            'id'
        )->toArray();

        /*
        |--------------------------------------------------------------------------
        | Faculty List
        |--------------------------------------------------------------------------
        */
        $this->facultyList = Faculty::pluck('name', 'id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | Department List
        |--------------------------------------------------------------------------
        */
        $this->departmentList = Department::pluck('name', 'id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | Role KPA Weightages
        |--------------------------------------------------------------------------
        |
        | Load everything once instead of querying inside map().
        |
        */
        $this->kpaWeights = DB::table('role_kpa_assignments')
            ->select(
                'role_id',
                'key_performance_area_id',
                'kpa_weightage'
            )
            ->get()
            ->groupBy('role_id')
            ->map(function ($items) {
                return $items
                    ->groupBy('key_performance_area_id')
                    ->map(function ($kpaItems) {
                        return (float) $kpaItems->first()->kpa_weightage;
                    })
                    ->toArray();
            })
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Indicator Scores
        |--------------------------------------------------------------------------
        |
        | Instead of running:
        |
        | IndicatorsPercentage::where(...)->sum()
        | IndicatorsPercentage::where(...)->count()
        |
        | for every User / Role / KPA,
        | aggregate everything in ONE query.
        |
        */
        $this->indicatorScores = IndicatorsPercentage::query()
            ->select(
                'employee_id',
                'role_id',
                'key_performance_area_id',
                DB::raw('SUM(score) as total_score'),
                DB::raw('COUNT(*) as indicator_count')
            )
            ->groupBy(
                'employee_id',
                'role_id',
                'key_performance_area_id'
            )
            ->get()
            ->keyBy(function ($item) {
                return $item->employee_id
                    . '_' .
                    $item->role_id
                    . '_' .
                    $item->key_performance_area_id;
            });
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
        $kpaHeadings = [];

        foreach ($this->kpaList as $kpaName) {
            $kpaHeadings[] = $kpaName . ' Weighted Score';
        }

        return array_merge(
            [
                'Role',
                'User Name',
                'Designation',
                'Faculty',
                'Department'
            ],
            $kpaHeadings,
            [
                'Total Score',
                'Rating'
            ]
        );
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
        $facultyName = $this->facultyList[$user->faculty] ?? 'N/A';

        /*
        |--------------------------------------------------------------------------
        | Department
        |--------------------------------------------------------------------------
        */
        $departmentName = $this->departmentList[$user->department_id] ?? 'N/A';

        foreach ($user->roles as $role) {

            /*
            |--------------------------------------------------------------------------
            | Get role weightages from preloaded array
            |--------------------------------------------------------------------------
            */
            $roleWeights = $this->kpaWeights[$role->id] ?? [];

            $row = [
                $role->name,
                $user->name,
                $user->job_title,
                $facultyName,
                $departmentName
            ];

            $weightedSum = 0;

            /*
            |--------------------------------------------------------------------------
            | KPA Calculation
            |--------------------------------------------------------------------------
            */
            foreach ($this->kpaList as $kpaId => $kpaName) {

                $key = $user->id
                    . '_'
                    . $role->id
                    . '_'
                    . $kpaId;

                $data = $this->indicatorScores[$key] ?? null;

                /*
                |--------------------------------------------------------------------------
                | Normalize
                |--------------------------------------------------------------------------
                */
                if ($data && $data->indicator_count > 0) {
                    $normalized = $data->total_score / $data->indicator_count;
                } else {
                    $normalized = 0;
                }

                /*
                |--------------------------------------------------------------------------
                | Weight
                |--------------------------------------------------------------------------
                */
                $weight = $roleWeights[$kpaId] ?? 0;

                $weightFactor = $weight / 100;

                /*
                |--------------------------------------------------------------------------
                | Weighted KPA Score
                |--------------------------------------------------------------------------
                */
                $weightedKpaScore = $normalized * $weightFactor;

                /*
                |--------------------------------------------------------------------------
                | Add to total
                |--------------------------------------------------------------------------
                */
                $weightedSum += $weightedKpaScore;

                /*
                |--------------------------------------------------------------------------
                | Excel KPA Column
                |--------------------------------------------------------------------------
                */
                $row[] = ($data || $weight > 0)
                    ? round((float) $weightedKpaScore, 1)
                    : 0;
            }

            /*
            |--------------------------------------------------------------------------
            | Final Score
            |--------------------------------------------------------------------------
            */
            $totalScore = round($weightedSum, 1);

            $row[] = $totalScore > 0
                ? $totalScore
                : 0;

            /*
            |--------------------------------------------------------------------------
            | Rating
            |--------------------------------------------------------------------------
            */
            $row[] = $this->calculateRating($totalScore);

            $rows[] = $row;
        }

        return $rows;
    }

    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */
    private function calculateRating($totalScore)
    {
        if ($totalScore >= 90) {
            return 'OS';
        }

        if ($totalScore >= 80) {
            return 'EE';
        }

        if ($totalScore >= 70) {
            return 'ME';
        }

        if ($totalScore >= 60) {
            return 'NI';
        }

        return 'BE';
    }
}