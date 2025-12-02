<?php

//namespace App\Helpers;

use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\CompletionOfCourseFolder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\RoleKpaAssignment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Models\FacultyMemberClass;
use App\Models\FacultyTarget;

if (!function_exists('getResponse')) {
    function getResponse($data, $token, $message, $status): array
    {
        $responseResults = [
            'data' => $data,
            'token' => $token,
            'message' => $message,
            'status' => $status,
        ];
        return $responseResults;
    }
}
if (!function_exists('apiResponse')) {
    /**
     * Return a standardized API response.
     *
     * @param string $apimessage
     * @param mixed  $apidata
     * @param bool   $apistatusFlag
     * @param int    $apihttpStatus
     * @param string|null $token
     * @return JsonResponse
     */
    function apiResponse(string $apimessage, $apidata = [], bool $apistatusFlag = true, int $apihttpStatus = 200, string $token = null): JsonResponse
    {
        return response()->json([
            'data' => $apidata,
            'status' => $apistatusFlag,
            'message' => $apimessage,
            'token' => $token,
        ], $apihttpStatus);
    }
}

function _userCannot(string|array ...$permissions): bool
{
    $permissions = Arr::flatten($permissions);

    return !Auth::user()->can($permissions);
}
function _permissionErrorMessage(): string
{
    return __('You don`t have permission to perform this task.');
}

function sendOtp($user)
{
    $currentTime = Carbon::now();
    $expiresAt = $user->two_factor_expires_at ? Carbon::parse($user->two_factor_expires_at) : null;

    if ($expiresAt && $currentTime->lessThan($expiresAt)) {
        return [
            'success' => false,
            'message' => "OTP has already been sent. Please wait {$expiresAt->diffInSeconds($currentTime)} seconds before requesting again.",
            'status' => 429
        ];
    }

    $otp = random_int(100000, 999999);
    $user->update([
        'two_factor_code' => $otp,
        'two_factor_expires_at' => $currentTime->addMinutes(1), // OTP valid for 1 minute
    ]);

    return [
        'success' => true,
        'otp' => $otp,
        'status' => 201,
        'message' => "OTP has been sent to your email."
    ];
}

function getUserTree($UserID, $level, $manager)
{
    $user = User::where(function ($query) use ($UserID, $level, $manager) {
        $query->where('manager_id', $UserID)
            ->orWhere('level', $level)
            ->orWhere('id', $manager);
    })
        ->where('id', '!=', Auth::id())
        ->get();

    return $user;
}

function getUserLevel($UserID)
{
    $user = User::where('id', $UserID)->firstOrFail();

    return $user->level;
}

function getRoleAssignments(string $roleName, ?int $kapcid = null, $form = null)
{
    $roleId = Role::where('name', $roleName)->value('id');
    ;
    if (!$roleId) {
        return collect(); // return empty if user doesn't have that role
    }

    $assignments = RoleKpaAssignment::with([
        'kpa',
        'category' => function ($q) {
            $q->where('status', 1);
        },
        'indicator' => function ($q) {
            $q->where('status', 1)->with('indicatorForm');
        }
    ])
        ->where('role_id', $roleId)
        ->when($form == 1, function ($query) {
            $query->where('form_status', 1);
        })
        ->when($kapcid !== null, function ($query) use ($kapcid) {
            $query->where('key_performance_area_id', $kapcid);
        })
        ->get();

    return $assignments->filter(fn($a) => $a->category && $a->indicator) // ✅ skip nulls
        ->groupBy('kpa.id')
        ->map(function ($kpaGroup) {
            $kpa = $kpaGroup->first()->kpa;

            return [
                'id' => $kpa->id,
                'performance_area' => $kpa->performance_area,
                'kpa_weightage' => $kpaGroup->first()->kpa_weightage,
                'created_by' => $kpa->created_by,
                'updated_by' => $kpa->updated_by,
                'created_at' => $kpa->created_at,
                'updated_at' => $kpa->updated_at,
                'category' => $kpaGroup->groupBy('category.id')->map(function ($catGroup) {
                    $category = $catGroup->first()->category;

                    if (!$category) {
                        return null; // ✅ safeguard
                    }

                    return [
                        'id' => $category->id,
                        'key_performance_area_id' => $category->key_performance_area_id,
                        'indicator_category' => $category->indicator_category,
                        'indicator_category_weightage' => $catGroup->first()->indicator_category_weightage,
                        'cat_icon' => $category->cat_icon,
                        'cat_short_code' => $category->cat_short_code,
                        'created_by' => $category->created_by,
                        'updated_by' => $category->updated_by,
                        'created_at' => $category->created_at,
                        'updated_at' => $category->updated_at,
                        'indicator' => $catGroup
                            ->filter(fn($item) => $item->indicator) // ✅ skip null indicators
                            ->map(function ($item) {
                                $indicator = $item->indicator;

                                return [
                                    'id' => $indicator->id,
                                    'indicator_category_id' => $indicator->indicator_category_id,
                                    'indicator' => $indicator->indicator,
                                    'indicator_weightage' => $item->indicator_weightage,
                                    'icon' => $indicator->icon,
                                    'short_code' => $indicator->short_code,
                                    'created_by' => $indicator->created_by,
                                    'updated_by' => $indicator->updated_by,
                                    'created_at' => $indicator->created_at,
                                    'updated_at' => $indicator->updated_at,
                                    'indicator_form' => $indicator->indicatorForm ?? [],
                                ];
                            })->values()
                    ];
                })->filter()->values() // ✅ remove null categories
            ];
        })->values();
}


