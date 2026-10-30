<?php

use App\Models\ActiveRecord;
use App\Models\User;
use App\Models\IndicatorsPercentage;
use App\Models\Department;
use App\Models\FacultyClassAttendance;
use App\Models\FacultyMemberClass;
use App\Models\FacultyTarget;
use App\Models\Role;
use App\Models\Term;
use App\Models\UserTargetAchieved;
use App\Models\Years;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('hodTopPerformers')) {
    function hodTopPerformers()
    {
        $roleIds = Role::whereIn('name', ['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor', 'Non Phd AP','Demonstrator'])->pluck('id')->toArray();
        $departmentId = auth()->user()->department_id;
        $department = Department::find($departmentId);
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->role(['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor', 'Non Phd AP','Demonstrator'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return []; // return empty array if no employees
        }
        // 2️⃣ Get top 5 employees with avg score + eager load user
        $topEmployees = IndicatorsPercentage::select('employee_id', 'role_id', DB::raw('AVG(score) as avg_score'))
            ->with([
                'user:employee_id,name,email,job_title,work_location'
            ])
            ->whereIn('employee_id', $employeeIds)
            ->whereIn('role_id', $roleIds)
            ->where('year_id', $ActiveRecord->id)
            ->groupBy('employee_id', 'role_id')
            ->havingRaw('AVG(score) > ?', [60]) // Only average score greater than 60
            ->orderByDesc('avg_score')   // Sort by avg_score descending
            ->limit(5)                   // Take top 5
            ->get();

        // 3️⃣ Transform data into array with label and color
        $result = $topEmployees->map(function ($item) use ($department) {
            $avg_score = $item ? round($item->avg_score, 1) : 0.0;

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
                'role_id' => $item->role_id,
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
    function hodHotIndicators($indicator_id, $role_id)
    {
        $employee_id = auth()->user()->employee_id;
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        $record = IndicatorsPercentage::where('employee_id', $employee_id)
            ->where('role_id', $role_id)->where('indicator_id', $indicator_id)
            ->where('year_id', $ActiveRecord->id)
            ->orderBy('id')
            ->first();

        $avg = $record ? round($record->with_out_weight_score, 1) : 0.00;

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
if (!function_exists('deanTopPerformers')) {
    function deanTopPerformers()
    {
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        $employeeIds = User::where('faculty', $faculty)
            ->role(['HOD'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return [];
        }
        $topEmployees = IndicatorsPercentage::select('employee_id', DB::raw('AVG(score) as avg_score'))
            ->with([
                'user:employee_id,name,email,job_title,work_location,department_id',
                'user.department:id,name'
            ])
            ->whereIn('employee_id', $employeeIds)
            ->where('role_id', $roleIds)
            ->where('year_id', $ActiveRecord->id)
            ->groupBy('employee_id')
            ->havingRaw('AVG(score) > ?', [60]) // Only average score greater than 60
            ->orderByDesc('avg_score')
            ->limit(5)
            ->get();
        // 3️⃣ Transform data into array with label and color
        $result = $topEmployees->map(function ($item) {
            $avg_score = $item ? round($item->avg_score, 1) : 0.0;

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
                'department' => $item->user->department->name ?? null,
                'location' => $item->user->work_location ?? null,
                'avg_score' => $avg_score,
                'label' => $label,
                'color' => $color,
            ];
        })->toArray();

        return $result;

    }

}
if (!function_exists('deanHotIndicators')) {
    function deanHotIndicators($indicator_id, $role_id)
    {
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        $employeeIds = User::where('faculty', $faculty)
            ->role(['HOD'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return [];
        }

        $avg = IndicatorsPercentage::whereIn('employee_id', $employeeIds)
            ->where('indicator_id', $indicator_id)
            ->whereIn('role_id', $roleIds)
            ->where('year_id', $ActiveRecord->id)
            ->avg('score');

        $avg = $avg ? round($avg, 1) : 0.00;

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
function Research_Innovation_Commercialization_HOD_Dean($employeeIds, $activeRoleId, $indicator_id)
{
    $currentYear = SelectCurrentYear(1)->first(); 
    $MP = MultidisciplinaryProjectsHODDean($employeeIds, $activeRoleId, 136,$currentYear->id);
    $CG = CommercialGainsCounsultancyResearchIncomeHODDean($employeeIds, $activeRoleId, 137,$currentYear->id);
    $PIP = PatentsIntellectualPropertyHODDean($employeeIds, $activeRoleId, 138,$currentYear->id);
    $RP = ResearchPublicationHODDean($employeeIds, $activeRoleId, 128,$currentYear->id);

    return [
        "RP" => [
            "title" => 'Research Publications',
            "cod" => 'RP',
            "target" => $RP['total_target'] ?? 0,
            "achieved" => $RP['total_achieved'] ?? 0,
            "percentage" => $RP['percentage'] ?? 0,
            "color" => $RP['color'] ?? '#000'
        ],
        "PIP" => [
            "title" => 'Patents & IP',
            "cod" => 'PIP',
            "target" => $PIP['total_target'] ?? 0,
            "achieved" => $PIP['total_achieved'] ?? 0,
            "percentage" => $PIP['percentage'] ?? 0,
            "color" => $PIP['color'] ?? '#000'
        ],
        "CG" => [
            "title" => 'Commercial Gains',
            "cod" => 'CG',
            "target" => $CG['total_target'] ?? 0,
            "achieved" => $CG['total_achieved'] ?? 0,
            "percentage" => $CG['percentage'] ?? 0,
            "color" => $CG['color'] ?? '#000'
        ],
        "MP" => [
            "title" => 'Multidisciplinary Projects',
            "cod" => 'MP',
            "target" => $MP['total_target'] ?? 0,
            "achieved" => $MP['total_achieved'] ?? 0,
            "percentage" => $MP['percentage'] ?? 0,
            "color" => $MP['color'] ?? '#000'
        ],
    ];

}
function MultidisciplinaryProjectsHODDean($employeeIds, $activeRoleId, $indicatorId,$currentYear = null)
{
    $departmentId = auth()->user()->department_id;
    if (in_array(getRoleName(activeRole()), ['HOD'])) {
        $roleIds = Role::whereIn('name', ['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])->pluck('id')->toArray();
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->role(['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    if (in_array(getRoleName(activeRole()), ['Dean'])) {
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
            ->role(['HOD', 'Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return [];
        }

    }
    $facultyTargets = FacultyTarget::withCount([
        'achievementOfMultidisciplinaryProjectsTarget as multidisciplinary_projects_count' => function ($query) use ($indicatorId,$currentYear) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 3)
                ->where('year_id', $currentYear)
                ->where('indicator_id', $indicatorId);
        }
    ])
        ->whereIn('user_id', $employeeIds)
        ->where('form_status', 'OTHER')
        ->where('year_id', $currentYear)
        ->where('indicator_id', $indicatorId)
        ->get();
    $totalTarget = $facultyTargets->sum('target');
    $totalAchieved = $facultyTargets->sum('multidisciplinary_projects_count');
    // Calculate percentage safely
    $percentage = $totalTarget > 0 ? round(($totalAchieved / $totalTarget) * 100, 2) : 0;
    if ($percentage >= 90) {
        $color = 'primary';
    } elseif ($percentage >= 80) {
        $color = 'success';
    } elseif ($percentage >= 70) {
        $color = 'warning';
    } elseif ($percentage >= 60) {
        $color = 'orange';
    } elseif ($percentage >= 0) {
        $color = 'danger';
    } else {
        $color = 'secondary';
    }
    return [
        'total_target' => $totalTarget,
        'total_achieved' => $totalAchieved,
        'percentage' => $percentage,
        'color' => $color
    ];

}
function CommercialGainsCounsultancyResearchIncomeHODDean($employeeIds, $activeRoleId, $indicatorId,$currentYear = null)
{
    $departmentId = auth()->user()->department_id;
    if (in_array(getRoleName(activeRole()), ['HOD'])) {
        $roleIds = Role::whereIn('name', ['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])->pluck('id')->toArray();
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->role(['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    if (in_array(getRoleName(activeRole()), ['Dean'])) {
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
            ->role(['HOD', 'Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    $facultyTargets = FacultyTarget::withCount([
        'commercialGainsCounsultancyTargets as commercialGainsCounsultancy_count' => function ($query) use ($indicatorId,$currentYear) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 3)
                ->where('year_id', $currentYear)
                ->where('indicator_id', $indicatorId);
        }
    ])
        ->whereIn('user_id', $employeeIds)
        ->where('form_status', 'OTHER')
        ->where('year_id', $currentYear)
        ->where('indicator_id', $indicatorId)
        ->get();
    $totalTarget = $facultyTargets->sum('target');
    $totalAchieved = $facultyTargets->sum('commercialGainsCounsultancy_count');
    // Calculate percentage safely
    $percentage = $totalTarget > 0 ? round(($totalAchieved / $totalTarget) * 100, 2) : 0;
    if ($percentage >= 90) {
        $color = 'primary';
    } elseif ($percentage >= 80) {
        $color = 'success';
    } elseif ($percentage >= 70) {
        $color = 'warning';
    } elseif ($percentage >= 60) {
        $color = 'orange';
    } elseif ($percentage >= 0) {
        $color = 'danger';
    } else {
        $color = 'secondary';
    }
    return [
        'total_target' => $totalTarget,
        'total_achieved' => $totalAchieved,
        'percentage' => $percentage,
        'color' => $color
    ];

}
function PatentsIntellectualPropertyHODDean($employeeIds, $activeRoleId, $indicatorId,$currentYear = null)
{
    $departmentId = auth()->user()->department_id;
    if (in_array(getRoleName(activeRole()), ['HOD'])) {
        $roleIds = Role::whereIn('name', ['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])->pluck('id')->toArray();
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->role(['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    if (in_array(getRoleName(activeRole()), ['Dean'])) {
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
            ->role(['HOD', 'Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    $facultyTargets = FacultyTarget::withCount([
        'intellectualPropertyTargets as intellectualProperty_count' => function ($query) use ($indicatorId,$currentYear) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 3)
                ->where('year_id', $currentYear)
                ->where('indicator_id', $indicatorId);
        }
    ])
        ->whereIn('user_id', $employeeIds)
        ->where('form_status', 'OTHER')
        ->where('year_id', $currentYear)
        ->where('indicator_id', $indicatorId)
        ->get();
    $totalTarget = $facultyTargets->sum('target');
    $totalAchieved = $facultyTargets->sum('intellectualProperty_count');
    // Calculate percentage safely
    $percentage = $totalTarget > 0 ? round(($totalAchieved / $totalTarget) * 100, 2) : 0;
    if ($percentage >= 90) {
        $color = 'primary';
    } elseif ($percentage >= 80) {
        $color = 'success';
    } elseif ($percentage >= 70) {
        $color = 'warning';
    } elseif ($percentage >= 60) {
        $color = 'orange';
    } elseif ($percentage >= 0) {
        $color = 'danger';
    } else {
        $color = 'secondary';
    }
    return [
        'total_target' => $totalTarget,
        'total_achieved' => $totalAchieved,
        'percentage' => $percentage,
        'color' => $color
    ];

}
function ResearchPublicationHODDean($employeeIds, $activeRoleId, $indicatorId,$currentYear = null)
{
    $departmentId = auth()->user()->department_id;
    if (in_array(getRoleName(activeRole()), ['HOD'])) {
        $roleIds = Role::whereIn('name', ['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])->pluck('id')->toArray();
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->role(['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    if (in_array(getRoleName(activeRole()), ['Dean'])) {
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
            ->role(['HOD', 'Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return [
                'total_target' => 0,
                'total_achieved' => 0,
                'percentage' => 0,
                'color' => '#000'
            ];
        }

    }
    $facultyTargets = FacultyTarget::withCount([
        'researchPublicationTargets as researchPublication_count' => function ($query) use ($indicatorId,$currentYear) {
            $query->whereIn('form_status', ['RESEARCHER', 'DEAN'])
                ->where('status', 3)
                ->where('year_id', $currentYear)
                ->where('indicator_id', $indicatorId);
        }
    ])
        ->whereIn('user_id', $employeeIds)
        ->where('form_status', 'HOD')
        ->where('year_id', $currentYear)
        ->where('indicator_id', $indicatorId)
        ->get();
    $totalTarget = $facultyTargets->sum('target');
    $totalAchieved = $facultyTargets->sum('researchPublication_count');
    // Calculate percentage safely
    $percentage = $totalTarget > 0 ? round(($totalAchieved / $totalTarget) * 100, 2) : 0;
    if ($percentage >= 90) {
        $color = 'primary';
    } elseif ($percentage >= 80) {
        $color = 'success';
    } elseif ($percentage >= 70) {
        $color = 'warning';
    } elseif ($percentage >= 60) {
        $color = 'orange';
    } elseif ($percentage >= 0) {
        $color = 'danger';
    } else {
        $color = 'secondary';
    }
    return [
        'total_target' => $totalTarget,
        'total_achieved' => $totalAchieved,
        'percentage' => $percentage,
        'color' => $color
    ];

}
if (!function_exists('FacultyLevelToppers')) {
    function FacultyLevelToppers()
    {
        $roleIds = Role::whereIn('name', ['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP', 'Demonstrator'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('faculty', $faculty)
            ->role(['Teacher', 'Professor', 'Associate Professor', 'Assistant Professor','Non Phd AP', 'Demonstrator'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return []; // return empty array if no employees
        }

        // 2️⃣ Get top 5 employees with avg score + eager load user
        $topEmployees = IndicatorsPercentage::select('employee_id', 'role_id', DB::raw('AVG(score) as avg_score'))
            ->with([
                'user:employee_id,name,email,job_title,work_location,department_id',
                'user.department:id,name'
            ])
            ->whereIn('employee_id', $employeeIds)
            ->whereIn('role_id', $roleIds)
            ->where('year_id', $ActiveRecord->id)
            ->groupBy('employee_id', 'role_id')
            ->havingRaw('AVG(score) > ?', [60]) // Only average score greater than 60
            ->orderByDesc('avg_score')   // Sort by avg_score descending
            ->limit(5)                   // Take top 5
            ->get();

        // 3️⃣ Transform data into array with label and color
        $result = $topEmployees->map(function ($item) {
            $avg_score = $item ? round($item->avg_score, 1) : 0.0;

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
                'role_id' => $item->role_id,
                'name' => $item->user->name ?? null,
                'department' => $item->user->department->name ?? null,
                'location' => $item->user->work_location ?? null,
                'avg_score' => $avg_score,
                'label' => $label,
                'color' => $color,
            ];
        })->toArray();

        return $result;

    }

}
if (!function_exists('ResearchInnovationAndCommercialization')) {
    function ResearchInnovationAndCommercialization($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        $faculty = auth()->user()->faculty;
        $hod_ids = User::where('faculty', $faculty)->role('HOD')->pluck('employee_id');
        $count_hod_ids = $hod_ids->count();
        $record = IndicatorsPercentage::with([
            'user:id,employee_id,department_id,name',
            'user.department:id,name'
        ])
            ->whereIn('employee_id', $hod_ids)
            ->where('role_id', 22)->where('key_performance_area_id', $KpaId)
            ->where('year_id', $ActiveRecord->id)
            ->where('indicator_category_id', $categoryId)->where('indicator_id', $indicatorId)
            ->orderBy('id')
            ->get();
        // dd($record);    
        $sumScore = $record->sum('score');
        $avgScore = ($count_hod_ids > 0) ? round(($sumScore / $count_hod_ids), 2) : 0;
        $avgScore = min($avgScore, 100);

        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId);
        $weight = $indicatorWeight['weightage'] ?? 0;
        $weightedScore = ($avgScore * $weight) / 100;

        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $avgScore
        );

        return [
            'records' => $record,
            'faculty_avg_percentage' => $avgScore,
            'weighted_score' => $weightedScore,
        ];
    }
}

if (!function_exists('ResearchInnovationAndCommercializationYear')) {
    function ResearchInnovationAndCommercializationYear($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId, $currentYear=null)
    {
        $ActiveRecord = ActiveRecord::where('status', 1)->first();
        $faculty = auth()->user()->faculty;
        $faculty_employee_id = auth()->user()->employee_id;
       // $hod_ids = User::where('faculty', $faculty)->role('HOD')->pluck('employee_id');

        $hod_ids = User::where('faculty', $faculty)
            ->role('HOD')
            ->whereHas('department', function ($query) {
                $query->where('id', '!=', 609);
            })
            ->pluck('employee_id');
        $hod_ids = $hod_ids->diff([$faculty_employee_id])->values();    
        $count_hod_ids = $hod_ids->count();
        $record = IndicatorsPercentage::with([
            'user:id,employee_id,department_id,name',
            'user.department:id,name'
        ])
            ->whereIn('employee_id', $hod_ids)
            ->where('year_id', $ActiveRecord->id)
            ->where('role_id', 22)->where('key_performance_area_id', $KpaId)
            ->where('indicator_category_id', $categoryId)->where('indicator_id', $indicatorId)
            ->orderBy('id')
            ->get();    
        $sumScore = $record->sum('with_out_weight_score');
        $avgScore = ($count_hod_ids > 0) ? round(($sumScore / $count_hod_ids), 2) : 0;
        $avgScore = min($avgScore, 100);

        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId);
        $weight = $indicatorWeight['weightage'] ?? 0;
        $weightedScore = ($avgScore * $weight) / 100;

        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $avgScore,
            $currentYear
        );

        return [
            'records' => $record,
            'faculty_avg_percentage' => $avgScore,
            'weighted_score' => $weightedScore,
        ];
    }
}

function getPublicationMetrics($doi)
{
    try {

        if (empty($doi)) {
            return null;
        }

        // Remove unwanted prefixes
        $doi = trim($doi);

        $doi = str_replace([
            'https://doi.org/',
            'http://doi.org/',
            'http://dx.doi.org/',
            'https://dx.doi.org/',
        ], '', $doi);

        $url = "https://api.openalex.org/works/https://doi.org/" . $doi;

        $response = Http::timeout(30)
            ->acceptJson()
            ->get($url);

        if (!$response->successful()) {
            return null;
        }

        $paper = $response->json();

        return [

            'doi' => $doi,

            'title' => $paper['display_name'] ?? null,

            'publication_year' => $paper['publication_year'] ?? null,

            'publication_date' => $paper['publication_date'] ?? null,

            'citation_count' => $paper['cited_by_count'] ?? 0,

            'fwci' => $paper['fwci'] ?? 0,

            'is_highly_cited' =>
                $paper['citation_normalized_percentile']['is_in_top_10_percent']
                ?? false,

            'is_top_1_percent' =>
                $paper['citation_normalized_percentile']['is_in_top_1_percent']
                ?? false,

            'counts_by_year' =>
                $paper['counts_by_year'] ?? [],

            'open_access' =>
                $paper['open_access']['is_oa'] ?? false,

            'journal' =>
                $paper['primary_location']['source']['display_name']
                ?? null,

            'publisher' =>
                $paper['primary_location']['source']['host_organization_name']
                ?? null,

            'authors' => collect($paper['authorships'] ?? [])
                ->pluck('author.display_name')
                ->values(),

            'concepts' => collect($paper['concepts'] ?? [])
                ->pluck('display_name')
                ->values(),

            'awards' => $paper['awards'] ?? [],

            'raw' => $paper

        ];

    } catch (\Exception $e) {

        return [
            'error' => true,
            'message' => $e->getMessage()
        ];
    }
}
if (!function_exists('SelectCurrentTerm')) {
    function SelectCurrentTerm()
    {
        return Term::where('status', '1')->get();
    }
}

if (!function_exists('SelectCurrentYear')) {
    function SelectCurrentYear($active = null)
    {
        $query = Years::query();

        if ($active !== null) {
            $query->where('active', $active);
        }

        return $query->orderByDesc('year')->get();
    }
}
if (!function_exists('SelectAllTerm')) {
    function SelectAllTerm()
    {
        return Term::all();
    }
}
if (! function_exists('saveUserTargetAchieved')) {
    function saveUserTargetAchieved(
        $employId,
        $roleId,
        $indicatorId,
        $yearId,
        $target,
        $acheived
    ) {
        return UserTargetAchieved::updateOrCreate(
            [
                'employ_id'    => $employId,
                'role_id'      => $roleId,
                'indicator_id' => $indicatorId,
                'year_id'      => $yearId,
            ],
            [
                'target'   => $target,
                'acheived' => $acheived,
            ]
        );
    }
}
if (!function_exists('getManagerRole')) {
    function getManagerRole()
    {
        $user = Auth::user();

        if (!$user || !$user->manager_id) {
            return null;
        }

        $manager = User::with('roles')->find($user->manager_id);

        if (!$manager) {
            return null;
        }

        if ($manager->hasRole('HOD')) {
            return 'HOD';
        }

        if ($manager->hasRole('Dean')) {
            return 'Dean';
        }

        return null;
    }
}

if (!function_exists('myClassesUG')) {
    function myClassesUG($activeRoleId, $term = null, $user = null)
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return [
                'classes' => collect(),
                'validClasses' => collect(),
                'totalCourses' => 0,
                'courseLoadScore' => 60,
                'totalPassPercentage' => 0,
                'totalAverageMarks' => 0,
                'averagePassPercentage' => 0,
                'averageStudentScore' => 0,
                'weightedCourseLoad' => 0,
                'weightedPassScore' => 0,
                'weightedMarksScore' => 0,
            ];
        }
        
        $roleName = activeRole();

        $isProgramLeader = in_array($roleName, [
            'program leader ug',
            'program leader pg',
        ], true);

        $programNames = [];
        $facultyIds = [];

        if ($isProgramLeader) {
            $programNames = \App\Models\Program::query()
                ->where('leader_id', $user->employee_id)
                ->distinct()
                ->pluck('program_name')
                ->all();

            $facultyIds = \App\Models\User::query()
                ->where('department_id', $user->department_id)
                ->whereNotNull('faculty_id')
                ->distinct()
                ->pluck('faculty_id')
                ->all();
        }

        $classes = \App\Models\FacultyMemberClass::query()
            ->where('career_code', 'UG')
            ->when($term !== null, function ($query) use ($term) {
                $query->where('term_id', $term);
            })
            ->when($isProgramLeader, function ($query) use (
                $programNames,
                $facultyIds
            ) {
                // No matching program/faculty means no results.
                $query->whereIn('faculty_id', $facultyIds)
                    ->whereHas('attendances', function ($attendanceQuery) use (
                        $programNames
                    ) {
                        $attendanceQuery->whereIn(
                            'program_name',
                            $programNames
                        );
                    });
            })
            ->with([
                'attendances' => function ($query) use (
                    $isProgramLeader,
                    $programNames
                ) {
                    $query->when($isProgramLeader, function ($attendanceQuery) use (
                        $programNames
                    ) {
                        $attendanceQuery->whereIn(
                            'program_name',
                            $programNames
                        );
                    })
                    ->orderByDesc('class_date');
                }
            ])
            ->get();  

        // Exclude classes without students from score calculations.
        $validClasses = $classes
            ->filter(function ($class) {
                return $class->attendances->sum('total_students') > 0;
            })
            ->values();

        $totalCourses = $validClasses->count();

        $totalPassPercentage = $validClasses->sum(
            fn ($class) => (float) ($class->passing_percentage ?? 0)
        );

        $totalAverageMarks = $validClasses->sum(
            fn ($class) => (float) ($class->average_marks ?? 0)
        );

        $averagePassPercentage = $validClasses->isNotEmpty()
            ? $validClasses->avg(
                fn ($class) => (float) ($class->passing_percentage ?? 0)
            )
            : 0;

        $averageStudentScore = $validClasses->isNotEmpty()
            ? $validClasses->avg(
                fn ($class) => (float) ($class->average_marks ?? 0)
            )
            : 0;

        $courseLoadScore = $totalCourses > 3
            ? 100
            : ($totalCourses === 3 ? 80 : 60);

        $weights = [
            'course_load' => getRoleWeightage(
                $activeRoleId,
                'indicator',
                122
            )['weightage'] ?? 0,

            'pass' => getRoleWeightage(
                $activeRoleId,
                'indicator',
                185
            )['weightage'] ?? 0,

            'marks' => getRoleWeightage(
                $activeRoleId,
                'indicator',
                186
            )['weightage'] ?? 0,
        ];

        return [
            'classes' => $classes,
            'validClasses' => $validClasses,
            'totalCourses' => $totalCourses,
            'courseLoadScore' => $courseLoadScore,
            'totalPassPercentage' => $totalPassPercentage,
            'totalAverageMarks' => $totalAverageMarks,
            'averagePassPercentage' => $averagePassPercentage,
            'averageStudentScore' => $averageStudentScore,

            'weightedCourseLoad' => (
                $courseLoadScore * $weights['course_load']
            ) / 100,

            'weightedPassScore' => (
                $averagePassPercentage * $weights['pass']
            ) / 100,

            'weightedMarksScore' => (
                $averageStudentScore * $weights['marks']
            ) / 100,
        ];
    }
}

function myDepartmentClassesAttendanceRecordPGUG(
    $employeeId,
    $activeRoleId,
    $activeTermId
) {
    $user = $user ?? auth()->user();
    $departmentId = auth()->user()->department_id;
    $roleName = activeRole();
    $isProgramLeader = [
        'program leader ug' => 'UG',
        'program leader pg' => 'PG',
    ][$roleName] ?? null;
    $programNames = [];    
    if ($isProgramLeader) {
            $programNames = \App\Models\Program::query()
                ->where('leader_id', $user->employee_id)
                ->distinct()
                ->pluck('program_name')
                ->all();

        }    

    /*
    |--------------------------------------------------------------------------
    | Get all faculty members of HOD's department
    |--------------------------------------------------------------------------
    */
    $facultyUsers = User::where('department_id', $departmentId)
        ->whereNotNull('faculty_id')
        ->get([
            'faculty_id',
            'name'
        ]);

    if ($facultyUsers->isEmpty()) {
        return collect();
    }

    /*
    |--------------------------------------------------------------------------
    | Faculty IDs
    |--------------------------------------------------------------------------
    */
    $facultyIds = $facultyUsers
        ->pluck('faculty_id')
        ->unique()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Faculty names indexed by faculty_id
    |--------------------------------------------------------------------------
    */
    $facultyNames = $facultyUsers
        ->unique('faculty_id')
        ->keyBy('faculty_id');

    /*
    |--------------------------------------------------------------------------
    | Get all classes + attendance counts in ONE query
    |--------------------------------------------------------------------------
    */
    $classes = FacultyMemberClass::query()
        ->when(
            $isProgramLeader,
            function ($query) use ($isProgramLeader) {
                $query->where('career_code', $isProgramLeader);
            },
            function ($query) {
                $query->where('career_code', 'UG');
            }
        )
        ->whereIn(
            'faculty_member_classes.faculty_id',
            $facultyIds
        )
        ->where(
            'faculty_member_classes.term_id',
            $activeTermId
        )

        ->leftJoinSub(
            FacultyClassAttendance::query()
                ->select(
                    'class_id',
                    DB::raw('COUNT(*) as total_rows'),
                    DB::raw(
                        'SUM(CASE WHEN att_marked = 1 THEN 1 ELSE 0 END) as class_held_count'
                    ),
                    DB::raw(
                        'SUM(CASE WHEN att_marked = 0 THEN 1 ELSE 0 END) as class_not_held_count'
                    )
                )->when($isProgramLeader, function ($query) use ($programNames) {
                        $query->whereIn('program_name', $programNames);
                    })
                ->groupBy('class_id'),

            'attendance_counts',

            'attendance_counts.class_id',
            '=',
            'faculty_member_classes.c_class_id'
        )

        ->select([
            'faculty_member_classes.*',

            DB::raw(
                'COALESCE(attendance_counts.total_rows, 0) as total_rows'
            ),

            DB::raw(
                'COALESCE(attendance_counts.class_held_count, 0) as class_held_count'
            ),

            DB::raw(
                'COALESCE(attendance_counts.class_not_held_count, 0) as class_not_held_count'
            ),
        ])

        ->get();

    /*
    |--------------------------------------------------------------------------
    | Format result
    |--------------------------------------------------------------------------
    */
    return $classes->map(function ($class) use ($facultyNames) {

        $totalRows = (int) $class->total_rows;
        $heldCount = (int) $class->class_held_count;
        $notHeldCount = (int) $class->class_not_held_count;

        /*
        |--------------------------------------------------------------------------
        | Held percentage
        |--------------------------------------------------------------------------
        */
        $class->held_percentage = $class->class_held_count >= 16 ? 100 : ($class->total_rows ? round(($class->class_held_count / $class->total_rows) * 100, 2) : 0);

        /*
        |--------------------------------------------------------------------------
        | Not held percentage
        |--------------------------------------------------------------------------
        */
        $class->not_held_percentage = $totalRows > 0
            ? round(($notHeldCount / $totalRows) * 100, 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Faculty name
        |--------------------------------------------------------------------------
        */
        $faculty = $facultyNames->get($class->faculty_id);

        $class->faculty_name = $faculty?->name ?? 'N/A';

        /*
        |--------------------------------------------------------------------------
        | Program
        |--------------------------------------------------------------------------
        |
        | Keep null if program is not available from
        | faculty_member_classes.
        |
        */
        $class->program = null;

        return $class;
    });
}