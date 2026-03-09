<?php

use App\Models\User;
use App\Models\IndicatorsPercentage;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

if (!function_exists('hodTopPerformers')) {
    function hodTopPerformers()
    {
        $departmentId = auth()->user()->department_id;
        $department = Department::find($departmentId);
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();

        if (empty($employeeIds)) {
            return []; // return empty array if no employees
        }

        // 2️⃣ Get top 5 employees with avg score + eager load user
        $topEmployees = IndicatorsPercentage::select('employee_id', DB::raw('AVG(score) as avg_score'))
            ->with([
                'user:employee_id,name,email,job_title,work_location'
            ])
            ->whereIn('employee_id', $employeeIds)
            ->groupBy('employee_id')
            ->orderByDesc('avg_score')   // Sort by avg_score descending
            ->limit(5)                   // Take top 5
            ->get();

        // 3️⃣ Transform data into array with label and color
        $result = $topEmployees->map(function ($item) {
            $avg_score = round($item->avg_score, 2);

            if ($avg_score >= 90) {
                $color = 'primary';
                $label = 'OS';
            } elseif ($avg_score >= 80) {
                $color = 'success';
                $label = 'EE';
            } elseif ($avg_score >= 70) {
                $color = 'warning';
                $label = 'ME';
            } elseif ($avg_score >= 60) {
                $color = 'orange';
                $label = 'NI';
            } elseif ($avg_score >= 0) {
                $color = 'danger';
                $label = 'BE';
            } else {
                $color = 'secondary';
                $label = 'N/A';
            }

            return [
                'employee_id' => $item->employee_id,
                'name' => $item->user->name ?? null,
                'department' => $department->name ?? null,
                'location' => $item->user->work_location ?? null,
                'avg_score' => $avg_score,
                'label' => $label,
                'color' => $color,
            ];
        })->toArray();
        return $result;
    }
    
}
if (!function_exists('hodHotIndicators')) {
    function hodHotIndicators($indicator_id,$role_id)
    {   $employee_id = auth()->user()->employee_id;
        $record = IndicatorsPercentage::where('employee_id', $employee_id)
            ->where('role_id', $role_id)->where('indicator_id', $indicator_id)
            ->orderBy('id')
            ->first();
    

        $avg = $record ? round($record->score, 2) : 0.00;

        if ($avg >= 90) {
            $color = 'primary';
            $rating = 'OS';
        } elseif ($avg >= 80) {
            $color = 'success';
            $rating = 'EE';
        } elseif ($avg >= 70) {
            $color = 'warning';
            $rating = 'ME';
        } elseif ($avg >= 60) {
            $color = 'orange';
            $rating = 'NI';
        } elseif ($avg >= 0) {
            $color = 'danger';
            $rating = 'BE';
        } else {
            $color = 'secondary';
            $rating = 'N/A';
        }

        return [
            'avg' => $avg,
            'rating' => $rating,
            'color' => $color,
        ];
    }
    
}