function icons()
{
    return [
        'ti tabler-star',
        'ti tabler-heart',
        'ti tabler-award',
        'ti tabler-book',
        'ti tabler-chart-bar',
        'ti tabler-rocket',
        'ti tabler-star',
        'ti tabler-device-laptop'
    ];
}

function myClassesAttendance($facultyId)
{
    return FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc'); // latest attendance first
        }
    ])
        ->where('faculty_id', $facultyId)
        ->whereHas('attendances') // only classes that have attendance records
        ->select('class_id', 'class_name', 'code', 'term', 'career_code')
        ->get();
}

function myClasses($facultyId)
{
    return FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc'); // latest attendance first
        }
    ])
        ->where('faculty_id', $facultyId)
        ->select('class_id', 'class_name', 'code', 'term', 'career_code')
        ->get();
}

function myClassesAttendanceRecordBK($facultyId)
{
    return FacultyMemberClass::withCount('attendances as total_rows')
        ->where('faculty_id', $facultyId)
        ->get()
        ->map(function ($class) {
            // get program name from the latest attendance record
            $class->program = $class->attendances()->latest('class_date')->value('program_name');
            return $class;
        });
}

function myClassesAttendanceRecord($facultyId)
{
    return FacultyMemberClass::withCount([
        'attendances as total_rows',
        'attendances as class_held_count' => function ($query) {
            $query->where('att_marked', 1);
        },
        'attendances as class_not_held_count' => function ($query) {
            $query->where('att_marked', 0);
        },
    ])
        ->where('faculty_id', $facultyId)
        ->get()
        ->map(function ($class) {
            // get program name from the latest attendance record
            $class->program = $class->attendances()->latest('class_date')->value('program_name');

            // Calculate percentage of classes held
            $class->held_percentage = $class->total_rows
                ? round(($class->class_held_count / $class->total_rows) * 100, 2)
                : 0;

            $class->not_held_percentage = $class->total_rows
                ? round(($class->class_not_held_count / $class->total_rows) * 100, 2)
                : 0;

            // Determine color and rating
            if ($class->held_percentage >= 90 && $class->held_percentage <= 100) {
                $class->color = '#6EA8FE';
                $class->rating = 'OS';
            } elseif ($class->held_percentage >= 80 && $class->held_percentage < 90) {
                $class->color = '#96e2b4';
                $class->rating = 'EE';
            } elseif ($class->held_percentage >= 70 && $class->held_percentage < 80) {
                $class->color = '#ffcb9a';
                $class->rating = 'ME';
            } elseif ($class->held_percentage >= 60 && $class->held_percentage < 70) {
                $class->color = '#fd7e13';
                $class->rating = 'NI';
            } elseif ($class->held_percentage >= 50 && $class->held_percentage < 60) {
                $class->color = '#ff4c51';
                $class->rating = 'BE';
            } else {
                $class->color = '#d3d3d3'; // <50%
                $class->rating = 'NA';
            }

            return $class;
        });
}

