<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeCombineReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $teacherRoles = [21, 26, 27, 28];
    protected $adminRoles = [19, 22, 23, 29];

    public function collection()
    {
        return User::with('roles')
            ->whereHas('roles', function ($query) {
                $query->whereIn('roles.id', $this->teacherRoles);
            })
            ->whereHas('roles', function ($query) {
                $query->whereIn('roles.id', $this->adminRoles);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Teaching Role',
            'Admin Role',
            'User Name',
            'Designation',
            'Faculty',
            'Department',
            'Teacher Score',
            'Admin Score',
            'Combined Score',
            'Rating'
        ];
    }

    public function map($user): array
    {
        $facultyName = Faculty::where('id', (int) $user->faculty)->value('name') ?? 'N/A';
        $departmentName = Department::where('id', (string) $user->department_id)->value('name') ?? 'N/A';

        $userRoles = $user->roles;

        $teachingRoleNames = [
            'Teacher',
            'Assistant Professor',
            'Associate Professor',
            'Professor',
            'Demonstrator',
        ];

        // Get Teaching Role(s)
        $teachingRoles = $userRoles
            ->filter(function ($role) use ($teachingRoleNames) {
                return in_array($role->name, $teachingRoleNames);
            })
            ->pluck('name')
            ->toArray();

        // Get Admin Role(s)
        $adminRoles = $userRoles
            ->filter(function ($role) use ($teachingRoleNames) {
                return !in_array($role->name, $teachingRoleNames);
            })
            ->pluck('name')
            ->toArray();

        $teacherScore = 0;
        $adminScore = 0;

        $totalWeightedScore = 0;
        $totalWeight = 0;

        foreach ($userRoles as $role) {

            $weight = $role->weightage ?? 0;

            // TEACHER
            if (in_array($role->id, $this->teacherRoles)) {

                $score = $user->as_teacher_score ?? 0;

                $teacherScore = $score;

                $totalWeightedScore += $score * $weight / 100;
                $totalWeight += $weight;
            }

            // ADMIN
            if (in_array($role->id, $this->adminRoles)) {

                $score = $user->as_admin_score ?? 0;

                $adminScore = $score;

                $totalWeightedScore += $score * $weight / 100;
                $totalWeight += $weight;
            }
        }

        $combinedScore = $totalWeight > 0
            ? round($totalWeightedScore / ($totalWeight / 100), 2)
            : 0;

        return [
            // Teaching Role
            implode(' | ', $teachingRoles),

            // Admin Role
            implode(' | ', $adminRoles),

            // User Name
            $user->name,

            // Designation
            $user->job_title,

            // Faculty
            $facultyName,

            // Department
            $departmentName,

            // Scores
            $teacherScore,
            $adminScore,
            $combinedScore,

            // Rating
            $this->calculateRating($combinedScore)
        ];
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