<?php

use App\Models\User;
use App\Models\IndicatorsPercentage;
use App\Models\Department;
use App\Models\FacultyTarget;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

if (!function_exists('hodTopPerformers')) {
    function hodTopPerformers()
    {
        $roleIds = Role::whereIn('name', ['Teacher','Professor','Associate Professor','Assistant Professor'])->pluck('id')->toArray();
        $departmentId = auth()->user()->department_id;
        $department = Department::find($departmentId);
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
             ->role(['Teacher','Professor','Associate Professor','Assistant Professor'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return []; // return empty array if no employees
        }
        // 2️⃣ Get top 5 employees with avg score + eager load user
        $topEmployees = IndicatorsPercentage::select('employee_id','role_id', DB::raw('AVG(score) as avg_score'))
            ->with([
                'user:employee_id,name,email,job_title,work_location'
            ])
            ->whereIn('employee_id', $employeeIds)
            ->whereIn('role_id', $roleIds)
            ->groupBy('employee_id', 'role_id') 
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
    function hodHotIndicators($indicator_id,$role_id)
    {   $employee_id = auth()->user()->employee_id;
        $record = IndicatorsPercentage::where('employee_id', $employee_id)
            ->where('role_id', $role_id)->where('indicator_id', $indicator_id)
            ->orderBy('id')
            ->first();
    

        $avg = $record ? round($record->score, 1) : 0.00;

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
            ->groupBy('employee_id') 
            ->orderByDesc('avg_score')
            ->limit(5)           
            ->get();
            // 3️⃣ Transform data into array with label and color
            $result = $topEmployees->map(function ($item){    
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
    function deanHotIndicators($indicator_id,$role_id)
    {   
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
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
    $MP = MultidisciplinaryProjectsHODDean($employeeIds, $activeRoleId, 136);
    $CG = CommercialGainsCounsultancyResearchIncomeHODDean($employeeIds, $activeRoleId, 137);
    $PIP = PatentsIntellectualPropertyHODDean($employeeIds, $activeRoleId, 138);
    $RP = ResearchPublicationHODDean($employeeIds, $activeRoleId, 128);
  
    return [
        "RP" => [
            "title" => 'Research Publications',
            "cod" => 'RP',
            "target" => $RP['total_target'] ?? 0,
            "achieved" => $RP['total_achieved'] ?? 0,
            "percentage" => $RP['percentage'] ?? 0,
            "color" => $RP['color']?? '#000'
        ],
        "PIP" => [
            "title" => 'Patents & IP',
            "cod" => 'PIP',
            "target" => $PIP['total_target'] ?? 0,
            "achieved" => $PIP['total_achieved'] ?? 0,
            "percentage" => $PIP['percentage'] ?? 0,
            "color" => $PIP['color']?? '#000'
        ],
        "CG" => [
            "title" => 'Commercial Gains',
            "cod" => 'CG',
            "target" => $CG['total_target'] ?? 0,
            "achieved" => $CG['total_achieved'] ?? 0,
            "percentage" => $CG['percentage'] ?? 0,
            "color" => $CG['color']?? '#000'
        ],
        "MP" => [
            "title" => 'Multidisciplinary Projects',
            "cod" => 'MP',
            "target" => $MP['total_target'] ?? 0,
            "achieved" => $MP['total_achieved'] ?? 0,
            "percentage" => $MP['percentage'] ?? 0,
            "color" => $MP['color']?? '#000'
        ],
    ];

}
function MultidisciplinaryProjectsHODDean($employeeIds, $activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;
    if(in_array(getRoleName(activeRole()), ['HOD'])){
           $roleIds = Role::whereIn('name', ['Teacher','Professor','Associate Professor','Assistant Professor'])->pluck('id')->toArray();
            // 1️⃣ Get all employee_ids in the department
            $employeeIds = User::where('department_id', $departmentId)
                ->role(['Teacher','Professor','Associate Professor','Assistant Professor'])
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
    if(in_array(getRoleName(activeRole()), ['Dean'])){
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
             ->role(['HOD','Teacher','Professor','Associate Professor','Assistant Professor'])
            ->pluck('employee_id')
            ->filter()
            ->toArray();
        if (empty($employeeIds)) {
            return []; 
        }

    } 
    $facultyTargets = FacultyTarget::withCount([
        'achievementOfMultidisciplinaryProjectsTarget as multidisciplinary_projects_count' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicatorId);
        }
    ])
    ->whereIn('user_id', $employeeIds)
    ->where('form_status', 'OTHER')
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
function CommercialGainsCounsultancyResearchIncomeHODDean($employeeIds, $activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;
    if(in_array(getRoleName(activeRole()), ['HOD'])){
           $roleIds = Role::whereIn('name', ['Teacher','Professor','Associate Professor','Assistant Professor'])->pluck('id')->toArray();
            // 1️⃣ Get all employee_ids in the department
            $employeeIds = User::where('department_id', $departmentId)
                ->role(['Teacher','Professor','Associate Professor','Assistant Professor'])
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
    if(in_array(getRoleName(activeRole()), ['Dean'])){
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
             ->role(['HOD','Teacher','Professor','Associate Professor','Assistant Professor'])
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
        'commercialGainsCounsultancyTargets as commercialGainsCounsultancy_count' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicatorId);
        }
    ])
    ->whereIn('user_id', $employeeIds)
    ->where('form_status', 'OTHER')
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
function PatentsIntellectualPropertyHODDean($employeeIds, $activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;
    if(in_array(getRoleName(activeRole()), ['HOD'])){
           $roleIds = Role::whereIn('name', ['Teacher','Professor','Associate Professor','Assistant Professor'])->pluck('id')->toArray();
            // 1️⃣ Get all employee_ids in the department
            $employeeIds = User::where('department_id', $departmentId)
                ->role(['Teacher','Professor','Associate Professor','Assistant Professor'])
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
    if(in_array(getRoleName(activeRole()), ['Dean'])){
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
             ->role(['HOD','Teacher','Professor','Associate Professor','Assistant Professor'])
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
        'intellectualPropertyTargets as intellectualProperty_count' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicatorId);
        }
    ])
    ->whereIn('user_id', $employeeIds)
    ->where('form_status', 'OTHER')
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
function ResearchPublicationHODDean($employeeIds, $activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;
    if(in_array(getRoleName(activeRole()), ['HOD'])){
           $roleIds = Role::whereIn('name', ['Teacher','Professor','Associate Professor','Assistant Professor'])->pluck('id')->toArray();
            // 1️⃣ Get all employee_ids in the department
            $employeeIds = User::where('department_id', $departmentId)
                ->role(['Teacher','Professor','Associate Professor','Assistant Professor'])
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
    if(in_array(getRoleName(activeRole()), ['Dean'])){
        $roleIds = Role::whereIn('name', ['HOD'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        $employeeIds = User::where('faculty', $faculty)
             ->role(['HOD','Teacher','Professor','Associate Professor','Assistant Professor'])
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
        'researchPublicationTargets as researchPublication_count' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicatorId);
        }
    ])
    ->whereIn('user_id', $employeeIds)
    ->where('form_status', 'HOD')
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
        $roleIds = Role::whereIn('name', ['Teacher','Professor','Associate Professor','Assistant Professor'])->pluck('id')->toArray();
        $faculty = auth()->user()->faculty;
        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('faculty', $faculty)
             ->role(['Teacher','Professor','Associate Professor','Assistant Professor'])
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();
        if (empty($employeeIds)) {
            return []; // return empty array if no employees
        }

        // 2️⃣ Get top 5 employees with avg score + eager load user
        $topEmployees = IndicatorsPercentage::select('employee_id','role_id', DB::raw('AVG(score) as avg_score'))
            ->with([
                'user:employee_id,name,email,job_title,work_location,department_id',
                'user.department:id,name'
            ])
            ->whereIn('employee_id', $employeeIds)
            ->whereIn('role_id', $roleIds)
            ->groupBy('employee_id', 'role_id') 
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
        $faculty = auth()->user()->faculty;
        $hod_ids = User::where('faculty', $faculty)->role('HOD')->pluck('employee_id');
        $count_hod_ids = $hod_ids->count();   
        $record = IndicatorsPercentage::with([
                'user:id,employee_id,department_id,name',
                'user.department:id,name'
            ])
        ->whereIn('employee_id', $hod_ids)
            ->where('role_id', 22)->where('key_performance_area_id', $KpaId)
            ->where('indicator_category_id', $categoryId)->where('indicator_id', $indicatorId)
            ->orderBy('id')
            ->get();
       // dd($record);    
        $sumScore = $record->sum('score');    
        $avgScore = ($count_hod_ids > 0) ? round(($sumScore / $count_hod_ids), 2) : 0;

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