function myClassesAttendanceData($facultyId)
{
    return FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc');
        }
    ])
        ->where('faculty_id', $facultyId)
        ->get()
        ->map(function ($class) {

            $latestAttendance = $class->attendances->first();
            $class->program = $latestAttendance->program_name ?? null;

            // Count only attendances where att_marked = 1
            $class->class_held_count = $class->attendances->where('att_marked', 1)->count();

            // Total attendances
            $class->total_rows = $class->attendances->count();

            // Calculate class-level percentage of classes held
            $class->held_percentage = $class->total_rows
                ? round(($class->class_held_count / $class->total_rows) * 100, 2)
                : 0;

            // Calculate **average present and absent per class**
            $attendanceCount = $class->attendances->count();
            if ($attendanceCount > 0) {
                $class->avg_present_count = round($class->attendances->sum('present_count') / $attendanceCount, 2);
                $class->avg_absent_count = round($class->attendances->sum('absent_count') / $attendanceCount, 2);
            } else {
                $class->avg_present_count = 0;
                $class->avg_absent_count = 0;
            }

            // Calculate avg_present_percentage
            $totalStudents = $class->attendances->sum('total_students');
            $totalPresent = $class->attendances->sum('present_count');
            $class->avg_present_percentage = $totalStudents
                ? round(($totalPresent / $totalStudents) * 100, 2)
                : 0;

            // Determine color and rating based on avg_present_percentage
            if ($class->avg_present_percentage >= 90) {
                $class->color = '#6EA8FE';
                $class->rating = 'OS';
            } elseif ($class->avg_present_percentage >= 80) {
                $class->color = '#96e2b4';
                $class->rating = 'EE';
            } elseif ($class->avg_present_percentage >= 70) {
                $class->color = '#ffcb9a';
                $class->rating = 'ME';
            } elseif ($class->avg_present_percentage >= 60) {
                $class->color = '#fd7e13';
                $class->rating = 'NI';
            } elseif ($class->avg_present_percentage >= 50) {
                $class->color = '#ff4c51';
                $class->rating = 'BE';
            } else {
                $class->color = '#d3d3d3';
                $class->rating = 'NA';
            }

            // Assign color/rating to each attendance record for Blade
            foreach ($class->attendances as $att) {
                $att->color = $class->color;
                $att->rating = $class->rating;

                // Individual attendance percentage
                if ($att->total_students > 0) {
                    $att->present_percentage = round(($att->present_count / $att->total_students) * 100, 2);
                } else {
                    $att->present_percentage = 0;
                }
            }

            return $class;
        });
}

if (!function_exists('ScopusPublications')) {
    function ScopusPublications($facultyId, $indicatorId) {
        $facultyTargets = FacultyTarget::with(['researchPublicationTargets' => function($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                  ->where('indicator_id', $indicatorId)
                  ->whereNotNull('journal_clasification'); // Only targets with classification
        }])
        ->where('user_id', $facultyId)
        ->where('form_status', 'HOD')
        ->where('indicator_id', $indicatorId)
        ->get();

        $data = [];

        $ratingColors = [
            'OS' => '#6EA8FE',
            'EE' => '#96e2b4',
            'ME' => '#ffcb9a',
            'NI' => '#fd7e13',
            'BE' => '#ff4c51',
            'NA' => '#000000',
        ];

        foreach ($facultyTargets as $facultyTarget) {
            if ($facultyTarget->researchPublicationTargets->isEmpty()) continue;

            // Group research targets by journal_clasification
            $grouped = $facultyTarget->researchPublicationTargets
                ->groupBy(fn($t) => strtoupper($t->journal_clasification));

            foreach ($grouped as $classification => $targets) {
                // Get faculty value dynamically
                $value = match(strtolower($classification)) {
                    'q1' => $facultyTarget->scopus_q1,
                    'q2' => $facultyTarget->scopus_q2,
                    'q3' => $facultyTarget->scopus_q3,
                    'q4' => $facultyTarget->scopus_q4,
                    'w' => $facultyTarget->hec_w,
                    'x' => $facultyTarget->hec_x,
                    'y' => $facultyTarget->hec_y,
                    'medical' => $facultyTarget->medical_recognized,
                    default => 0,
                };

                $count = $targets->count();
                $percentage = ($value > 0) ? round(($count / $value) * 100, 2) : 0;

                // Determine rating
                if ($percentage >= 90) $rating = 'OS';
                elseif ($percentage >= 80) $rating = 'EE';
                elseif ($percentage >= 70) $rating = 'ME';
                elseif ($percentage >= 60) $rating = 'NI';
                elseif ($percentage > 0) $rating = 'BE';
                else $rating = 'NA';

                // Pick first target for optional fields
                $firstTarget = $targets->first();

                $data[] = [
                    'target_category' => $firstTarget->target_category,
                    'journal_clasification' => $classification,
                    'value' => $value,
                    'count' => $count,
                    'percentage' => $percentage,
                    'rating' => $rating,
                    'color' => $ratingColors[$rating],
                    'rank' => $firstTarget->rank ?? '-',
                    'nationality' => $firstTarget->nationality ?? '-',
                ];
            }
        }

        return $data;
    }
}





function PatentsIntellectualProperty($facultyId, $indicator_id)
{
    $facultyTargets = FacultyTarget::with(['intellectualPropertyTargets' => function($query) use ($indicator_id) {
        $query->where('form_status', 'RESEARCHER')
              ->where('indicator_id', $indicator_id);
    }])
    ->where('user_id', $facultyId)
    ->where('form_status', 'OTHER')
    ->where('indicator_id', $indicator_id)
    ->get();

    // Add calculated fields to each record
    foreach ($facultyTargets as $target) {

        $achieved = $target->intellectualPropertyTargets->count(); // Number of achieved publications
        $required = (int) $target->target;                          // Faculty target value

        // Prevent divide by zero
        if ($required > 0) {
            $percentage = ($achieved / $required) * 100;
        } else {
            $percentage = 0;
        }

        // Rating logic
        if ($percentage >= 90) {
            $rating = 'OS';  
            $color = '#6EA8FE';  
        } elseif ($percentage >= 80) {
            $rating = 'EE'; 
            $color = '#96e2b4';
        } elseif ($percentage >= 70) {
            $rating = 'ME';
            $color = '#ffcb9a'; 
        } elseif ($percentage >= 60) {
            $rating = 'NI';
            $color = '#fd7e13'; 
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51'; 
        } else {
            $rating = 'NA';
            $color = '#000000'; 
        }

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }
    return $facultyTargets;
}
function  CommercialGainsCounsultancyResearchIncome($facultyId, $indicator_id)
{
    $commercial = FacultyTarget::with(['commercialGainsCounsultancyTargets' => function($query) use ($indicator_id) {
        $query->where('form_status', 'RESEARCHER')
              ->where('indicator_id', $indicator_id);
    }])
    ->where('user_id', $facultyId)
    ->where('form_status', 'OTHER')
    ->where('indicator_id', $indicator_id)
    ->get();

    // Add calculated fields to each record
    foreach ($commercial as $target) {


        // All consultancy rows
        $rows = $target->commercialGainsCounsultancyTargets;
        $achieved = $rows->count();
        // Sum consultancy fees
        $total_fee = $rows->sum('consultancy_fee');
        $required = (int) $target->target;                          // Faculty target value

        // Prevent divide by zero
        if ($required > 0) {
            $percentage = ($achieved / $required) * 100;
        } else {
            $percentage = 0;
        }

        // Rating logic
        if ($percentage >= 90) {
            $rating = 'OS';  
            $color = '#6EA8FE';  
        } elseif ($percentage >= 80) {
            $rating = 'EE'; 
            $color = '#96e2b4';
        } elseif ($percentage >= 70) {
            $rating = 'ME';
            $color = '#ffcb9a'; 
        } elseif ($percentage >= 60) {
            $rating = 'NI';
            $color = '#fd7e13'; 
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51'; 
        } else {
            $rating = 'NA';
            $color = '#000000'; 
        }

        // Add values into object
        $target->achieved_count = $achieved;
        $target->total_fee = $total_fee; 
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }
    return $commercial;
}
function MultidisciplinaryProjects($facultyId, $indicator_id)
{
    $facultyTargets = FacultyTarget::with(['achievementOfMultidisciplinaryProjectsTarget' => function($query) use ($indicator_id) {
        $query->where('form_status', 'RESEARCHER')
              ->where('indicator_id', $indicator_id);
    }])
    ->where('user_id', $facultyId)
    ->where('form_status', 'OTHER')
    ->where('indicator_id', $indicator_id)
    ->get();

    // Add calculated fields to each record
    foreach ($facultyTargets as $target) {

        $achieved = $target->achievementOfMultidisciplinaryProjectsTarget->count(); // Number of achieved publications
        $required = (int) $target->target;                          // Faculty target value

        // Prevent divide by zero
        if ($required > 0) {
            $percentage = ($achieved / $required) * 100;
        } else {
            $percentage = 0;
        }

        // Rating logic
        if ($percentage >= 90) {
            $rating = 'OS';  
            $color = '#6EA8FE';  
        } elseif ($percentage >= 80) {
            $rating = 'EE'; 
            $color = '#96e2b4';
        } elseif ($percentage >= 70) {
            $rating = 'ME';
            $color = '#ffcb9a'; 
        } elseif ($percentage >= 60) {
            $rating = 'NI';
            $color = '#fd7e13'; 
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51'; 
        } else {
            $rating = 'NA';
            $color = '#000000'; 
        }

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }
    return $facultyTargets;
}
function noofGrantsWon($facultyId, $indicator_id)
{
    $facultyTargets = FacultyTarget::with(['noofGrantsWonTarget' => function($query) use ($indicator_id) {
        $query->where('form_status', 'RESEARCHER')
              ->where('indicator_id', $indicator_id);
    }])
    ->where('user_id', $facultyId)
    ->where('form_status', 'OTHER')
    ->where('indicator_id', $indicator_id)
    ->get();

    // Add calculated fields to each record
    foreach ($facultyTargets as $target) {

        $achieved = $target->noofGrantsWonTarget->count(); // Number of achieved publications
        $required = (int) $target->target;                          // Faculty target value

        // Prevent divide by zero
        if ($required > 0) {
            $percentage = ($achieved / $required) * 100;
        } else {
            $percentage = 0;
        }

        // Rating logic
        if ($percentage >= 90) {
            $rating = 'OS';  
            $color = '#6EA8FE';  
        } elseif ($percentage >= 80) {
            $rating = 'EE'; 
            $color = '#96e2b4';
        } elseif ($percentage >= 70) {
            $rating = 'ME';
            $color = '#ffcb9a'; 
        } elseif ($percentage >= 60) {
            $rating = 'NI';
            $color = '#fd7e13'; 
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51'; 
        } else {
            $rating = 'NA';
            $color = '#000000'; 
        }

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }
    return $facultyTargets;
}
function CompletionofCourseFolder($facultyId, $indicator_id)
{
    $CompletionOfCourseFolder = CompletionOfCourseFolder::with(['facultyMember','facultyClass'])
    ->where('faculty_member_id', $facultyId)
    ->where('form_status', 'HOD')
    ->where('completion_of_Course_folder_indicator_id', $indicator_id)
    ->get();
     foreach ($CompletionOfCourseFolder as $target) {
                // Rating logic
        if ($target->completion_of_Course_folder == 100) {
            $rating = 'OS';  
            $color = '#6EA8FE'; 
            $status= 'Completed'; 
        } elseif ($target->completion_of_Course_folder == 50) {
            $rating = 'ME'; 
            $color = '#ffcb9a';
            $status= 'Partially Completed'; 
        } elseif ($target->completion_of_Course_folder == 25) {
            $rating = 'BE';
            $color = '#ff4c51'; 
            $status= 'Not Completed'; 
        } else {
            $rating = 'NA';
            $color = '#000000'; 
            $status= 'NA'; 
        }
        
        $target->rating = $rating;
        $target->color = $color;
        $target->status_folder = $status;
     }
     return $CompletionOfCourseFolder;
    

   
}
function ComplianceandUsageofLMS($facultyId, $indicator_id)
{
    $CompletionOfCourseFolder = CompletionOfCourseFolder::with(['facultyMember','facultyClass'])
    ->where('faculty_member_id', $facultyId)
    ->where('form_status', 'HOD')
    ->where('compliance_and_usage_of_lms_indicator_id', $indicator_id)
    ->get();
     foreach ($CompletionOfCourseFolder as $target) {
                // Rating logic
        if ($target->compliance_and_usage_of_lms == 100) {
            $rating = 'OS';  
            $color = '#6EA8FE'; 
            $status= 'Completed'; 
        } elseif ($target->compliance_and_usage_of_lms == 50) {
            $rating = 'ME'; 
            $color = '#ffcb9a';
            $status= 'Partially Completed'; 
        } elseif ($target->compliance_and_usage_of_lms == 25) {
            $rating = 'BE';
            $color = '#ff4c51'; 
            $status= 'Not Completed'; 
        } else {
            $rating = 'NA';
            $color = '#000000'; 
            $status= 'NA'; 
        }
        
        $target->rating = $rating;
        $target->color = $color;
        $target->status_folder = $status;
     }
     return $CompletionOfCourseFolder;
    

   
}




