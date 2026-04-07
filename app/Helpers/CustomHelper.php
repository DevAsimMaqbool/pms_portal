<?php

//namespace App\Helpers;

use App\Models\AchievementOfResearchPublicationsTarget;
use App\Models\CompletionOfCourseFolder;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\RoleKpaAssignment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Models\FacultyMemberClass;
use App\Models\Employability;
use App\Models\FacultyTarget;
use App\Models\LineManagerFeedback;
use App\Models\LineManagerEventFeedback;
use App\Models\IndicatorsPercentage;
use App\Models\Program;
use App\Models\RatingRule;
use App\Models\SidebarKpaAssignment;
use App\Models\StudentFeedbackClassWise;
use App\Models\LineManagerReviewRating;
use App\Models\QecAuditRating;
use App\Models\StudentEngagementRate;
use App\Models\AchievementOfResearchPublicationTargetCoAuthor;
use App\Models\ScholarsSatisfactionInThesisStage;
use App\Models\ResearchProductivityOfPgStudent;
use App\Models\ResearchProductivityOfPgStudentTarget;
use App\Models\ProgramProfitability;
use App\Models\GoGlobalStreamTarget;
use App\Models\StudentsGlobalExperience;
use App\Models\SatisfactionOfInternationalStudent;
use App\Models\ActiveInternationalResearchPartner;
use App\Models\AdmissionTargetAchieved;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

if (!function_exists('getRatingMeta')) {

    function getRatingMeta($percentage)
    {
        if ($percentage >= 90) {
            return (object) [
                'color' => '#6EA8FE',
                'rating' => 'OS'
            ];
        } elseif ($percentage >= 80) {
            return (object) [
                'color' => '#96e2b4',
                'rating' => 'EE'
            ];
        } elseif ($percentage >= 70) {
            return (object) [
                'color' => '#ffcb9a',
                'rating' => 'ME'
            ];
        } elseif ($percentage >= 60) {
            return (object) [
                'color' => '#fd7e13',
                'rating' => 'NI'
            ];
        } else {
            return (object) [
                'color' => '#ff4c51',
                'rating' => 'BE'
            ];
        }
    }
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

function getFacultyName($facultyID)
{
    $user = Faculty::where('id', $facultyID)->firstOrFail();

    return $user->name;
}

function getUserID($UserID)
{
    $user = User::where('faculty_id', $UserID)->firstOrFail();

    return $user->employee_id;
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
                'small_description' => $kpa->small_description,
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
                                    'form_status' => $item->form_status,
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
function getSidbarRoleAssignments(string $roleName, ?int $kapcid = null, $form = null)
{
    $roleId = Role::where('name', $roleName)->value('id');
    ;
    if (!$roleId) {
        return collect(); // return empty if user doesn't have that role
    }

    $assignments = SidebarKpaAssignment::with([
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
                'small_description' => $kpa->small_description,
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
                                    'form_status' => $item->form_status,
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

function myClassesBK27Feb($facultyId, $activeRoleId)
{
    $classes = FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc'); // latest attendance first
        }
    ])
        ->where('faculty_id', $facultyId)
        ->select('class_id', 'class_name', 'code', 'term', 'career_code', 'average_marks', 'passing_percentage')
        ->get();
    $count = $classes->count();

    // Determine score & rating based on count
    if ($count > 3) {
        $score = 100;
    } elseif ($count === 3) {
        $score = 80;
    } else {
        $score = 60;
    }
    saveIndicatorPercentage(
        $facultyId = getUserID($facultyId),
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 1,
        $indicatorCategoryId = 3,
        $indicatorId = 122,
        $score
    );
    return $classes;
}

function myClasses($facultyId, $activeRoleId)
{

    // 1️⃣ Get count and averages in a single query
    $stats = FacultyMemberClass::where('faculty_id', $facultyId)
        ->selectRaw('COUNT(*) as total_courses, 
        SUM(COALESCE(passing_percentage,0)) as total_pass,
        SUM(COALESCE(average_marks,0)) as total_average_marks,
        AVG(COALESCE(average_marks,0)) as avg_marks, 
        AVG(COALESCE(passing_percentage,0)) as avg_pass')
        ->first();
    // ✅ ADD THESE 2 LINES HERE
    $stats->total_classes = $stats->attendances->count();

    // Calculate avg_present_percentage
    $stats->totalStudentsClass = $stats->attendances->sum('total_students');
    $totalCourses = $stats->total_courses;
    $totalPassPercentage = $stats->total_pass ?? 0;
    $totalAverageMarks = $stats->total_average_marks ?? 0;
    $averagePassPercentage = $stats->avg_pass ?? 0;
    $averageStudentScore = $stats->avg_marks ?? 0;

    // 2️⃣ Course Load Score
    $courseLoadScore = $totalCourses > 3 ? 100 : ($totalCourses == 3 ? 80 : 60);

    // 3️⃣ Get weightages
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', 122)['weightage'],
        'pass' => getRoleWeightage($activeRoleId, 'indicator', 185)['weightage'],
        'marks' => getRoleWeightage($activeRoleId, 'indicator', 186)['weightage'],
    ];

    $weightedCourseLoad = ($courseLoadScore * $weights['course_load']) / 100;
    $weightedPassScore = ($averagePassPercentage * $weights['pass']) / 100;
    $weightedMarksScore = ($averageStudentScore * $weights['marks']) / 100;

    // 4️⃣ Save indicators (transaction optional)
    $userId = getUserID($facultyId);
    DB::transaction(function () use ($userId, $activeRoleId, $weightedCourseLoad, $weightedPassScore, $weightedMarksScore) {
        if ($activeRoleId != 22) {
            saveIndicatorPercentage($userId, $activeRoleId, 1, 3, 122, $weightedCourseLoad);
            saveIndicatorPercentage90Plus($userId, $activeRoleId, 1, 25, 185, $weightedPassScore);
            saveIndicatorPercentage($userId, $activeRoleId, 1, 25, 186, $weightedMarksScore);
        }
    });

    // 5️⃣ Return minimal class info (load if needed)
    $classes = FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc');
        }
    ])
        ->where('faculty_id', $facultyId)
        ->get();
    return [
        'classes' => $classes,
        'totalCourses' => $totalCourses,
        'courseLoadScore' => $courseLoadScore,
        'totalPassPercentage' => $totalPassPercentage,
        'totalAverageMarks' => $totalAverageMarks,
        'averagePassPercentage' => $averagePassPercentage,
        'averageStudentScore' => $averageStudentScore,
    ];
}

function myClassesAttendanceRecord($facultyId, $activeRoleId)
{
    $classes = FacultyMemberClass::withCount([
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
            $class->program = $class->attendances()->latest('class_date')->value('program_name');

            $class->held_percentage = $class->total_rows
                ? round(($class->class_held_count / $class->total_rows) * 100, 2)
                : 0;

            $class->not_held_percentage = $class->total_rows
                ? round(($class->class_not_held_count / $class->total_rows) * 100, 2)
                : 0;
            // ✅ ADD THESE 2 LINES HERE
            $class->total_classes = $class->attendances->count();

            // Calculate avg_present_percentage
            $class->totalStudentsClass = $class->attendances->sum('total_students');
            // Color & rating logic
            if ($class->held_percentage == 100) {
                $class->color = '#ffcb9a';
                $class->rating = 'ME';
            } elseif ($class->held_percentage >= 90 && $class->held_percentage <= 100) {
                $class->color = '#fd7e13';
                $class->rating = 'NI';
            } else {
                $class->color = '#ff4c51';
                $class->rating = 'BE';
            }

            return $class;
        });
    // ✅ Save overall percentage
    saveOverallAttendancePercentage($facultyId = getUserID($facultyId), $classes, $keyPerformanceAreaId = 1, $indicatorCategoryId = 3, $indicatorId = 117, $activeRoleId);

    return $classes;
}
function saveOverallAttendancePercentage($facultyId, $classes, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId, $activeRoleId)
{
    if ($classes->count() == 0) {
        $overallPercentage = 0;
    } else {
        $overallPercentage = round($classes->avg('held_percentage'), 2);
    }

    // Color & rating logic (same as above)
    if ($overallPercentage == 100) {
        $color = 'warning';
        $rating = 'ME';
    } elseif ($overallPercentage >= 90 && $overallPercentage <= 100) {
        $color = 'orange';
        $rating = 'NI';
    } else {
        $color = 'danger';
        $rating = 'BE';
    }
    $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 117);
    $weight = $indicatorWeight['weightage'] ?? 0;
    $weightedScore = ($overallPercentage * $weight) / 100;
    // Save to database
    IndicatorsPercentage::updateOrCreate(
        [
            'employee_id' => $facultyId,
            'role_id' => $activeRoleId,
            'key_performance_area_id' => $keyPerformanceAreaId,
            'indicator_category_id' => $indicatorCategoryId,
            'indicator_id' => $indicatorId,
        ],
        [
            'score' => $weightedScore,
            'rating' => $rating,
            'color' => $color,
        ]
    );

    return $overallPercentage;
}


function myClassesAttendanceData($facultyId)
{
    // Fetch classes with attendances first
    $classes = FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc');
        }
    ])
        ->where('faculty_id', $facultyId)
        ->get();

    // Calculate overall present percentage across all classes
    $totalPresent = $classes->flatMap->attendances->sum('present_count');
    $totalStudents = $classes->flatMap->attendances->sum('total_students');

    $overallPresentPercentage = $totalStudents
        ? round(($totalPresent / $totalStudents) * 100, 2)
        : 0;

    // Now map each class (existing logic unchanged)
    return $classes->map(function ($class) use ($facultyId, $overallPresentPercentage) {

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

        // Calculate average present and absent per class
        $attendanceCount = $class->attendances->count();
        if ($attendanceCount > 0) {
            $class->avg_present_count = round($class->attendances->sum('present_count') / $attendanceCount, 2);
            $class->avg_absent_count = round($class->attendances->sum('absent_count') / $attendanceCount, 2);
        } else {
            $class->avg_present_count = 0;
            $class->avg_absent_count = 0;
        }
        // ✅ ADD THESE 2 LINES HERE
        $class->total_classes = $class->attendances->count();

        // Calculate avg_present_percentage
        $class->totalStudentsClass = $class->attendances->sum('total_students');
        $totalPresentClass = $class->attendances->sum('present_count');
        $class->avg_present_percentage = $class->totalStudentsClass
            ? round(($totalPresentClass / $class->totalStudentsClass) * 100, 2)
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
        } else {
            $class->color = '#ff4c51';
            $class->rating = 'BE';
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

        $activeRoleId = getRoleIdByName(activeRole());
        $employeeId = getUserID($facultyId);
        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', 113)['weightage'],
        ];

        $weightedScore = ($overallPresentPercentage * $weights['course_load']) / 100;
        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            1,
            3,
            113,
            $weightedScore
        );

        return $class;
    });
}
if (!function_exists('ScopusPublications')) {
    function ScopusPublications($facultyId, $activeRoleId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 5)
    {
        $facultyTargets = FacultyTarget::with([
            'researchPublicationTargets' => function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
                    ->where('status', 3)
                    ->whereNotNull('journal_clasification');
            }
        ])
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
        ];

        $totalTarget = 0;
        $totalSubmitted = 0;

        foreach ($facultyTargets as $facultyTarget) {

            $targetCount = $facultyTarget->target ?? 0;
            $submissionCount = $facultyTarget->researchPublicationTargets->count();

            $totalTarget += $targetCount;
            $totalSubmitted += $submissionCount;

            // Group submissions by classification
            $grouped = $facultyTarget->researchPublicationTargets
                ->groupBy(fn($t) => strtoupper($t->journal_clasification));

            // List of all classifications to always show
            $classifications = ['Q1', 'Q2', 'Q3', 'Q4', 'W', 'X', 'Y', 'MEDICAL'];

            foreach ($classifications as $classification) {

                $targets = $grouped[$classification] ?? collect(); // empty if no submissions
                $value = match (strtolower($classification)) {
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
                $internationalCount = $targets->filter(fn($t) => strtolower(trim($t->nationality)) === 'international')->count();
                $percentage = ($value > 0) ? round(($count / $value) * 100, 2) : 0;

                // Rating logic
                if ($count === 0) {
                    $rating = 'BE';
                } elseif ($count < $value) {
                    $rating = 'NI';
                } elseif ($count === $value) {
                    $rating = match ($internationalCount) {
                        0 => 'NI',
                        1 => 'ME',
                        2 => 'EE',
                        default => 'OS',
                    };
                } elseif ($count > $value && $count < ($value * 2)) {
                    $rating = 'EE';
                } elseif ($count >= ($value * 2)) {
                    $rating = 'OS';
                } else {
                    $rating = 'BE';
                }

                $firstTarget = $targets->first();

                $data[] = [
                    'target_category' => $facultyTarget->target_category ?? '-',
                    'journal_clasification' => $classification,
                    'value' => $value,
                    'count' => $count,
                    'percentage' => $percentage,
                    'rating' => $rating,
                    'color' => $ratingColors[$rating],
                    'rank' => $firstTarget?->rank ?? '-',
                    'nationality' => $firstTarget?->nationality ?? '-',
                    'international_count' => $internationalCount,
                ];
            }
        }

        // Overall percentage
        $avgPercentage = ($totalTarget > 0)
            ? round(($totalSubmitted / $totalTarget) * 100, 2)
            : 0;

        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'],
        ];

        $weightedScore = ($avgPercentage * $weights['course_load']) / 100;

        calculateJournalQuartile($facultyId, $activeRoleId, $indicatorId);
        calculateInternationalScore($facultyId, $activeRoleId, $indicatorId);

        saveIndicatorPercentage(
            $facultyId,
            $activeRoleId,
            $keyPerformanceAreaId,
            $indicatorCategoryId,
            $indicatorId,
            $weightedScore
        );

        return $data;
    }
}

if (!function_exists('ScopusPublicationsBKKKK')) {
    function ScopusPublicationsBKKKK($facultyId, $activeRoleId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 5)
    {
        $facultyTargets = FacultyTarget::with([
            'researchPublicationTargets' => function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
                    ->where('status', 3)
                    ->whereNotNull('journal_clasification');
            }
        ])
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
        ];

        $totalTarget = 0;
        $totalSubmitted = 0;

        foreach ($facultyTargets as $facultyTarget) {

            $targetCount = $facultyTarget->target ?? 0;
            $submissionCount = $facultyTarget->researchPublicationTargets->count();

            $totalTarget += $targetCount;
            $totalSubmitted += $submissionCount;

            if ($facultyTarget->researchPublicationTargets->isEmpty()) {
                continue;
            }

            $grouped = $facultyTarget->researchPublicationTargets
                ->groupBy(fn($t) => strtoupper($t->journal_clasification));

            foreach ($grouped as $classification => $targets) {

                // 🎯 TARGET from FacultyTarget columns
                $value = match (strtolower($classification)) {
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

                // 🌍 International co-authored count (normalized)
                $internationalCount = $targets->filter(fn($t) => strtolower(trim($t->nationality)) === 'international')->count();

                // 🔢 Percentage (for display)
                $percentage = ($value > 0) ? round(($count / $value) * 100, 2) : 0;

                // ⭐ IMAGE-BASED RATING
                if ($count === 0) {
                    $rating = 'BE'; // No publications
                } elseif ($count < $value) {
                    $rating = 'NI'; // Below target
                } elseif ($count === $value) {
                    // Exactly target, consider international co-authors
                    $rating = match ($internationalCount) {
                        0 => 'NI',
                        1 => 'ME',
                        2 => 'EE',
                        default => 'OS', // 3 or more
                    };
                } elseif ($count > $value && $count < ($value * 2)) {
                    $rating = 'EE'; // Slightly above target
                } elseif ($count >= ($value * 2)) {
                    $rating = 'OS'; // Double or more
                } else {
                    $rating = 'BE'; // fallback
                }

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
                    'international_count' => $internationalCount, // useful for debugging
                ];
            }
        }

        // ✅ Overall percentage
        $avgPercentage = ($totalTarget > 0)
            ? round(($totalSubmitted / $totalTarget) * 100, 2)
            : 0;

        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'],
        ];

        $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
        calculateJournalQuartile($facultyId, $activeRoleId, $indicatorId);
        calculateInternationalScore($facultyId, $activeRoleId, $indicatorId);
        saveIndicatorPercentage(
            $facultyId,
            $role_id = $activeRoleId,
            $keyPerformanceAreaId,
            $indicatorCategoryId,
            $indicatorId,
            $weightedScore
        );

        return $data;
    }
}

if (!function_exists('calculateInternationalScore')) {

    function calculateInternationalScore($facultyId, $activeRoleId, $indicatorId)
    {
        // Get Approved Scopus Publications
        $records = AchievementOfResearchPublicationsTarget::where('indicator_id', $indicatorId)
            ->where('created_by', $facultyId)
            ->where('target_category', 'Scopus-Indexed')
            ->where('form_status', 'RESEARCHER')
            ->where('status', 3) // Fully approved
            ->get();

        if ($records->isEmpty()) {
            return 0;
        }

        $totalPapers = $records->count();

        // Count International authored papers
        $internationalPapers = $records->filter(function ($r) {
            return strtolower(trim($r->nationality)) === 'international';
        })->count();

        // Fraction of international papers
        $fraction = $totalPapers > 0 ? $internationalPapers / $totalPapers : 0;

        // Calculate obtained score using indicator weight
        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 127);
        $weight = $indicatorWeight['weightage'] ?? 0;
        $obtainedScore = ($fraction * $weight) / 100;

        // Save obtained score
        saveIndicatorPercentage(
            $facultyId,
            $activeRoleId,
            2,
            5,
            127,
            $obtainedScore
        );

        return round($obtainedScore, 2); // e.g., 5.00
    }
}

if (!function_exists('calculateJournalQuartile')) {

    function calculateJournalQuartile($facultyId, $activeRoleId, $indicatorId)
    {

        // Quartile Points
        $quartilePoints = [
            'Q1' => 20,
            'Q2' => 15,
            'Q3' => 10,
            'Q4' => 5,
        ];

        // Get Approved Scopus Publications
        $records = AchievementOfResearchPublicationsTarget::where('indicator_id', $indicatorId)
            ->where('created_by', $facultyId)
            ->where('target_category', 'Scopus-Indexed')
            ->where('form_status', 'RESEARCHER')
            ->where('status', 3) // Fully approved
            ->get();

        $obtainedScore = 0;

        foreach ($records as $record) {
            if (isset($quartilePoints[$record->journal_clasification])) {
                $obtainedScore += $quartilePoints[$record->journal_clasification];
            }
        }
        saveIndicatorPercentage(
            $facultyId,
            $role_id = $activeRoleId,
            2,
            5,
            203,
            $obtainedScore
        );
        return $obtainedScore;
    }
}



// if (!function_exists('ScopusPublications')) {
//     function ScopusPublications($facultyId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 5)
//     {
//         $facultyTargets = FacultyTarget::with([
//             'researchPublicationTargets' => function ($query) use ($indicatorId) {
//                 $query->where('form_status', 'RESEARCHER')
//                     ->where('indicator_id', $indicatorId)
//                     ->whereNotNull('journal_clasification');
//             }
//         ])
//             ->where('user_id', $facultyId)
//             ->where('form_status', 'HOD')
//             ->where('indicator_id', $indicatorId)
//             ->get();

//         $data = [];

//         $ratingColors = [
//             'OS' => '#6EA8FE',
//             'EE' => '#96e2b4',
//             'ME' => '#ffcb9a',
//             'NI' => '#fd7e13',
//             'BE' => '#ff4c51',
//         ];

//         $totalTarget = 0;
//         $totalSubmitted = 0;

//         foreach ($facultyTargets as $facultyTarget) {
//             $targetCount = $facultyTarget->target ?? 0;
//             $submissionCount = $facultyTarget->researchPublicationTargets->count();

//             $totalTarget += $targetCount;
//             $totalSubmitted += $submissionCount;

//             if ($facultyTarget->researchPublicationTargets->isEmpty())
//                 continue;

//             $grouped = $facultyTarget->researchPublicationTargets
//                 ->groupBy(fn($t) => strtoupper($t->journal_clasification));

//             foreach ($grouped as $classification => $targets) {
//                 $value = match (strtolower($classification)) {
//                     'q1' => $facultyTarget->scopus_q1,
//                     'q2' => $facultyTarget->scopus_q2,
//                     'q3' => $facultyTarget->scopus_q3,
//                     'q4' => $facultyTarget->scopus_q4,
//                     'w' => $facultyTarget->hec_w,
//                     'x' => $facultyTarget->hec_x,
//                     'y' => $facultyTarget->hec_y,
//                     'medical' => $facultyTarget->medical_recognized,
//                     default => 0,
//                 };

//                 $count = $targets->count();
//                 $percentage = ($value > 0) ? round(($count / $value) * 100, 2) : 0;

//                 $rating = match (true) {
//                     $percentage >= 90 => 'OS',
//                     $percentage >= 80 => 'EE',
//                     $percentage >= 70 => 'ME',
//                     $percentage >= 60 => 'NI',
//                     $percentage > 0 => 'BE',
//                     default => 'NA',
//                 };

//                 $firstTarget = $targets->first();

//                 $data[] = [
//                     'target_category' => $firstTarget->target_category,
//                     'journal_clasification' => $classification,
//                     'value' => $value,
//                     'count' => $count,
//                     'percentage' => $percentage,
//                     'rating' => $rating,
//                     'color' => $ratingColors[$rating],
//                     'rank' => $firstTarget->rank ?? '-',
//                     'nationality' => $firstTarget->nationality ?? '-',
//                 ];
//             }
//         }

//         // ✅ Correct overall percentage: total submitted / total target
//         $avgPercentage = ($totalTarget > 0) ? round(($totalSubmitted / $totalTarget) * 100, 2) : 0;

//         // ✅ Save globally
//         saveIndicatorPercentage(
//             $facultyId,
//             $keyPerformanceAreaId = 2,
//             $indicatorCategoryId = 5,
//             $indicatorId = 128,
//             $avgPercentage
//         );

//         return $data;
//     }
// }

if (!function_exists('ScopusPublicationsbk')) {
    function ScopusPublicationsbk($facultyId, $indicatorId)
    {
        $facultyTargets = FacultyTarget::with([
            'researchPublicationTargets' => function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
                    ->where('status', 4)
                    ->whereNotNull('journal_clasification'); // Only targets with classification
            }
        ])
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
        ];

        foreach ($facultyTargets as $facultyTarget) {
            if ($facultyTarget->researchPublicationTargets->isEmpty())
                continue;

            // Group research targets by journal_clasification
            $grouped = $facultyTarget->researchPublicationTargets
                ->groupBy(fn($t) => strtoupper($t->journal_clasification));

            foreach ($grouped as $classification => $targets) {
                // Get faculty value dynamically
                $value = match (strtolower($classification)) {
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
                if ($percentage >= 90)
                    $rating = 'OS';
                elseif ($percentage >= 80)
                    $rating = 'EE';
                elseif ($percentage >= 70)
                    $rating = 'ME';
                elseif ($percentage >= 60)
                    $rating = 'NI';
                else
                    $rating = 'BE';

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

function PatentsIntellectualProperty($facultyId, $activeRoleId, $indicator_id)
{
    $facultyTargets = FacultyTarget::with([
        'intellectualPropertyTargets' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // To calculate overall average

    foreach ($facultyTargets as $target) {

        $achieved = $target->intellectualPropertyTargets->count(); // Number of achieved publications
        $required = (int) $target->target;                          // Faculty target value

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

        // Save for average calculation
        $percentages[] = $percentage;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Add calculated values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', $indicator_id);
    $weight = $indicatorWeight['weightage'] ?? 0;
    $weightedScore = ($avgPercentage * $weight) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $weightedScore
    );

    return $facultyTargets;
}

function CommercialGainsCounsultancyResearchIncome($facultyId, $activeRoleId, $indicator_id)
{
    $commercial = FacultyTarget::with([
        'commercialGainsCounsultancyTargets' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // For calculating overall average

    foreach ($commercial as $target) {

        $rows = $target->commercialGainsCounsultancyTargets;
        $achieved = $rows->count();
        $total_fee = $rows->sum('consultancy_fee');
        $required = (int) $target->target;

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Save percentage for avg calculation
        $percentages[] = $percentage;

        // Add values into object
        $target->achieved_count = $achieved;
        $target->total_fee = $total_fee;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $weightedScore
    );

    return $commercial;
}
function MultidisciplinaryProjects($facultyId, $activeRoleId, $indicatorId)
{
    $facultyTargets = FacultyTarget::with([
        'achievementOfMultidisciplinaryProjectsTarget' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicatorId);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicatorId)
        ->get();

    // -------------------------
    // EXISTING FUNCTIONALITY
    // -------------------------
    foreach ($facultyTargets as $target) {

        $achieved = $target->achievementOfMultidisciplinaryProjectsTarget->count();
        $required = (int) $target->target;

        $percentage = ($required > 0)
            ? ($achieved / $required) * 100
            : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Attach calculated values
        $target->achieved_count = $achieved;
        $target->percentage = floor($percentage * 100) / 100;
        $target->rating = $rating;
        $target->color = $color;
    }

    // -------------------------
    // NEW PART → CALCULATE AVG
    // -------------------------

    // Extract all percentages (already calculated)
    $allPercentages = collect($facultyTargets)->pluck('percentage')->filter()->toArray();

    if (count($allPercentages) > 0) {
        $avgPercentage = floor((array_sum($allPercentages) / count($allPercentages)) * 100) / 100;
    } else {
        $avgPercentage = 0;
    }

    // -------------------------
    // SAVE GLOBALLY
    // -------------------------
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', 136)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicatorId = 136,
        $weightedScore
    );

    return $facultyTargets;
}

function noofGrantsWon($facultyId, $activeRoleId, $status, $indicator_id)
{
    $facultyTargets = FacultyTarget::with([
        'noofGrantsWonTarget' => function ($query) use ($indicator_id, $status) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id)
                ->where('grant_status', $status);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();
    $totalPercentage = 0;
    $count = 0;

    foreach ($facultyTargets as $target) {

        $achieved = $target->noofGrantsWonTarget->count();
        $required = (int) $target->target;

        if ($required > 0) {
            $percentage = ($achieved / $required) * 100;
        } else {
            $percentage = 0;
        }

        $percentage = round($percentage, 2);

        // Accumulate for average
        $totalPercentage += $percentage;
        $count++;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        $target->achieved_count = $achieved;
        $target->percentage = $percentage;
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate Average
    $avgPercentage = $count > 0 ? round($totalPercentage / $count, 2) : 0;
    $status = 'Won' ? $indicatorId = 202 : $indicatorId = $indicator_id;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save Only One Average Score
    saveIndicatorPercentage(
        $facultyId,
        $activeRoleId,
        2,  // KPA ID
        8,  // Category ID
        $indicatorId,
        $weightedScore
    );
    return $facultyTargets;
}

function IndustrialVisits($facultyId, $activeRoleId, $indicator_id)
{
    $commercial = FacultyTarget::with([
        'industrialVisitsTarget' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // For calculating overall average

    foreach ($commercial as $target) {

        $rows = $target->industrialVisitsTarget;
        $achieved = $rows->count();
        $required = (int) $target->target;

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Save percentage for avg calculation
        $percentages[] = $percentage;

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $weightedScore
    );

    return $commercial;
}

function IndustrialProjects($facultyId, $activeRoleId, $indicator_id)
{
    $commercial = FacultyTarget::with([
        'industrialProjectsTarget' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // For calculating overall average

    foreach ($commercial as $target) {

        $rows = $target->industrialProjectsTarget;
        $achieved = $rows->count();
        $required = (int) $target->target;

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Save percentage for avg calculation
        $percentages[] = $percentage;

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $weightedScore
    );

    return $commercial;
}

function spinOffs($facultyId, $activeRoleId, $indicator_id)
{
    $commercial = FacultyTarget::with([
        'spinOffs' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // For calculating overall average

    foreach ($commercial as $target) {

        $rows = $target->spinOffs;
        $achieved = $rows->count();
        $required = (int) $target->target;

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Save percentage for avg calculation
        $percentages[] = $percentage;

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $weightedScore
    );

    return $commercial;
}

function ProductsDeliveredToIndustry($facultyId, $activeRoleId, $indicator_id)
{
    $commercial = FacultyTarget::with([
        'ProductsDeliveredToIndustry' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('status', 2)
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // For calculating overall average

    foreach ($commercial as $target) {

        $rows = $target->ProductsDeliveredToIndustry;
        $achieved = $rows->count();
        $required = (int) $target->target;

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Save percentage for avg calculation
        $percentages[] = $percentage;

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $weightedScore
    );

    return $commercial;
}

function CompletionofCourseFolder($facultyId, $activeRoleId, $indicator_id)
{
    $CompletionOfCourseFolder = CompletionOfCourseFolder::with(['facultyMember', 'facultyClass'])
        ->where('faculty_member_id', $facultyId)
        ->where('form_status', 'HOD')
        ->where('status', 2)
        ->where('completion_of_Course_folder_indicator_id', $indicator_id)
        ->get();

    $totalScore = 0;
    $count = 0;

    foreach ($CompletionOfCourseFolder as $target) {

        // Rating logic (unchanged)
        if ($target->completion_of_Course_folder == 100) {
            $rating = 'OS';
            $color = '#6EA8FE';
            $status = 'Completed';
        } elseif ($target->completion_of_Course_folder == 70) {
            $rating = 'ME';
            $color = '#ffcb9a';
            $status = 'Partially Completed';
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
            $status = 'Not Completed';
        }

        // Modify object (unchanged)
        $target->rating = $rating;
        $target->color = $color;
        $target->status_folder = $status;

        // For saving avg %
        $totalScore += $target->completion_of_Course_folder;
        $count++;
    }

    // Compute average percentage
    $avgPercentage = $count > 0 ? floor($totalScore / $count) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // Save to IndicatorsPercentage table
    saveIndicatorPercentage100Plus(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 1,
        $indicatorCategoryId = 3,
        $indicator_id,
        $weightedScore
    );

    return $CompletionOfCourseFolder;
}

function ComplianceandUsageofLMS($facultyId, $activeRoleId, $indicator_id)
{
    $CompletionOfCourseFolder = CompletionOfCourseFolder::with(['facultyMember', 'facultyClass'])
        ->where('faculty_member_id', $facultyId)
        ->where('form_status', 'HOD')
        ->where('status', 2)
        ->where('compliance_and_usage_of_lms_indicator_id', $indicator_id)
        ->get();

    $percentages = []; // collect all percentages for avg

    foreach ($CompletionOfCourseFolder as $target) {

        // rating logic (unchanged)
        if ($target->compliance_and_usage_of_lms == 100) {
            $rating = 'OS';
            $color = '#6EA8FE';
            $status = 'Completed';
        } elseif ($target->compliance_and_usage_of_lms == 70) {
            $rating = 'ME';
            $color = '#ffcb9a';
            $status = 'Partially Completed';
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
            $status = 'Not Completed';
        }

        // attach existing values back to object
        $target->rating = $rating;
        $target->color = $color;
        $target->status_folder = $status;

        // collect for avg
        $percentages[] = $target->compliance_and_usage_of_lms;
    }

    // ✅ Calculate average of compliance (%)
    $avgPercentage = count($percentages)
        ? round(array_sum($percentages) / count($percentages), 2)
        : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicator_id)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally (corrected)
    saveIndicatorPercentage(
        $facultyId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 1,
        $indicatorCategoryId = 3,
        $indicator_id,
        $weightedScore
    );

    return $CompletionOfCourseFolder;
}

if (!function_exists('generateVirtueRating')) {
    function generateVirtueRating($avg)
    {

        if ($avg >= 90)
            return ['percentage' => $avg, 'rating' => 'OS', 'color' => 'bg-label-primary'];
        if ($avg >= 80)
            return ['percentage' => $avg, 'rating' => 'EE', 'color' => 'bg-label-success'];
        if ($avg >= 70)
            return ['percentage' => $avg, 'rating' => 'ME', 'color' => 'bg-label-warning'];
        if ($avg >= 60)
            return ['percentage' => $avg, 'rating' => 'NI', 'color' => 'bg-label-orange'];
        if ($avg >= 0)
            return ['percentage' => $avg, 'rating' => 'BE', 'color' => 'bg-label-danger'];
    }
}

if (!function_exists('lineManagerRatingOnTasksbk')) {
    function lineManagerRatingOnTasksbk($facultyId)
    {
        $feedbacks = LineManagerFeedback::where('employee_id', $facultyId)->get();

        foreach ($feedbacks as $item) {

            // Calculate per-virtue average
            $res_avg = ($item->responsibility_accountability_1 + $item->responsibility_accountability_2) / 2;
            $emp_avg = ($item->empathy_compassion_1 + $item->empathy_compassion_2) / 2;
            $hum_avg = ($item->humility_service_1 + $item->humility_service_2) / 2;
            $hon_avg = ($item->honesty_integrity_1 + $item->honesty_integrity_2) / 2;
            $ins_avg = ($item->inspirational_leadership_1 + $item->inspirational_leadership_2) / 2;

            // Assign virtue array with rating & color
            $item->virtues = [
                [
                    'name' => 'Honesty & Integrity',
                    'avg' => $hon_avg,
                    'rating_data' => generateVirtueRating($hon_avg)
                ],
                [
                    'name' => 'Humility & Service',
                    'avg' => $hum_avg,
                    'rating_data' => generateVirtueRating($hum_avg)
                ],
                [
                    'name' => 'Empathy & Compassion',
                    'avg' => $emp_avg,
                    'rating_data' => generateVirtueRating($emp_avg)
                ],
                [
                    'name' => 'Responsibility & Accountability',
                    'avg' => $res_avg,
                    'rating_data' => generateVirtueRating($res_avg)
                ],
                [
                    'name' => 'Inspirational Leadership',
                    'avg' => $ins_avg,
                    'rating_data' => generateVirtueRating($ins_avg)
                ],
            ];
        }

        return $feedbacks;
    }
}

if (!function_exists('lineManagerRatingOnTasks')) {
    function lineManagerRatingOnTasks($facultyId, $activeRoleId)
    {
        $feedbacks = LineManagerFeedback::where('employee_id', $facultyId)->get();

        $overallSum = 0;
        $totalCount = 0;

        foreach ($feedbacks as $item) {

            // Calculate per-virtue average
            $res_avg = ($item->responsibility_accountability_1 + $item->responsibility_accountability_2) / 2;
            $emp_avg = ($item->empathy_compassion_1 + $item->empathy_compassion_2) / 2;
            $hum_avg = ($item->humility_service_1 + $item->humility_service_2) / 2;
            $hon_avg = ($item->honesty_integrity_1 + $item->honesty_integrity_2) / 2;
            $ins_avg = ($item->inspirational_leadership_1 + $item->inspirational_leadership_2) / 2;

            // Assign virtue array for existing display
            $item->virtues = [
                ['name' => 'Honesty & Integrity', 'avg' => $hon_avg, 'rating_data' => generateVirtueRating($hon_avg)],
                ['name' => 'Humility & Service', 'avg' => $hum_avg, 'rating_data' => generateVirtueRating($hum_avg)],
                ['name' => 'Empathy & Compassion', 'avg' => $emp_avg, 'rating_data' => generateVirtueRating($emp_avg)],
                ['name' => 'Responsibility & Accountability', 'avg' => $res_avg, 'rating_data' => generateVirtueRating($res_avg)],
                ['name' => 'Inspirational Leadership', 'avg' => $ins_avg, 'rating_data' => generateVirtueRating($ins_avg)],
            ];

            // Add to overall sum
            $overallSum += ($res_avg + $emp_avg + $hum_avg + $hon_avg + $ins_avg) / 5;
            $totalCount++;
        }

        // Calculate overall average
        $overallAvg = $totalCount ? $overallSum / $totalCount : 0;
        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', 188)['weightage'],
        ];
        $weightedScore = ($overallAvg * $weights['course_load']) / 100;
        // Save overall average to database
        saveIndicatorPercentage(
            $faculty_id = $facultyId,
            $role_id = $activeRoleId,
            $keyPerformanceAreaId = 13,  // set appropriate KPA ID
            $indicatorCategoryId = 27,   // set appropriate category ID
            $indicatorId = 188,         // set appropriate indicator ID
            $weightedScore,
            $overallAvg
        );

        return $feedbacks;
    }
}

if (!function_exists('saveIndicatorPercentage')) {
    function saveIndicatorPercentage($employeeId, $role_id, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId, $score, $withOutWeightScore = null)
    {
        // Determine color and rating based on score
        // if ($score >= 90 && $score <= 100) {
        //     $color = 'primary';
        //     $rating = 'OS';
        // } elseif ($score >= 80) {
        //     $color = 'success';
        //     $rating = 'EE';
        // } elseif ($score >= 70) {
        //     $color = 'warning';
        //     $rating = 'ME';
        // } elseif ($score >= 60) {
        //     $color = 'orange';
        //     $rating = 'NI';
        // } elseif ($score >= 50) {
        //     $color = 'danger';
        //     $rating = 'BE';
        // } else {
        //     $color = 'secondary';
        //     $rating = 'NA';
        // }
        $exists = DB::table('role_kpa_assignments')
            ->where('role_id', $role_id)
            ->where('indicator_id', $indicatorId)
            ->exists();

        if (!$exists) {
            return; // stop execution if not assigned
        }

        // Determine rating
        if ($score >= 90) {
            $color = 'primary';
            $rating = 'OS';
        } elseif ($score >= 80) {
            $color = 'success';
            $rating = 'EE';
        } elseif ($score >= 70) {
            $color = 'warning';
            $rating = 'ME';
        } elseif ($score >= 60) {
            $color = 'orange';
            $rating = 'NI';
        } else {
            $color = 'danger';
            $rating = 'BE';
        }

        IndicatorsPercentage::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'role_id' => $role_id,
                'key_performance_area_id' => $keyPerformanceAreaId,
                'indicator_category_id' => $indicatorCategoryId,
                'indicator_id' => $indicatorId,
            ],
            [
                'score' => number_format($score, 2),
                'with_out_weight_score' => number_format($withOutWeightScore, 1),
                'color' => $color,
                'rating' => $rating,
            ]
        );
    }
}

if (!function_exists('saveIndicatorPercentage90Plus')) {
    function saveIndicatorPercentage90Plus($employeeId, $role_id, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId, $score, $withOutWeightScore = null)
    {
        if ($score >= 95) {
            $color = 'primary';
            $rating = 'OS';
        } elseif ($score >= 90) {
            $color = 'success';
            $rating = 'EE';
        } elseif ($score >= 80) {
            $color = 'warning';
            $rating = 'ME';
        } elseif ($score >= 70) {
            $color = 'orange';
            $rating = 'NI';
        } else {
            $color = 'danger';
            $rating = 'BE';
        }

        IndicatorsPercentage::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'role_id' => $role_id,
                'key_performance_area_id' => $keyPerformanceAreaId,
                'indicator_category_id' => $indicatorCategoryId,
                'indicator_id' => $indicatorId,
            ],
            [
                'score' => number_format($score, 2),
                'color' => $color,
                'rating' => $rating,
            ]
        );
    }
}


function lineManagerRatingOnEvents($facultyId, $activeRoleId)
{
    $feedbacks = LineManagerEventFeedback::where('employee_id', $facultyId)->get();

    if ($feedbacks->isEmpty()) {
        return [];
    }

    $total = 0;
    $count = $feedbacks->count();

    foreach ($feedbacks as $item) {
        $total += $item->rating;

        // Label logic (keep this if needed for UI)
        $percentage = round($item->rating, 1);

        if ($percentage >= 90) {
            $label = 'OS';
            $color = 'bg-label-primary';
        } elseif ($percentage >= 80) {
            $label = 'EE';
            $color = 'bg-label-success';
        } elseif ($percentage >= 70) {
            $label = 'ME';
            $color = 'bg-label-warning';
        } elseif ($percentage >= 60) {
            $label = 'NI';
            $color = 'bg-label-orange';
        } else {
            $label = 'BE';
            $color = 'bg-label-danger';
        }

        $item->rating_data = [
            'percentage' => $percentage,
            'label' => $label,
            'color' => $color
        ];
    }

    // ✅ Average calculation
    $averagePercentage = $total / $count;

    // ✅ Apply weight
    $weight = getRoleWeightage($activeRoleId, 'indicator', 189)['weightage'];
    $weightedScore = ($averagePercentage * $weight) / 100;

    // ✅ Save ONCE
    saveIndicatorPercentage(
        $facultyId,
        $activeRoleId,
        13,
        28,
        189,
        $weightedScore,
        $averagePercentage
    );

    return $feedbacks;
}

// function avgKpaScore($employeeId, $kpaId)
// {
//     $avg = IndicatorsPercentage::where('employee_id', $employeeId)
//         ->where('key_performance_area_id', $kpaId)
//         ->avg('score'); // Eloquent will run SQL AVG()

//     return round($avg ?? 0, 2);
// }

function avgKpaScore($employeeId, $kpaId)
{
    // Memoize per-request to avoid duplicate calculations in Blade.
    static $memo = [];

    $userRoleId = getRoleIdByName(activeRole());
    $key = $employeeId . '|' . $kpaId . '|' . $userRoleId;
    if (array_key_exists($key, $memo)) {
        return $memo[$key];
    }

    // Get all scores for the employee and KPA
    $scores = IndicatorsPercentage::where('employee_id', $employeeId)
        ->where('key_performance_area_id', $kpaId)
        ->where('role_id', $userRoleId)
        ->pluck('score'); // get array of scores

    if ($scores->isEmpty()) {
        return 0;
    }
    // Cap each score at 100
    $cappedScores = $scores->map(fn($score) => min($score, 100));

    // Calculate average
    $avg = $cappedScores->avg();
    $weightage = getRoleWeightage($userRoleId, 'kpa', $kpaId)['weightage'];
    $weightedScore = ($avg * $weightage) / 100;
    $result = number_format($weightedScore, 1);
    $memo[$key] = $result;
    return $result;
}

if (!function_exists('ResearchProductivityofPGStudents')) {
    function ResearchProductivityofPGStudents($facultyId, $activeRoleId, $indicatorId)
    {
        $facultyTargets = FacultyTarget::with([
            'researchPublicationTargetsPgStudents' => function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
                    ->whereNotNull('journal_clasification')
                    ->with([
                        'coAuthors' => function ($q) {
                            $q->where('your_role', 'Student'); // Only student co-authors
                        }
                    ])->orderBy('target_category', 'DESC');
            }
        ])
            ->where('user_id', $facultyId)
            ->where('form_status', 'HOD')
            ->where('indicator_id', $indicatorId)
            ->whereHas('researchPublicationTargetsPgStudents', function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
                    ->whereNotNull('journal_clasification')
                    ->whereHas('coAuthors', function ($q) {
                        $q->where('your_role', 'Student');
                    });
            })
            ->get();
        // dd($facultyTargets);
        $data = [];
        $percentages = []; // Initialize to avoid count() on null

        $ratingColors = [
            'OS' => '#6EA8FE',
            'EE' => '#96e2b4',
            'ME' => '#ffcb9a',
            'NI' => '#fd7e13',
            'BE' => '#ff4c51',
        ];

        foreach ($facultyTargets as $facultyTarget) {
            if ($facultyTarget->researchPublicationTargetsPgStudents->isEmpty())
                continue;

            // Group research targets by journal_clasification
            $grouped = $facultyTarget->researchPublicationTargetsPgStudents
                ->groupBy(fn($t) => strtoupper($t->journal_clasification));

            foreach ($grouped as $classification => $targets) {
                // Get faculty value dynamically
                $value = match (strtolower($classification)) {
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
                $percentages[] = $percentage;

                // Determine rating
                if ($percentage >= 90)
                    $rating = 'OS';
                elseif ($percentage >= 80)
                    $rating = 'EE';
                elseif ($percentage >= 70)
                    $rating = 'ME';
                elseif ($percentage >= 60)
                    $rating = 'NI';
                else
                    $rating = 'BE';

                // Pick first target for optional fields
                $firstTarget = $targets->first();
                $coAuthorsdata = $firstTarget->coAuthors->first() ?? null;
                $studentRoll = $coAuthorsdata->student_roll_no ?? '-';
                $studentcareer = $coAuthorsdata->career ?? '-';

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
                    'student_roll_no' => $studentRoll,
                    'student_career' => $studentcareer,
                ];
            }
        }

        $avgPercentage = count($percentages)
            ? round(array_sum($percentages) / count($percentages), 2)
            : 0;
        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', 133)['weightage'],
        ];
        $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
        saveIndicatorPercentage(
            $facultyId,
            $role_id = $activeRoleId,
            $keyPerformanceAreaId = 2,
            $indicatorCategoryId = 6,
            $indicatorId = 133,
            $weightedScore
        );

        return $data;
    }
}

function overallAvgScore($emp_id)
{
    $avg = IndicatorsPercentage::where('employee_id', $emp_id)
        ->avg('score');

    $avg = $avg ? round($avg, 2) : 0.00;

    // Determine rating & color dynamically
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
    } else {
        $color = 'danger';
        $rating = 'BE';
    }

    return [
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}

if (!function_exists('kpaAvgWeightage')) {
    function kpaAvgWeightage($kpa_id, $role_id)
    {

        $RoleKpaAssignment = RoleKpaAssignment::where('role_id', $role_id)
            ->where('key_performance_area_id', $kpa_id)
            ->first();
        if ($RoleKpaAssignment) {
            return [
                'role_id' => $RoleKpaAssignment->role_id,
                'key_performance_area_id' => $RoleKpaAssignment->key_performance_area_id,
                'kpa_weightage' => $RoleKpaAssignment->kpa_weightage,
            ];
        }
        return [
            'role_id' => 0,
            'key_performance_area_id' => 0,
            'kpa_weightage' => 0,
        ];



    }
}

if (!function_exists('getRoleWeightage')) {
    function getRoleWeightage($role_id, $type, $id)
    {
        // Memoize per-request to avoid repeating the same lookup many times in Blade.
        static $memo = [];
        $key = $role_id . '|' . $type . '|' . $id;
        if (array_key_exists($key, $memo)) {
            return $memo[$key];
        }

        $query = RoleKpaAssignment::where('role_id', $role_id);

        if ($type == 'kpa') {
            $query->where('key_performance_area_id', $id);
            $column = 'kpa_weightage';
        } elseif ($type == 'indicator') {
            $query->where('indicator_id', $id);
            $column = 'indicator_weightage';
        } else {
            return [
                'type' => $type,
                'role_id' => $role_id,
                'id' => $id,
                'weightage' => 0
            ];
        }

        $record = $query->first();

        $result = [
            'type' => $type,
            'role_id' => $role_id,
            'id' => $id,
            'weightage' => $record ? ($record->$column ?? 0) : 0,
        ];

        $memo[$key] = $result;
        return $result;
    }
}
function kpaAvgScore($kpaId, $employeeId)
{
    $userRoleId = getRoleIdByName(activeRole());

    // Get all scores for the employee and KPA
    $scores = IndicatorsPercentage::where('employee_id', $employeeId)
        ->where('key_performance_area_id', $kpaId)
        ->where('role_id', $userRoleId)
        ->pluck('score'); // get array of scores

    if ($scores->isEmpty()) {
        return 0;
    }

    // Cap each score at 100
    $cappedScores = $scores->map(fn($score) => min($score, 100));

    // Calculate average
    $avg = $cappedScores->avg();
    $weightage = getRoleWeightage($userRoleId, 'kpa', $kpaId)['weightage'];
    $weightedScore = ($avg * $weightage) / 100;

    if ($weightedScore >= 90) {
        $color = 'primary';
        $rating = 'OS';
    } elseif ($weightedScore >= 80) {
        $color = 'success';
        $rating = 'EE';
    } elseif ($weightedScore >= 70) {
        $color = 'warning';
        $rating = 'ME';
    } elseif ($weightedScore >= 60) {
        $color = 'orange';
        $rating = 'NI';
    } else {
        $color = 'danger';
        $rating = 'BE';
    }

    return [
        'avg' => $avg,
        'weighted_score' => $weightedScore,
        'rating' => $rating,
        'color' => $color,
        'weight' => $weightage,
    ];
}

function indicatorAvgScore($indicator_id, $emp_id)
{
    // $avg = IndicatorsPercentage::where('employee_id', $emp_id)
    //     ->where('indicator_id', $indicator_id)
    //     ->value('score');
    $record = IndicatorsPercentage::where('employee_id', $emp_id)
        ->where('indicator_id', $indicator_id)
        ->orderBy('id')
        ->first();

    $avg = $record ? round($record->score, 2) : 0.00;

    //$avg = $avg ? round($avg, 2) : 0.00;

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
    } else {
        $color = 'danger';
        $rating = 'BE';
    }

    return [
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}

function indicatorCategoryAvgScore($category_id, $kpa_id, $emp_id)
{
    $roleId = getRoleIdByName(activeRole());
    $avgs = IndicatorsPercentage::where('employee_id', $emp_id)
        ->where('key_performance_area_id', $kpa_id)
        ->where('indicator_category_id', $category_id)
        ->where('role_id', $roleId)
        ->avg('score');

    $target = RoleKpaAssignment::where('role_id', $roleId)
        ->where('key_performance_area_id', $kpa_id)
        ->where('indicator_category_id', $category_id)
        ->sum('indicator_weightage');
    $avg = $target > 0 ? ($avgs / $target) * 100 : 0;
    $avg = $avg ? round($avg, 2) : 0.00;

    // Determine rating & color dynamically
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
    } else {
        $color = 'danger';
        $rating = 'BE';
    }

    return [
        'target' => $target,
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}

function topThreeIndicators(int $kpaId, int $employeeId = null): array
{
    $employeeId = $employeeId ?? auth()->id();

    // Fetch top 3 indicators ordered by score descending
    $topIndicators = \DB::table('indicators_percentages')
        ->where('employee_id', $employeeId)
        ->where('key_performance_area_id', $kpaId)
        ->orderByDesc('score')
        ->limit(3)
        ->pluck('indicator_id')
        ->toArray();

    return $topIndicators;
}
function Research_publication_count($facultyId, $indicator_id)
{
    $facultyTargets = FacultyTarget::with([
        'researchPublicationTargets' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicator_id);
        }
    ])
        ->where('user_id', $facultyId)
        ->where('form_status', 'HOD')
        ->where('indicator_id', $indicator_id)
        ->get();

    $percentages = []; // To calculate overall average

    foreach ($facultyTargets as $target) {

        $achieved = $target->researchPublicationTargets->count(); // Number of achieved publications
        $required = (int) $target->target;                          // Faculty target value

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

        // Save for average calculation
        $percentages[] = $percentage;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Add calculated values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }



    return $facultyTargets;
}
function Research_Innovation_Commercialization($facultyId, $activeRoleId, $indicator_id)
{
    $PIP = PatentsIntellectualProperty($facultyId, $activeRoleId, 138)->first();
    $CG = CommercialGainsCounsultancyResearchIncome($facultyId, $activeRoleId, 137)->first();
    $MP = MultidisciplinaryProjects($facultyId, $activeRoleId, 136)->first();
    $RP = Research_publication_count($facultyId, 128)->first();


    return [
        "RP" => [
            "title" => 'Research Publications',
            "cod" => 'RP',
            "target" => $RP?->target ?? 0,
            "achieved" => $RP?->achieved_count ?? 0,
            "percentage" => $RP?->percentage ?? 0,
            "color" => $RP?->color ?? '#000'
        ],
        "PIP" => [
            "title" => 'Patents & IP',
            "cod" => 'PIP',
            "target" => $PIP?->target ?? 0,
            "achieved" => $PIP?->achieved_count ?? 0,
            "percentage" => $PIP?->percentage ?? 0,
            "color" => $PIP?->color ?? '#000'
        ],
        "CG" => [
            "title" => 'Commercial Gains',
            "cod" => 'CG',
            "target" => $CG?->target ?? 0,
            "achieved" => $CG?->achieved_count ?? 0,
            "percentage" => $CG?->percentage ?? 0,
            "color" => $CG?->color ?? '#000'
        ],
        "MP" => [
            "title" => 'Multidisciplinary Projects',
            "cod" => 'MP',
            "target" => $MP?->target ?? 0,
            "achieved" => $MP?->achieved_count ?? 0,
            "percentage" => $MP?->percentage ?? 0,
            "color" => $MP?->color ?? '#000'
        ],
    ];

}


if (!function_exists('getIndicatorsByScore')) {
    function getIndicatorsByScore($scoreCompare, $scoreValue, $employeeId = null, $kpaId = null, $isBadge = null)
    {
        $roleId = getRoleIdByName(activeRole());
        $query = IndicatorsPercentage::with([
            'kpa:id,short_code',
            'category:id,cat_short_code',
            'indicator:id,indicator,icon',
            'user:employee_id,name,email,job_title,department'
        ]);

        // Optional filters
        if (!empty($employeeId)) {
            $query->where('employee_id', $employeeId);
        }

        // Optional filters
        if (!empty($isBadge)) {
            $query->where('is_badge', $isBadge);
        }

        if (!empty($kpaId)) {
            $query->where('key_performance_area_id', $kpaId);
        }

        return $query
            ->where('score', $scoreCompare, $scoreValue)
            ->where('role_id', $roleId)
            ->get([
                'id',
                'employee_id',
                'key_performance_area_id',
                'indicator_category_id',
                'indicator_id',
                'score',
                'rating',
                'color',
                'badge_name'
            ]);
    }
}
if (!function_exists('getRatingByPercentage')) {
    /**
     * Get rating and color based on percentage
     *
     * @param float|int $percentage
     * @return array
     */
    function getRatingByPercentage($percentage)
    {
        if ($percentage > 99) {
            $percentage = 99;
        }
        $rule = RatingRule::where('min_percentage', '<=', $percentage)
            ->where('max_percentage', '>', $percentage)
            ->orderBy('min_percentage', 'desc')
            ->first();


        if (!$rule) {
            return [
                'min_percentage' => 0,
                'max_percentage' => 0,
                'rating' => 'BE',
                'description' => 'NA',
                'color' => '#000000'
            ];
        }

        return [
            'min_percentage' => $rule->min_percentage,
            'max_percentage' => $rule->max_percentage,
            'rating' => $rule->rating,
            'description' => $rule->description,
            'color' => $rule->color
        ];
    }
}
if (!function_exists('getAllCountries')) {
    /**
     * Get countries from JSON file
     *
     * @return array
     */
    function getAllCountries()
    {
        $path = public_path('admin/assets/json/countries.json');

        if (!File::exists($path)) {
            return [];
        }

        $json = File::get($path);

        $data = json_decode($json, true);
        return $data;
    }
}
if (!function_exists('getUniveristyJson')) {
    /**
     * Get countries from JSON file
     *
     * @return array
     */
    function getUniveristyJson()
    {
        $path = public_path('admin/assets/json/univeristy.json');

        if (!File::exists($path)) {
            return [];
        }

        $json = File::get($path);

        $data = json_decode($json, true);
        return $data;
    }
}

if (!function_exists('lineManagerRemarksOnTasks')) {
    function lineManagerRemarksOnTasks($facultyId)
    {
        $remarks = LineManagerFeedback::where('employee_id', $facultyId)->value('remarks');
        return $remarks ?: 'No remarks yet'; // empty string will fallback
    }
}

if (!function_exists('getTopIndicatorsOfEmployee')) {
    function getTopIndicatorsOfEmployee($employeeId)
    {
        $indicators = IndicatorsPercentage::with('kpa:id,performance_area,short_code,icon')
            ->where('employee_id', $employeeId)
            ->get([
                'key_performance_area_id',
                'score'
            ]);

        // Calculate average, color, and rating per KPA
        $avgByKpa = $indicators
            ->groupBy('key_performance_area_id')
            ->map(function ($group, $kpaId) {
                $avg = round($group->avg('score'), 2);

                // Determine color and rating based on avg
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
                    $color = 'ni';
                    $rating = 'NI';
                } else {
                    $color = 'danger';
                    $rating = 'BE';
                }

                // Get KPA info from first record
                $kpa = $group->first()->kpa;

                return [
                    'kpa_id' => $kpaId,
                    'performance_area' => $kpa->performance_area ?? null,
                    'kpa_short_code' => $kpa->short_code ?? null,
                    'icon' => $kpa->icon ?? null,
                    'avg' => $avg,
                    'color' => $color,
                    'rating' => $rating
                ];
            });

        return $avgByKpa;
    }
}

if (!function_exists('activeRole')) {
    function activeRole()
    {
        static $memo;
        static $hasMemo = false;
        if ($hasMemo) {
            return $memo;
        }

        if (session()->has('active_role')) {
            $memo = session('active_role');
            $hasMemo = true;
            return $memo;
        }

        if (!auth()->check()) {
            $memo = null;
            $hasMemo = true;
            return $memo;
        }

        // Fallback for old sessions
        $role = auth()->user()->roles->first()?->name;

        $teacherRoles = [
            'Teacher',
            'Assistant Professor',
            'Associate Professor',
            'Professor',
            'Program Leader UG',
            'Program Leader PG',
            'Finance',
            'International Office',
            'Human Resources',
            'QCE',
            'OEC',
            'DOPS',
            'Alumni Office',
            'Employability Center',
            'HOD',
            'Dean',
            'Rector',
            'QCH',
            'ORIC'
        ];

        // if (in_array($role, $teacherRoles)) {
        //     return 'teacher';
        // }

        $memo = strtolower($role); // hod, admin, etc.
        $hasMemo = true;
        return $memo;
    }
}

if (!function_exists('forVirtueReport')) {
    function forVirtueReport($employeeId = null, $createdBy = null)
    {
        $query = LineManagerFeedback::query(); // Fix: use query builder

        if (!empty($employeeId)) {
            $query->where('employee_id', $employeeId);
        }

        if (!empty($createdBy)) { // Fix: check $createdBy instead of $employeeId
            $query->where('created_by', $createdBy);
        }

        $feedbacks = $query->get();
        $insideData = [];

        if ($feedbacks->count()) {
            // Take the first feedback or average them
            $first = $feedbacks->first();

            $res_avg = ($first->responsibility_accountability_1 + $first->responsibility_accountability_2) / 2;
            $emp_avg = ($first->empathy_compassion_1 + $first->empathy_compassion_2) / 2;
            $hum_avg = ($first->humility_service_1 + $first->humility_service_2) / 2;
            $hon_avg = ($first->honesty_integrity_1 + $first->honesty_integrity_2) / 2;
            $ins_avg = ($first->inspirational_leadership_1 + $first->inspirational_leadership_2) / 2;

            $insideData = [$res_avg, $emp_avg, $hum_avg, $hon_avg, $ins_avg];
        } else {
            $insideData = [0, 0, 0, 0, 0]; // fallback if no data
        }

        return $insideData;
    }
}

if (!function_exists('getRoleIdByName')) {
    function getRoleIdByName(?string $roleName = null)
    {
        if (empty($roleName)) {
            return null;
        }

        static $memo = [];
        if (array_key_exists($roleName, $memo)) {
            return $memo[$roleName];
        }

        $result = Role::where('name', $roleName)->value('id') ?? null;
        $memo[$roleName] = $result;
        return $result;
    }
}

if (!function_exists('getStudentFeedbackByBarcode')) {
    function getStudentFeedbackByBarcode(string $barcode)
    {
        $feedback = DB::table('student_feedback')
            ->select(
                DB::raw("CAST(REPLACE(empathy_compassion, '%', '') AS DECIMAL(5,1)) AS empathy_compassion"),
                DB::raw("CAST(REPLACE(honesty_integrity, '%', '') AS DECIMAL(5,1)) AS honesty_integrity"),
                DB::raw("CAST(REPLACE(inspirational_leadership, '%', '') AS DECIMAL(5,1)) AS inspirational_leadership"),
                DB::raw("CAST(REPLACE(responsibility_accountability, '%', '') AS DECIMAL(5,1)) AS responsibility_accountability")
            )
            ->where('faculty_member', 'LIKE', '%' . $barcode . '%')
            ->first(); // only need first record

        // Default fallback
        if (!$feedback) {
            return [0, 0, 0, 0];
        }

        return [
            number_format($feedback->responsibility_accountability, 1),
            number_format($feedback->empathy_compassion, 1),
            number_format($feedback->inspirational_leadership, 1),
            number_format($feedback->honesty_integrity, 1),
            number_format($feedback->inspirational_leadership, 1),
        ];
    }
}
if (!function_exists('getStudentFeedbackForTeacher')) {
    function getStudentFeedbackForTeacher(?int $facultyId)
    {
        if (!$facultyId) {
            return null; // or 0 if you prefer
        }

        return StudentFeedbackClassWise::query()
            ->join(
                'faculty_member_classes',
                'faculty_member_classes.code',
                '=',
                'student_feedback_class_wises.component_class'
            )
            ->where('faculty_member_classes.faculty_id', $facultyId)
            ->avg('student_feedback_class_wises.feedback');
    }
}

if (!function_exists('getFacultyClassWiseFeedback')) {
    function getFacultyClassWiseFeedback(?int $facultyId)
    {
        static $memo = [];
        $key = (string) $facultyId;
        if (array_key_exists($key, $memo)) {
            return $memo[$key];
        }

        $result = StudentFeedbackClassWise::query()
            ->join(
                'faculty_member_classes',
                'faculty_member_classes.code',
                '=',
                'student_feedback_class_wises.component_class'
            )
            ->where('faculty_member_classes.faculty_id', $facultyId)
            ->select(
                'student_feedback_class_wises.*',
                'faculty_member_classes.code as class_code',
                'faculty_member_classes.faculty_id'
            )
            ->get();
        // Calculate sum of feedback (numeric)
        $totalFeedback = $result->sum(function ($item) {
            return (float) str_replace('%', '', $item->feedback);
        });


        // Return both collection and sum as an array
        $data = [
            'collection' => $result,
            'totalFeedback' => $totalFeedback,
        ];

        $memo[$key] = $data;

        return $data;
    }
}

if (!function_exists('indicatorsPercentageStatus')) {
    function indicatorsPercentageStatus($user)
    {
        if ($user->indicators_percentage_status) {
            return; // Already initialized
        }

        // Get all roles of the user
        $roleIds = $user->roles->pluck('id')->toArray();
        if (empty($roleIds)) {
            $user->update(['indicators_percentage_status' => false]);
            return;
        }

        // Get all assignments for these roles
        $assignments = RoleKpaAssignment::whereIn('role_id', $roleIds)->get();
        if ($assignments->isEmpty()) {
            $user->update(['indicators_percentage_status' => false]);
            return;
        }

        // Fetch all existing indicators for this user and these roles in ONE query
        $existing = IndicatorsPercentage::where('employee_id', $user->id)
            ->whereIn('role_id', $roleIds)
            ->get(['role_id', 'key_performance_area_id', 'indicator_category_id', 'indicator_id'])
            ->map(function ($i) {
                return $i->role_id . '-' . $i->key_performance_area_id . '-' . $i->indicator_category_id . '-' . $i->indicator_id;
            })
            ->toArray();

        // Prepare missing rows
        $insert = [];
        foreach ($assignments as $row) {
            $key = $row->role_id . '-' . $row->key_performance_area_id . '-' . $row->indicator_category_id . '-' . $row->indicator_id;

            if (!in_array($key, $existing)) {
                $insert[] = [
                    'employee_id' => $user->id,
                    'role_id' => $row->role_id,
                    'key_performance_area_id' => $row->key_performance_area_id,
                    'indicator_category_id' => $row->indicator_category_id,
                    'indicator_id' => $row->indicator_id,
                    'score' => 0,
                    'rating' => 'BE',
                    'color' => 'danger',
                    'badge_name' => null,
                    'given_by' => null,
                    'status' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all missing rows at once
        if (!empty($insert)) {
            IndicatorsPercentage::insert($insert);
        }

        // Mark user as initialized
        $user->update(['indicators_percentage_status' => true]);
    }
}
if (!function_exists('get_faculties')) {
    function get_faculties($id = null)
    {
        if ($id) {
            return Faculty::find($id);
        }

        return Faculty::all();
    }
}
if (!function_exists('get_departments')) {

    function get_departments($faculty_id = null)
    {
        if ($faculty_id) {
            return Department::where('faculty_id', $faculty_id)->get();
        }

        return Department::all();
    }
}
if (!function_exists('get_programs')) {

    function get_programs($department_id = null)
    {
        if ($department_id) {
            return Program::where('department_id', $department_id)->get();
        }

        return Program::all();
    }
}
if (!function_exists('get_faculty_members')) {
    /**
     * Get faculty members for the logged-in user.
     *
     * @param int|null $employeeId Optional employee ID, defaults to logged-in user.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_faculty_members($employeeId = null)
    {
        $user = Auth::user();

        // Use provided employeeId or logged-in user's employee_id
        $employeeId = $employeeId ?? $user->employee_id;

        return User::where('manager_id', $employeeId)
            ->orWhere('employee_id', $employeeId)
            ->get(['id', 'name', 'department', 'job_title', 'faculty_id']);
    }
}

if (!function_exists('getRoleName')) {

    function getRoleName($roleName = null)
    {
        if ($roleName) {
            static $memo = [];
            if (array_key_exists($roleName, $memo)) {
                return $memo[$roleName];
            }

            $result = Role::where('name', $roleName)->value('name') ?? null;
            $memo[$roleName] = $result;
            return $result;
        }
    }
}

function EmployabilityOfHOD()
{
    $departmentId = auth()->user()->department_id;

    $records = Employability::with(['faculty', 'department', 'program'])
        ->where('department_id', $departmentId)
        ->get();

    if ($records->count() == 0) {
        return collect();
    }

    $results = collect();

    $activeRoleId = getRoleIdByName(activeRole());
    $employeeId = auth()->id();

    $groupedByProgram = $records->groupBy('program_id');

    $programScores = [
        103 => collect(),
        104 => collect(),
        105 => collect(),
        106 => collect(),
        107 => collect(),
    ];

    /*
    |--------------------------------------------------------------------------
    | PROGRAM LEVEL CALCULATION
    |--------------------------------------------------------------------------
    */
    foreach ($groupedByProgram as $group) {

        $first = $group->first();
        $total = $group->count();

        // ---------------- 103 Employability ----------------
        $emp = $total
            ? round(($group->whereNotNull('date_of_appointment')->count() / $total) * 100, 2)
            : 0;

        $programScores[103]->push($emp);

        $results->push(makeIndicatorRow(
            'Student Employability',
            103,
            $emp,
            $first->faculty->name ?? '-',
            $first->department->name ?? '-',
            $first->program->program_name ?? '-'
        ));

        // ---------------- 104 Employer Satisfaction ----------------
        $score = 0;
        foreach ($group as $r) {
            if (!is_null($r->employer_satisfaction)) {
                $score += $r->employer_satisfaction * 20;
            }
        }

        $empSat = $total ? round($score / $total, 2) : 0;
        $programScores[104]->push($empSat);

        $results->push(makeIndicatorRow(
            'Employer Satisfaction',
            104,
            $empSat,
            $first->faculty->name ?? '-',
            $first->department->name ?? '-',
            $first->program->program_name ?? '-'
        ));

        // ---------------- 105 Job Relevancy ----------------
        $job = $total
            ? round(($group->where('job_relevancy', 'yes')->count() / $total) * 100, 2)
            : 0;

        $programScores[105]->push($job);

        $results->push(makeIndicatorRow(
            'Job Relevancy',
            105,
            $job,
            $first->faculty->name ?? '-',
            $first->department->name ?? '-',
            $first->program->program_name ?? '-'
        ));

        // ---------------- 106 Salary ----------------
        $salaryScore = 0;
        foreach ($group as $r) {
            $salaryScore += match ($r->market_competitive_salary) {
                'Low' => 33,
                'At Par' => 66,
                'Above' => 100,
                default => 0
            };
        }

        $salary = $total ? round($salaryScore / $total, 2) : 0;
        $programScores[106]->push($salary);

        $results->push(makeIndicatorRow(
            'Market Competitive Salary',
            106,
            $salary,
            $first->faculty->name ?? '-',
            $first->department->name ?? '-',
            $first->program->program_name ?? '-'
        ));

        // ---------------- 107 Graduate Satisfaction ----------------
        $score = 0;
        foreach ($group as $r) {
            if (!is_null($r->graduate_satisfaction)) {
                $score += $r->graduate_satisfaction * 20;
            }
        }

        $gradSat = $total ? round($score / $total, 2) : 0;
        $programScores[107]->push($gradSat);

        $results->push(makeIndicatorRow(
            'Graduate Satisfaction',
            107,
            $gradSat,
            $first->faculty->name ?? '-',
            $first->department->name ?? '-',
            $first->program->program_name ?? '-'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 DEPARTMENT LEVEL (CLEAN + FIXED)
    |--------------------------------------------------------------------------
    */

    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', 103)['weightage'],
        'course_104' => getRoleWeightage($activeRoleId, 'indicator', 104)['weightage'],
        'course_105' => getRoleWeightage($activeRoleId, 'indicator', 105)['weightage'],
        'course_106' => getRoleWeightage($activeRoleId, 'indicator', 106)['weightage'],
        'course_107' => getRoleWeightage($activeRoleId, 'indicator', 107)['weightage'],
    ];

    foreach ([103, 104, 105, 106, 107] as $indicator) {

        $avg = $programScores[$indicator]->count()
            ? round($programScores[$indicator]->avg(), 2)
            : 0;

        // ---------------- correct weight mapping ----------------
        $weightKey = match ($indicator) {
            103 => 'course_load',
            104 => 'course_104',
            105 => 'course_105',
            106 => 'course_106',
            107 => 'course_107',
        };

        $weightedScore = ($avg * $weights[$weightKey]) / 100;

        // ---------------- correct saving logic ----------------
        $use90Plus = in_array($indicator, [103, 105]);

        if ($use90Plus) {
            saveIndicatorPercentage90Plus(
                $employeeId,
                $activeRoleId,
                1,
                1,
                $indicator,
                $weightedScore
            );
        } else {
            saveIndicatorPercentage(
                $employeeId,
                $activeRoleId,
                1,
                1,
                $indicator,
                $weightedScore
            );
        }

        $results->push(makeIndicatorRow(
            'Overall Department',
            $indicator,
            $avg,
            '',
            '',
            ''
        ));
    }

    return $results;
}
function makeIndicatorRow($name, $indicatorId, $percentage, $faculty = null, $department = null, $program = null)
{
    if ($percentage >= 90) {
        $color = '#6EA8FE';
        $rating = 'OS';
    } elseif ($percentage >= 80) {
        $color = '#96e2b4';
        $rating = 'EE';
    } elseif ($percentage >= 70) {
        $color = '#ffcb9a';
        $rating = 'ME';
    } elseif ($percentage >= 60) {
        $color = '#fd7e13';
        $rating = 'NI';
    } else {
        $color = '#ff4c51';
        $rating = 'BE';
    }

    return (object) [
        'indicator_id' => $indicatorId,
        'class_name' => $name,
        'held_percentage' => $percentage,
        'color' => $color,
        'rating' => $rating,

        // NEW (SAFE)
        'faculty_name' => $faculty,
        'department_name' => $department,
        'program_name' => $program,
    ];
}

function NumberOfKnowledgeProduct($facultyId, $activeRoleId)
{
    // 1️⃣ Get all knowledge products created by the faculty
    $knowledgeProducts = \App\Models\NumberOfKnowledgeProduct::where('created_by', $facultyId)
        ->where('status', 2) // optional: only approved/active products
        ->get();

    $totalAchieved = $knowledgeProducts->count();

    // 2️⃣ Get the target from faculty_targets table
    $targetRecord = FacultyTarget::where('user_id', $facultyId)
        ->where('indicator_id', 194) // indicator_id for NumberOfKnowledgeProduct
        ->first();

    $target = $targetRecord ? $targetRecord->target : 0;

    // 3️⃣ Calculate score (percentage)
    $score = $target > 0 ? ($totalAchieved / $target) * 100 : 0;
    $score = round($score, 2);

    // 4️⃣ Determine rating based on score
    if ($score >= 90) {
        $rating = 'OS';
        $color = 'primary';
    } elseif ($score >= 80) {
        $rating = 'EE';
        $color = 'success';
    } elseif ($score >= 70) {
        $rating = 'ME';
        $color = 'warning';
    } elseif ($score >= 60) {
        $rating = 'NI';
        $color = 'orange';
    } else {
        $rating = 'BE';
        $color = 'danger';
    }
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', 194)['weightage'],
    ];
    $weightedScore = ($score * $weights['course_load']) / 100;
    saveIndicatorPercentage($facultyId, $activeRoleId, 2, 32, 194, $weightedScore);

    // 6️⃣ Return structured data for table
    return [
        'totalAchieved' => $totalAchieved,
        'target' => $target,
        'score' => $score,
        'rating' => $rating,
        'color' => $color,
        'knowledgeProducts' => $knowledgeProducts,
    ];
}

if (!function_exists('lineManagerReviewRatingOnTasks')) {
    function lineManagerReviewRatingOnTasks($facultyId, $activeRoleId)
    {
        $managerRatings = collect();
        $totalScore = 0;
        $taskCount = 0;

        $reviews = LineManagerReviewRating::with('tasks')
            ->where('employee_id', $facultyId)
            ->get();

        foreach ($reviews as $review) {
            foreach ($review->tasks as $task) {

                $score = $task->linemanager_rating * 20;
                $totalScore += $score;
                $taskCount++;

                if ($score >= 90) {
                    $label = 'OS';
                    $color = 'bg-primary';
                } elseif ($score >= 80) {
                    $label = 'EE';
                    $color = 'bg-success';
                } elseif ($score >= 70) {
                    $label = 'ME';
                    $color = 'bg-warning';
                } elseif ($score >= 60) {
                    $label = 'NI';
                    $color = 'bg-info';
                } else {
                    $label = 'BE';
                    $color = 'bg-danger';
                }


                $managerRatings->push((object) [
                    'task' => $task->task,
                    'rating_data' => [
                        'percentage' => $score,
                        'label' => $label,
                        'color' => $color
                    ]
                ]);
            }
        }
        $averageScore = $taskCount > 0 ? round($totalScore / $taskCount, 2) : 0;
        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', 175)['weightage'],
            'course_188' => getRoleWeightage($activeRoleId, 'indicator', 188)['weightage'],
        ];
        $weightedScore = ($averageScore * $weights['course_load']) / 100;
        $weightedScore188 = ($averageScore * $weights['course_188']) / 100;

        saveIndicatorPercentage($facultyId, $activeRoleId, 2, 34, 175, $weightedScore);
        saveIndicatorPercentage($facultyId, $activeRoleId, 13, 27, 188, $weightedScore188, $averageScore);
        return $managerRatings;
    }
}

function QECAuditRatingOfHOD($employeeId, $activeRoleId)
{
    $departmentId = auth()->user()->department_id;

    $records = QecAuditRating::with([
        'details.faculty',
        'details.department',
        'details.program'
    ])
        ->whereHas('details', function ($q) use ($departmentId) {
            $q->where('department_id', $departmentId);
        })
        ->get();

    $data = [];

    foreach ($records as $record) {

        foreach ($record->details as $detail) {

            if ($detail->department_id != $departmentId) {
                continue;
            }

            $percentage = 0;

            if ($detail->total_score > 0) {
                $percentage = ($detail->obtained_score / $detail->total_score) * 100;
            }

            // Rating logic example
            if ($percentage >= 90) {
                $label = 'OS';
                $color = 'bg-primary';
            } elseif ($percentage >= 80) {
                $label = 'EE';
                $color = 'bg-success';
            } elseif ($percentage >= 70) {
                $label = 'ME';
                $color = 'bg-warning';
            } elseif ($percentage >= 60) {
                $label = 'NI';
                $color = 'bg-info';
            } else {
                $label = 'BE';
                $color = 'bg-danger';
            }
            $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 110);
            $weight = $indicatorWeight['weightage'] ?? 0;
            $weightedScore = ($percentage * $weight) / 100;
            saveIndicatorPercentage($employeeId, $activeRoleId, 1, 3, 110, $weightedScore, $percentage);
            $data[] = (object) [
                'audit_term' => $detail->audit_term,
                'faculty' => $detail->faculty->name ?? '',
                'department' => $detail->department->name ?? '',
                'program' => $detail->program->program_name ?? '',
                'career' => $detail->program_level ?? '',
                'total_score' => $detail->total_score,
                'obtained_score' => $detail->obtained_score,
                'percentage' => round($percentage, 1),
                'rating' => $label,
                'color' => $color
            ];
        }
    }

    return $data;
}

function StudentAttendanceOfHOD($employeeId, $activeRoleId)
{
    $departmentId = auth()->user()->department_id;

    // Get all faculty in this department
    $facultyMembers = User::where('department_id', $departmentId)
        ->get(['faculty_id', 'name']);
    $data = [];

    foreach ($facultyMembers as $faculty) {

        // Get all classes of this faculty
        $classes = FacultyMemberClass::with([
            'attendances' => function ($q) {
                $q->orderBy('class_date', 'desc');
            }
        ])
            ->where('faculty_id', $faculty->faculty_id)
            ->get();

        foreach ($classes as $class) {

            // Get attendance summary for this class
            $attendance = $class->attendances->first(); // latest attendance

            if (!$attendance)
                continue;

            // Calculate percentage if not provided
            $percentage = 0;
            if ($attendance->present_count && $attendance->total_students) {
                $percentage = ($attendance->present_count / $attendance->total_students) * 100;
            }



            // Rating logic example
            if ($percentage >= 90) {
                $rating = 'OS';
                $color = 'bg-primary';
            } elseif ($percentage >= 80) {
                $rating = 'EE';
                $color = 'bg-success';
            } elseif ($percentage >= 70) {
                $rating = 'ME';
                $color = 'bg-warning';
            } elseif ($percentage >= 60) {
                $rating = 'NI';
                $color = 'bg-info';
            } else {
                $rating = 'BE';
                $color = 'bg-danger';
            }

            $data[] = (object) [
                'faculty_name' => $faculty->name,
                'class_name' => $class->class_name,
                'code' => $class->code,
                'term' => $class->term,
                'career' => $class->career,
                'program' => $attendance->program_name,
                'total_students' => $attendance->total_students,
                'present_count' => $attendance->present_count,
                'absent_count' => $attendance->absent_count,
                'percentage' => round($percentage, 2),
                'rating' => $rating,
                'color' => $color
            ];
        }
    }

    return $data;
}

function myDepartmentClassesAttendanceRecordHOD($employeeId, $activeRoleId)
{
    $departmentId = auth()->user()->department_id;

    // 1️⃣ Get all faculty in this department
    $facultyMembers = User::where('department_id', $departmentId)
        ->get(['id', 'faculty_id', 'name']);

    $allClasses = collect();

    foreach ($facultyMembers as $faculty) {

        // ✅ FIX: use users.id instead of faculty_id
        $classes = FacultyMemberClass::withCount([
            'attendances as total_rows',
            'attendances as class_held_count' => function ($query) {
                $query->where('att_marked', 1);
            },
            'attendances as class_not_held_count' => function ($query) {
                $query->where('att_marked', 0);
            },
        ])
            ->where('faculty_id', $faculty->faculty_id) // ✅ FIXED HERE
            ->get()
            ->map(function ($class) use ($faculty) {

                // Latest program name
                $class->program = $class->attendances()
                    ->latest('class_date')
                    ->value('program_name');

                // Held %
                $class->held_percentage = $class->total_rows
                    ? round(($class->class_held_count / $class->total_rows) * 100, 2)
                    : 0;

                // Not Held %
                $class->not_held_percentage = $class->total_rows
                    ? round(($class->class_not_held_count / $class->total_rows) * 100, 2)
                    : 0;

                // Faculty name
                $class->faculty_name = $faculty->name;

                return $class;
            });

        $allClasses = $allClasses->merge($classes);
    }

    // ✅ SAVE DEPARTMENT OVERALL (IMPORTANT)
    saveOverallAttendancePercentageOfHOD(
        $employeeId,
        $allClasses,
        1,
        3,
        117,
        $activeRoleId
    );

    return $allClasses;
}

function saveOverallAttendancePercentageOfHOD($employeeId, $classes, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId, $activeRoleId)
{

    // ✅ CORRECT FORMULA
    $totalHeld = $classes->sum('class_held_count');
    $totalClasses = $classes->sum('total_rows');

    if ($totalClasses == 0) {
        $overallPercentage = 0;
    } else {
        $overallPercentage = round(($totalHeld / $totalClasses) * 100, 2);
    }

    // 🎯 Rating Logic
    if ($overallPercentage == 100) {
        $color = 'warning';
        $rating = 'ME';
    } elseif ($overallPercentage >= 90) {
        $color = 'orange';
        $rating = 'NI';
    } else {
        $color = 'danger';
        $rating = 'BE';
    }

    // Weight
    $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 117);
    $weight = $indicatorWeight['weightage'] ?? 0;

    $weightedScore = ($overallPercentage * $weight) / 100;
    // Save
    IndicatorsPercentage::updateOrCreate(
        [
            'employee_id' => $employeeId,
            'role_id' => $activeRoleId,
            'key_performance_area_id' => $keyPerformanceAreaId,
            'indicator_category_id' => $indicatorCategoryId,
            'indicator_id' => $indicatorId,
        ],
        [
            'score' => $weightedScore,
            'rating' => $rating,
            'color' => $color,
        ]
    );

    return $overallPercentage;
}

function CompletionOfCourseFolderForHOD($activeRoleId, $indicator_id)
{
    $departmentId = auth()->user()->department_id;

    $facultyMembers = User::where('department_id', $departmentId)
        ->pluck('id', 'employee_id');

    $records = CompletionOfCourseFolder::with(['facultyClass'])
        ->whereIn('faculty_member_id', $facultyMembers)
        ->where('status', 2)
        ->where('completion_of_course_folder_indicator_id', $indicator_id)
        ->get();

    foreach ($records as $row) {

        $value = $row->completion_of_course_folder ?? 0;

        // ✅ SAFE RELATION
        $programId = optional($row->facultyClass)->program_id ?? 0;

        // Rating logic
        if ($value == 100) {
            $row->rating = 'OS';
            $row->color = '#6EA8FE';
            $row->status_folder = 'Completed';
        } elseif ($value >= 70) {
            $row->rating = 'ME';
            $row->color = '#ffcb9a';
            $row->status_folder = 'Partially Completed';
        } else {
            $row->rating = 'BE';
            $row->color = '#ff4c51';
            $row->status_folder = 'Not Completed';
        }

        $row->program_id = $programId;
    }

    // ✅ GROUP BY PROGRAM
    return $records->groupBy('program_id');
}

// function StudentEngagementRateForHOD($activeRoleId, $indicatorId)
// {
//     $departmentId = auth()->user()->department_id;

//     // Fetch all student engagement records for this department
//     $records = StudentEngagementRate::where('department_id', $departmentId)
//         ->where('indicator_id', $indicatorId)
//         ->get();

//     $totalParticipated = $records->sum('number_of_students_participated');
//     $totalTarget = $records->sum('participation_target');

//     // Calculate department-level participation %
//     $participationPercentage = $totalTarget > 0
//         ? round(($totalParticipated / $totalTarget) * 100, 2)
//         : 0;

//     // Rating & color logic
//     if ($participationPercentage >= 90) {
//         $rating = 'OS';
//         $color = '#6EA8FE';
//     } elseif ($participationPercentage >= 80) {
//         $rating = 'EE';
//         $color = '#96e2b4';
//     } elseif ($participationPercentage >= 70) {
//         $rating = 'ME';
//         $color = '#ffcb9a';
//     } elseif ($participationPercentage >= 60) {
//         $rating = 'NI';
//         $color = '#fd7e13';
//     } elseif ($participationPercentage >= 50) {
//         $rating = 'BE';
//         $color = '#ff4c51';
//     } else {
//         $rating = 'NA';
//         $color = '#d3d3d3';
//     }

//     // Weighted score
//     $weight = getRoleWeightage($activeRoleId, 'indicator', 123)['weightage'] ?? 0;
//     $weightedScore = ($participationPercentage * $weight) / 100;

//     // Save department-level KPI to IndicatorsPercentage
//     // Here we can use a "department employee_id" placeholder or any HOD representing the department
//     $hodEmployeeId = auth()->user()->employee_id;

//     saveIndicatorPercentage(
//         $hodEmployeeId,
//         $activeRoleId,
//         1, // keyPerformanceAreaId
//         4, // indicatorCategoryId
//         $indicatorId,
//         $weightedScore,
//     );

//     // Attach calculated data for display
//     $records->each(function ($record) use ($participationPercentage, $rating, $color) {
//         $record->participation_percentage = $participationPercentage;
//         $record->rating = $rating;
//         $record->color = $color;
//     });

//     return $records;
// }

function StudentEngagementRateForHOD($activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;

    $records = StudentEngagementRate::with(['faculty', 'department', 'program'])
        ->where('department_id', $departmentId)
        ->where('indicator_id', $indicatorId)
        ->get();

    $grouped = $records->groupBy('program_id');

    $programResults = collect();

    foreach ($grouped as $programRecords) {

        $totalParticipated = $programRecords->sum('number_of_students_participated');
        $totalTarget = $programRecords->sum('participation_target');

        $programPercentage = $totalTarget > 0
            ? round(($totalParticipated / $totalTarget) * 100, 2)
            : 0;

        $programResults->push($programPercentage);

        // Rating
        [$rating, $color] = match (true) {
            $programPercentage >= 90 => ['OS', '#6EA8FE'],
            $programPercentage >= 80 => ['EE', '#96e2b4'],
            $programPercentage >= 70 => ['ME', '#ffcb9a'],
            $programPercentage >= 60 => ['NI', '#fd7e13'],
            default => ['BE', '#ff4c51'],
        };

        $first = $programRecords->first();

        $result[] = (object) [
            'program_id' => $first->program_id,
            'program_name' => optional($first->program)->program_name,
            'faculty_name' => optional($first->faculty)->name,
            'department_name' => optional($first->department)->name,
            'participation_percentage' => $programPercentage,
            'rating' => $rating,
            'color' => $color,
        ];
    }

    // 🔥 FINAL FIX: AVERAGE OF PROGRAMS
    $overallPercentage = $programResults->count() > 0
        ? round($programResults->avg(), 2)
        : 0;

    // Save KPI using overall average
    $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
    $weightedScore = ($overallPercentage * $weight) / 100;

    saveIndicatorPercentage(
        auth()->user()->employee_id,
        $activeRoleId,
        1,
        4,
        $indicatorId,
        $weightedScore
    );

    return collect($result)->values();
}

function StudentSatisfactionRateForHOD($activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;

    $records = StudentEngagementRate::with(['faculty', 'department', 'program'])
        ->where('department_id', $departmentId)
        ->where('indicator_id', $indicatorId)
        ->get();

    $grouped = $records->groupBy('program_id');

    $programResults = collect();

    $map = [
        'Excellent' => 100,
        'Very Good' => 85,
        'Good' => 70,
        'Average' => 50,
        'Poor' => 30,
    ];

    $result = [];

    foreach ($grouped as $programRecords) {

        $totalSatisfaction = 0;
        $count = 0;

        foreach ($programRecords as $record) {
            if ($record->employer_satisfaction !== null) {

                $score = is_numeric($record->employer_satisfaction)
                    ? $record->employer_satisfaction
                    : ($map[$record->employer_satisfaction] ?? 0);

                $totalSatisfaction += $score;
                $count++;
            }
        }

        $programSatisfaction = $count > 0
            ? round(($totalSatisfaction / $count) * 20, 2)
            : 0;

        // store for final avg
        $programResults->push($programSatisfaction);

        // Rating logic
        [$rating, $color] = match (true) {
            $programSatisfaction >= 90 => ['OS', '#6EA8FE'],
            $programSatisfaction >= 80 => ['EE', '#96e2b4'],
            $programSatisfaction >= 70 => ['ME', '#ffcb9a'],
            $programSatisfaction >= 60 => ['NI', '#fd7e13'],
            default => ['BE', '#ff4c51'],
        };

        $first = $programRecords->first();

        $result[] = (object) [
            'program_id' => $first->program_id,
            'program_name' => optional($first->program)->program_name,
            'faculty_name' => optional($first->faculty)->name,
            'department_name' => optional($first->department)->name,

            'avg_employer_satisfaction' => $programSatisfaction,
            'rating' => $rating,
            'color' => $color,
        ];
    }

    // 🔥 FINAL: average of all programs
    $overallSatisfaction = $programResults->count() > 0
        ? round($programResults->avg(), 2)
        : 0;

    // Weighted KPI save
    $weight = getRoleWeightage($activeRoleId, 'indicator', 124)['weightage'] ?? 0;
    $weightedScore = ($overallSatisfaction * $weight) / 100;

    saveIndicatorPercentage(
        auth()->user()->employee_id,
        $activeRoleId,
        1,
        4,
        124,
        $weightedScore
    );

    return collect($result)->values();
}

function StudentEngagementRateForHODBKK($activeRoleId, $indicatorId)
{
    $departmentId = auth()->user()->department_id;

    // Fetch all student engagement records for this department
    $records = StudentEngagementRate::where('department_id', $departmentId)
        ->where('indicator_id', $indicatorId)
        ->get();

    $totalParticipated = $records->sum('number_of_students_participated');
    $totalTarget = $records->sum('participation_target');

    // Calculate department-level participation %
    $participationPercentage = $totalTarget > 0
        ? round(($totalParticipated / $totalTarget) * 100, 2)
        : 0;

    // Calculate average employer satisfaction
    // Map non-numeric satisfaction to numeric if needed
    $totalSatisfaction = 0;
    $satisfactionCount = 0;

    foreach ($records as $record) {
        if (!empty($record->employer_satisfaction)) {
            if (is_numeric($record->employer_satisfaction)) {
                $score = $record->employer_satisfaction;
            } else {
                // Example mapping, adjust as per your system
                $map = [
                    'Excellent' => 100,
                    'Very Good' => 85,
                    'Good' => 70,
                    'Average' => 50,
                    'Poor' => 30,
                ];
                $score = $map[$record->employer_satisfaction] ?? 0;
            }

            $totalSatisfaction += $score;
            $satisfactionCount++;
        }
    }

    $avgEmployerSatisfaction = $satisfactionCount > 0
        ? round($totalSatisfaction / $satisfactionCount, 2) * 20
        : 0;

    // Rating & color logic for participation
    if ($participationPercentage >= 90) {
        $rating = 'OS';
        $color = '#6EA8FE';
    } elseif ($participationPercentage >= 80) {
        $rating = 'EE';
        $color = '#96e2b4';
    } elseif ($participationPercentage >= 70) {
        $rating = 'ME';
        $color = '#ffcb9a';
    } elseif ($participationPercentage >= 60) {
        $rating = 'NI';
        $color = '#fd7e13';
    } else {
        $rating = 'BE';
        $color = '#ff4c51';
    }

    // Weighted score
    $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
    $weight124 = getRoleWeightage($activeRoleId, 'indicator', 124)['weightage'] ?? 0;
    $weightedScore = ($participationPercentage * $weight) / 100;
    $weightedScore124 = ($avgEmployerSatisfaction * $weight124) / 100;

    // Save department-level KPI to IndicatorsPercentage
    $hodEmployeeId = auth()->user()->employee_id;

    saveIndicatorPercentage(
        $hodEmployeeId,
        $activeRoleId,
        1, // keyPerformanceAreaId
        4, // indicatorCategoryId
        $indicatorId,
        $weightedScore, // optional extra field if your table supports it
    );

    saveIndicatorPercentage(
        $hodEmployeeId,
        $activeRoleId,
        1, // keyPerformanceAreaId
        4, // indicatorCategoryId
        124,
        $weightedScore124, // optional extra field if your table supports it
    );

    // Attach calculated data for display
    $records->each(function ($record) use ($participationPercentage, $rating, $color, $avgEmployerSatisfaction) {
        $record->participation_percentage = $participationPercentage;
        $record->rating = $rating;
        $record->color = $color;
        $record->avg_employer_satisfaction = $avgEmployerSatisfaction;
    });

    return $records;
}

if (!function_exists('getDepartmentFacultyFeedbackForHOD')) {
    function getDepartmentFacultyFeedbackForHOD($activeRoleId)
    {
        $departmentId = auth()->user()->department_id;

        $records = StudentFeedbackClassWise::query()
            ->join(
                'faculty_member_classes',
                'faculty_member_classes.code',
                '=',
                'student_feedback_class_wises.component_class'
            )
            ->join(
                'users',
                'users.faculty_id',
                '=',
                'faculty_member_classes.faculty_id'
            )
            ->where('users.department_id', $departmentId)
            ->select(
                'student_feedback_class_wises.program',
                'student_feedback_class_wises.feedback',
                'student_feedback_class_wises.attempts',
                'student_feedback_class_wises.registered_students',
                'faculty_member_classes.career_code'
            )
            ->get();

        // ✅ CLEAN FEEDBACK VALUES
        $records = $records->map(function ($item) {
            $item->feedback = (float) str_replace('%', '', $item->feedback ?? 0);
            return $item;
        });

        // ✅ GROUP BY PROGRAM
        $grouped = $records->groupBy('program');

        $collection = collect();

        foreach ($grouped as $program => $items) {

            $collection->push((object) [
                'program' => $program,
                'career_code' => $items->first()->career_code ?? 'UG',
                'registered_students' => $items->sum('registered_students'),
                'attempts' => $items->sum('attempts'),
                'feedback' => round($items->avg('feedback'), 2),
            ]);
        }

        // ✅ DEPARTMENT AVG (AVG OF PROGRAMS)
        $departmentAvgScore = $collection->count()
            ? round($collection->avg('feedback'), 2)
            : 0;

        // ✅ KPI WEIGHT
        $weight = getRoleWeightage($activeRoleId, 'indicator', 182)['weightage'] ?? 0;
        $weightedScore = ($departmentAvgScore * $weight) / 100;

        // ✅ SAVE KPI
        saveIndicatorPercentage90Plus(
            auth()->user()->employee_id,
            $activeRoleId,
            1,
            23,
            182,
            $weightedScore
        );

        return [
            'collection' => $collection,
            'totalFeedback' => $departmentAvgScore
        ];
    }
}

if (!function_exists('departmentScopusPublicationsOfHOD')) {
    function departmentScopusPublicationsOfHOD($activeRoleId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 5)
    {
        $user = auth()->user();
        $departmentId = $user->department_id;

        // Get all faculty IDs in the department
        $facultyIds = User::where('department_id', $departmentId)
            ->whereNotNull('faculty_id')
            ->pluck('id');

        $totalFaculty = $facultyIds->count();

        if ($totalFaculty === 0) {
            return [
                'total_user' => 0,
                'total_submit' => 0,
                'department_avg_percentage' => 0,
                'weighted_score' => 0
            ];
        }

        // Get all HOD target user IDs for these faculty
        $facultyTargetUserIds = FacultyTarget::whereIn('user_id', $facultyIds)
            ->where('form_status', 'HOD')
            ->where('indicator_id', $indicatorId)
            ->pluck('user_id');

        // Count distinct faculty who submitted Scopus publications
        $totalSubmitted = AchievementOfResearchPublicationsTarget::where('indicator_id', $indicatorId)
            ->where('form_status', 'RESEARCHER')
            ->whereNotNull('journal_clasification')
            ->whereIn('created_by', $facultyTargetUserIds)
            ->distinct('created_by')
            ->count('created_by');

        // Calculate department-level percentage
        $departmentAvgPercentage = round(($totalSubmitted / $totalFaculty) * 100, 2);

        // Calculate weighted score
        $weight = getRoleWeightage($activeRoleId, 'indicator', 126)['weightage'] ?? 0;
        $weightedScore = ($departmentAvgPercentage * $weight) / 100;

        // Save KPI
        saveIndicatorPercentage(
            $user->employee_id,
            $activeRoleId,
            $keyPerformanceAreaId,
            $indicatorCategoryId,
            126,
            $weightedScore,
            $departmentAvgPercentage
        );

        return [
            'total_user' => $totalFaculty,
            'total_submit' => $totalSubmitted,
            'department_avg_percentage' => $departmentAvgPercentage,
            'weighted_score' => $weightedScore
        ];
    }
}

if (!function_exists('departmentScopusAnalysisOfHOD')) {
    function departmentScopusAnalysisOfHOD($activeRoleId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 5)
    {
        $departmentId = auth()->user()->department_id;

        // Get all faculty IDs in the department
        $facultyIds = User::where('department_id', $departmentId)
            ->whereNotNull('faculty_id')
            ->pluck('id');

        if ($facultyIds->isEmpty()) {
            return [
                'total_target' => 0,
                'total_submit' => 0,
                'total_international' => 0,
                'faculty_submitted_total' => 0,
                'department_avg_percentage' => 0,
                'department_international_fraction' => 0,
                'department_quartile_score' => 0,
                'department_research_percentage' => 0,
                'q1_count' => 0,
                'q2_count' => 0,
                'q3_count' => 0,
                'q4_count' => 0,
            ];
        }

        $totalTarget = 0;
        $totalSubmitted = 0;
        $totalInternational = 0;
        $totalQuartileScore = 0;
        $totalResearchSubmitted = 0; // For overall research publications
        $totalResearchTarget = 0; // For overall research publications
        $facultyCount = 0;
        $oversubmissionCount = 0;
        $q1_count1 = 0;
        $q2_count1 = 0;
        $q3_count1 = 0;
        $q4_count1 = 0;



        foreach ($facultyIds as $facultyId) {

            // Get HOD targets for this faculty
            $facultyTargets = FacultyTarget::where('user_id', $facultyId)
                ->where('form_status', 'HOD')
                ->where('indicator_id', $indicatorId)
                ->get();

            $facultyTargetTotal = 0;
            $facultySubmittedTotal = 0;
            $facultyInternationalCount = 0;
            $facultyQuartileScore = 0;
            $facultyResearchSubmitted = 0;
            $facultyResearchTarget = 0;
            $totalsubmissionCount = 0;
            // Quartile counts
            $q1Count = 0;
            $q2Count = 0;
            $q3Count = 0;
            $q4Count = 0;

            foreach ($facultyTargets as $target) {
                $facultyTargetTotal += $target->target ?? 0;
                $facultyResearchTarget += $target->target ?? 0;

                // Publications submitted by faculty (main)
                $facultyRecords = AchievementOfResearchPublicationsTarget::where('created_by', $facultyId)
                    ->where('indicator_id', $indicatorId)
                    ->where('form_status', 'RESEARCHER')
                    ->get();

                // Count co-author publications
                $coAuthorCount = AchievementOfResearchPublicationTargetCoAuthor::whereIn('target_id', $facultyRecords->pluck('id'))->count();

                $submissionCount = $facultyRecords->count() + $coAuthorCount;
                $totalsubmissionCount += $facultyRecords->count();
                $facultySubmittedTotal += $submissionCount;
                $facultyResearchSubmitted += $submissionCount; // also for overall research

                // International papers
                $facultyInternationalCount += $facultyRecords->filter(fn($r) => strtolower(trim($r->nationality)) === 'international')->count();

                // Journal Quartile scoring
                $quartilePoints = ['Q1' => 20, 'Q2' => 15, 'Q3' => 10, 'Q4' => 5];
                foreach ($facultyRecords as $record) {
                    $quartile = strtoupper(trim($record->journal_clasification));
                    if (isset($quartilePoints[$quartile])) {
                        $facultyQuartileScore += $quartilePoints[$quartile];
                    }
                    if ($quartile === 'Q1')
                        $q1Count++;
                    elseif ($quartile === 'Q2')
                        $q2Count++;
                    elseif ($quartile === 'Q3')
                        $q3Count++;
                    elseif ($quartile === 'Q4')
                        $q4Count++;
                }
            }

            $totalTarget += $facultyTargetTotal;
            $totalSubmitted += $facultySubmittedTotal;
            $totalInternational += $facultyInternationalCount;
            $totalQuartileScore += $facultyQuartileScore;

            $totalResearchTarget += $facultyResearchTarget;
            $totalResearchSubmitted += $facultyResearchSubmitted;
            $oversubmissionCount += $totalsubmissionCount;
            // ✅ Quartile counts
            $q1_count1 += $q1Count;
            $q2_count1 += $q2Count;
            $q3_count1 += $q3Count;
            $q4_count1 += $q4Count;

            $facultyCount++;
        }

        // Department-level Scopus percentage
        $departmentAvgPercentage = $totalTarget > 0
            ? round(($totalSubmitted / $totalTarget) * 100, 2)
            : 0;

        // Department international fraction
        $departmentInternationalFraction = $totalResearchTarget > 0
            ? round(($totalInternational / $totalResearchTarget) * 100, 2)
            : 0;

        // Department overall research publications percentage
        $departmentResearchPercentage = $totalResearchTarget > 0
            ? round(($totalResearchSubmitted / $totalResearchTarget) * 100, 2)
            : 0;

        // Department overall research publications percentage
        $overdepartmentResearchPercentage = $totalResearchTarget > 0
            ? round(($oversubmissionCount / $totalResearchTarget) * 100, 2)
            : 0;
        //dd($totalsubmissionCount);
        $hodEmployeeId = auth()->user()->employee_id;

        $weights = [
            'weight127' => getRoleWeightage($activeRoleId, 'indicator', 127)['weightage'],
            'weight128' => getRoleWeightage($activeRoleId, 'indicator', 128)['weightage'],
            'weight203' => getRoleWeightage($activeRoleId, 'indicator', 203)['weightage'],
        ];
        $weightedScore127 = ($departmentInternationalFraction * $weights['weight127']) / 100;
        $weightedScore128 = ($overdepartmentResearchPercentage * $weights['weight128']) / 100;
        $weightedScore203 = ($totalQuartileScore * $weights['weight203']) / 100;

        saveIndicatorPercentage($hodEmployeeId, $activeRoleId, $keyPerformanceAreaId, $indicatorCategoryId, 127, $weightedScore127, $departmentInternationalFraction); // International
        saveIndicatorPercentage($hodEmployeeId, $activeRoleId, $keyPerformanceAreaId, $indicatorCategoryId, 203, $weightedScore203, $totalQuartileScore); // Quartile
        saveIndicatorPercentage($hodEmployeeId, $activeRoleId, $keyPerformanceAreaId, $indicatorCategoryId, 128, $weightedScore128, $overdepartmentResearchPercentage); // Overall Research % (dummy indicator_id 999, change as needed)
        $data = [
            'total_target' => $totalTarget,
            'total_submit' => $oversubmissionCount,
            'total_international' => $totalInternational,
            'faculty_submitted_total' => $totalSubmitted,
            'department_avg_percentage' => $overdepartmentResearchPercentage,
            'department_international_fraction' => $departmentInternationalFraction,
            'department_quartile_score' => $totalQuartileScore,
            'department_research_percentage' => $departmentResearchPercentage,
            // ✅ Quartile counts
            'q1_count' => $q1_count1,
            'q2_count' => $q2_count1,
            'q3_count' => $q3_count1,
            'q4_count' => $q4_count1,
        ];
        //dd($data);
        return [
            'total_target' => $totalTarget,
            'total_submit' => $oversubmissionCount,
            'total_international' => $totalInternational,
            'faculty_submitted_total' => $totalSubmitted,
            'department_avg_percentage' => $overdepartmentResearchPercentage,
            'department_international_fraction' => $departmentInternationalFraction,
            'department_quartile_score' => $totalQuartileScore,
            'department_research_percentage' => $departmentResearchPercentage,
            'q1_count' => $q1_count1,
            'q2_count' => $q2_count1,
            'q3_count' => $q3_count1,
            'q4_count' => $q4_count1,
        ];
    }
}

// if (!function_exists('departmentTargetIndicatorsAnalysisOfHOD')) {
//     function departmentTargetIndicatorsAnalysisOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId)
//     {
//         $departmentId = auth()->user()->department_id;

//         // Get faculty user IDs and employee IDs
//         $faculty = User::where('department_id', $departmentId)
//             ->whereNotNull('faculty_id')
//             ->get(['id', 'employee_id']);

//         $userIds = $faculty->pluck('id');
//         $employeeIds = $faculty->pluck('employee_id');

//         // Define indicators and models
//         $indicators = [
//             ['id' => 135, 'model' => \App\Models\NoOfGrantsSubmitAndWon::class, 'filter' => ['grant_status' => 'Submitted']],
//             ['id' => 202, 'model' => \App\Models\NoOfGrantsSubmitAndWon::class, 'filter' => ['grant_status' => 'Won']],
//             ['id' => 136, 'model' => \App\Models\NoAchievementOfMultidisciplinaryProjectsTarget::class],
//             ['id' => 197, 'model' => \App\Models\IndustrialVisit::class],
//             ['id' => 198, 'model' => \App\Models\IndustrialProjects::class],
//             ['id' => 139, 'model' => \App\Models\SpinOff::class],
//             ['id' => 199, 'model' => \App\Models\ProductsDeliveredToIndustry::class],
//             ['id' => 137, 'model' => \App\Models\CommercialGainsCounsultancyResearchIncome::class],
//             ['id' => 138, 'model' => \App\Models\IntellectualProperty::class],
//             ['id' => 194, 'model' => \App\Models\NumberOfKnowledgeProduct::class],
//             ['id' => 154, 'model' => \App\Models\ProgramAccreditation::class],
//             ['id' => 155, 'model' => \App\Models\ProfessionalMembership::class],
//         ];

//         $results = [];

//         foreach ($indicators as $indicator) {
//             $indicatorId = $indicator['id'];
//             $modelClass = $indicator['model'];
//             $filter = $indicator['filter'] ?? [];

//             // ✅ Faculty targets (user_id)
//             $totalTarget = FacultyTarget::whereIn('user_id', $userIds)
//                 ->where('indicator_id', $indicatorId)
//                 ->sum('target');

//             // ✅ Submissions (employee_id)
//             $totalSubmitted = $modelClass::whereIn('created_by', $employeeIds)
//                 ->where('indicator_id', $indicatorId)
//                 ->when(!empty($filter), function ($q) use ($filter) {
//                     foreach ($filter as $key => $value) {
//                         $q->where($key, $value);
//                     }
//                 })
//                 ->count();

//             // Department-level percentage
//             $departmentAvgPercentage = $totalTarget > 0
//                 ? round(($totalSubmitted / $totalTarget) * 100, 2)
//                 : 0;

//             $weightedScore = ($departmentAvgPercentage * 20) / 100;

//             // Save department KPI
//             saveIndicatorPercentage(
//                 $employeeId,
//                 $activeRoleId,
//                 $KpaId,
//                 $categoryId,
//                 $indicatorId,
//                 $weightedScore
//             );

//             $results[$indicatorId] = [
//                 'department_avg_percentage' => $departmentAvgPercentage,
//                 'weighted_score' => $weightedScore,
//                 'total_target' => $totalTarget,
//                 'total_submitted' => $totalSubmitted
//             ];
//         }

//         return $results;
//     }
// }

if (!function_exists('departmentTargetIndicatorsAnalysisOfHOD')) {

    function departmentTargetIndicatorsAnalysisOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // This function is called many times per request for different indicators.
        // Memoize department faculty list to avoid running the same query repeatedly.
        static $deptFacultyMemo = [];
        if (array_key_exists($departmentId, $deptFacultyMemo)) {
            $userIds = $deptFacultyMemo[$departmentId]['userIds'];
            $employeeIds = $deptFacultyMemo[$departmentId]['employeeIds'];
        } else {
            $faculty = User::where('department_id', $departmentId)
                ->whereNotNull('faculty_id')
                ->get(['id', 'employee_id']);

            $userIds = $faculty->pluck('id');
            $employeeIds = $faculty->pluck('employee_id');

            $deptFacultyMemo[$departmentId] = [
                'userIds' => $userIds,
                'employeeIds' => $employeeIds,
            ];
        }

        // Indicator configuration
        $indicators = [

            135 => [
                'model' => \App\Models\NoOfGrantsSubmitAndWon::class,
                'filter' => ['grant_status' => 'Submitted']
            ],

            202 => [
                'model' => \App\Models\NoOfGrantsSubmitAndWon::class,
                'filter' => ['grant_status' => 'Won']
            ],

            136 => [
                'model' => \App\Models\NoAchievementOfMultidisciplinaryProjectsTarget::class
            ],

            197 => [
                'model' => \App\Models\IndustrialVisit::class
            ],

            198 => [
                'model' => \App\Models\IndustrialProjects::class
            ],

            139 => [
                'model' => \App\Models\SpinOff::class
            ],

            199 => [
                'model' => \App\Models\ProductsDeliveredToIndustry::class
            ],

            137 => [
                'model' => \App\Models\CommercialGainsCounsultancyResearchIncome::class
            ],

            138 => [
                'model' => \App\Models\IntellectualProperty::class
            ],

            194 => [
                'model' => \App\Models\NumberOfKnowledgeProduct::class
            ],

            154 => [
                'model' => \App\Models\ProgramAccreditation::class
            ],

            155 => [
                'model' => \App\Models\ProfessionalMembership::class
            ],

        ];

        if (!isset($indicators[$indicatorId])) {
            return null;
        }

        $modelClass = $indicators[$indicatorId]['model'];
        $filter = $indicators[$indicatorId]['filter'] ?? [];

        // Faculty targets
        $totalTarget = FacultyTarget::whereIn('user_id', $userIds)
            ->where('indicator_id', $indicatorId)
            ->sum('target');

        // Submissions
        $totalSubmitted = $modelClass::whereIn('created_by', $employeeIds)
            ->where('indicator_id', $indicatorId)
            ->when(!empty($filter), function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, $value);
                }
            })
            ->count();

        $departmentAvgPercentage = $totalTarget > 0
            ? round(($totalSubmitted / $totalTarget) * 100, 2)
            : 0;

        $weightedScore = ($departmentAvgPercentage * 20) / 100;

        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $departmentAvgPercentage
        );

        return [
            'department_avg_percentage' => $departmentAvgPercentage,
            'weighted_score' => $weightedScore,
            'total_target' => $totalTarget,
            'total_submitted' => $totalSubmitted
        ];
    }
}

if (!function_exists('ProgramAccreditationOfHOD')) {

    function ProgramAccreditationOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Model
        $modelClass = \App\Models\ProgramAccreditation::class;

        // 2️⃣ Records (modal data)
        $records = $modelClass::with(['faculty', 'department', 'program'])
            ->where('indicator_id', $indicatorId)
            ->where('department_id', $departmentId)
            ->where('created_by', $employeeId)
            ->where('status', 2)
            ->get();

        // 3️⃣ TOTAL TARGET (calculate once)
        $totalTarget = FacultyTarget::where('user_id', $employeeId)
            ->where('indicator_id', $indicatorId)
            ->sum('target');

        // 4️⃣ ACHIEVED
        $totalAchieved = $records->count();

        // 5️⃣ AVG
        $avgRating = $totalTarget > 0
            ? round(($totalAchieved / $totalTarget) * 100, 2)
            : 0;

        // 6️⃣ RATING
        $meta = getRatingMeta($avgRating);

        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        $weightedScore = ($avgRating * $weight) / 100;

        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $avgRating
        );

        // 7️⃣ GROUP BY PROGRAM
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $achieved = $items->count();

            // same target for all programs (no program_id in DB)
            $programTarget = $totalTarget;

            $programAvg = $programTarget > 0
                ? round(($achieved / $programTarget) * 100, 2)
                : 0;

            $metaP = getRatingMeta($programAvg);

            $rows[] = (object) [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => $items->first()->program_level,

                'target' => $programTarget,
                'achieved' => $achieved,

                'score' => $programAvg,
                'rating' => $metaP->rating,
                'color' => $metaP->color,
            ];
        }

        // 8️⃣ RETURN
        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'average_rating' => $avgRating,
                'weighted_score' => round($weightedScore, 2),
                'color' => $meta->color,
                'rating' => $meta->rating
            ]
        ];
    }
}

if (!function_exists('noOfProfessionalMembershipsOfHOD')) {

    function noOfProfessionalMembershipsOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Model
        $modelClass = \App\Models\ProfessionalMembership::class;

        // 2️⃣ Records (modal data)
        $records = $modelClass::where('indicator_id', $indicatorId)
            ->where('created_by', $employeeId)
            ->where('status', 2)
            ->get();

        // 3️⃣ TOTAL TARGET (calculate once)
        $totalTarget = FacultyTarget::where('user_id', $employeeId)
            ->where('indicator_id', $indicatorId)
            ->sum('target');

        // 4️⃣ ACHIEVED
        $totalAchieved = $records->count();

        // 5️⃣ AVG
        $avgRating = $totalTarget > 0
            ? round(($totalAchieved / $totalTarget) * 100, 2)
            : 0;

        // 6️⃣ RATING
        $meta = getRatingMeta($avgRating);

        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        $weightedScore = ($avgRating * $weight) / 100;

        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $avgRating
        );

        // 8️⃣ RETURN
        return [
            'average_rating' => round($avgRating, 2),
            'weighted_score' => round($weightedScore, 2),
            'total_target' => $totalTarget,
            'total_submitted' => $totalAchieved,
            'color' => $meta->color,
            'rating' => $meta->rating
        ];
    }
}

if (!function_exists('departmentLineManagerReviewRating')) {
    function departmentLineManagerReviewRating($facultyId, $activeRoleId)
    {
        $departmentId = auth()->user()->department_id;

        // Get all faculty members in this department
        $facultyMembers = User::where('department_id', $departmentId)
            ->get(['id', 'employee_id', 'name']);

        $totalScore = 0;
        $totalTasks = 0;

        $allRatings = [];

        foreach ($facultyMembers as $faculty) {

            $reviews = LineManagerReviewRating::with('tasks')
                ->where('employee_id', $faculty->id)
                ->get();

            foreach ($reviews as $review) {
                foreach ($review->tasks as $task) {

                    $score = $task->linemanager_rating * 20; // convert 0-5 scale to %
                    $totalScore += $score;
                    $totalTasks++;
                    $allRatings[] = (object) [
                        'faculty_name' => $faculty->name,
                        'task' => $task->task,
                        'rating_data' => [
                            'percentage' => $score
                        ]
                    ];
                }
            }
        }

        // Department average
        $departmentAvgScore = $totalTasks > 0 ? round($totalScore / $totalTasks, 2) : 0;

        // Get indicator weights
        $weights = [
            'course_load' => getRoleWeightage($activeRoleId, 'indicator', 175)['weightage'] ?? 0,
            'course_188' => getRoleWeightage($activeRoleId, 'indicator', 188)['weightage'] ?? 0,
        ];

        // Weighted department scores
        $weightedScore175 = ($departmentAvgScore * $weights['course_load']) / 100;
        $weightedScore188 = ($departmentAvgScore * $weights['course_188']) / 100;
        // Save department-level KPI
        saveIndicatorPercentage($facultyId, $activeRoleId, 2, 34, 175, $weightedScore175, $departmentAvgScore);
        saveIndicatorPercentage($facultyId, $activeRoleId, 13, 27, 188, $weightedScore188, $departmentAvgScore);

        return [
            'total_task' => $totalTasks,
            'total_Score' => $totalScore,
            'department_avg_score' => $departmentAvgScore,
            'weighted_scores' => [
                175 => $weightedScore175,
                188 => $weightedScore188,
            ],
            'all_faculty_ratings' => $allRatings
        ];
    }
}

if (!function_exists('scholarsSatisfactionAverageOfHOD')) {
    function scholarsSatisfactionAverageOfHOD($activeRoleId)
    {
        $departmentId = auth()->user()->department_id;

        $records = ScholarsSatisfactionInThesisStage::where('department_id', $departmentId)
            ->where('indicator_id', 132)
            ->get();

        $totalScore = 0;
        $count = 0;

        foreach ($records as $record) {
            $totalScore += $record->satisfaction_score;
            $count++;
        }

        // Department Average
        $departmentAverage = $count > 0 ? round($totalScore / $count, 2) : 0;

        // Indicator weight
        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 132);
        $weight = $indicatorWeight['weightage'] ?? 0;

        // Weighted score
        $weightedScore = ($departmentAverage * $weight) / 100;

        // Save KPI
        saveIndicatorPercentage(
            auth()->user()->employee_id,
            $activeRoleId,
            2,
            6,
            132,
            $weightedScore
        );

        return [
            'department_average' => $departmentAverage,
            'weighted_score' => $weightedScore,
            'records_count' => $count
        ];
    }
}

if (!function_exists('researchProductivityPGStudentsOfHOD')) {
    function researchProductivityPGStudentsOfHOD($activeRoleId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 6)
    {
        $departmentId = auth()->user()->department_id;

        // Get all faculty IDs in the department
        $facultyIds = User::where('department_id', $departmentId)
            ->whereNotNull('faculty_id')
            ->pluck('id');

        if ($facultyIds->isEmpty()) {
            return [
                'department_avg_percentage' => 0,
                'weighted_score' => 0,
                'department_international_fraction' => 0,
                'department_quartile_score' => 0,
                'department_research_percentage' => 0,
            ];
        }

        $totalTarget = 0;
        $totalSubmitted = 0;
        $totalInternational = 0;
        $totalQuartileScore = 0;
        $totalResearchSubmitted = 0; // For overall research publications
        $totalResearchTarget = 0; // For overall research publications
        $facultyCount = 0;

        foreach ($facultyIds as $facultyId) {

            // Get HOD targets for this faculty
            $facultyTargets = FacultyTarget::where('user_id', $facultyId)
                ->where('form_status', 'HOD')
                ->where('indicator_id', $indicatorId)
                ->get();

            $facultyTargetTotal = 0;
            $facultySubmittedTotal = 0;
            $facultyInternationalCount = 0;
            $facultyQuartileScore = 0;
            $facultyResearchSubmitted = 0;
            $facultyResearchTarget = 0;

            foreach ($facultyTargets as $target) {
                $facultyTargetTotal += $target->target ?? 0;
                $facultyResearchTarget += $target->target ?? 0;

                // Publications submitted by faculty (main)
                $facultyRecords = ResearchProductivityOfPgStudentTarget::where('created_by', $facultyId)
                    ->where('indicator_id', $indicatorId)
                    ->where('form_status', 'RESEARCHER')
                    ->where('status', 3) // approved
                    ->get();

                // Count co-author publications
                $coAuthorCount = ResearchProductivityOfPgStudent::whereIn('target_id', $facultyRecords->pluck('id'))->count();

                $submissionCount = $facultyRecords->count() + $coAuthorCount;
                $facultySubmittedTotal += $submissionCount;
                $facultyResearchSubmitted += $submissionCount; // also for overall research

                // International papers
                $facultyInternationalCount += $facultyRecords->filter(fn($r) => strtolower(trim($r->nationality)) === 'international')->count();

                // Journal Quartile scoring
                $quartilePoints = ['Q1' => 20, 'Q2' => 15, 'Q3' => 10, 'Q4' => 5];
                foreach ($facultyRecords as $record) {
                    if (isset($quartilePoints[$record->journal_clasification])) {
                        $facultyQuartileScore += $quartilePoints[$record->journal_clasification];
                    }
                }
            }

            $totalTarget += $facultyTargetTotal;
            $totalSubmitted += $facultySubmittedTotal;
            $totalInternational += $facultyInternationalCount;
            $totalQuartileScore += $facultyQuartileScore;

            $totalResearchTarget += $facultyResearchTarget;
            $totalResearchSubmitted += $facultyResearchSubmitted;

            $facultyCount++;
        }

        // Department-level Scopus percentage
        $departmentAvgPercentage = $totalTarget > 0
            ? round(($totalSubmitted / $totalTarget) * 100, 2)
            : 0;

        // Department international fraction
        $departmentInternationalFraction = $totalSubmitted > 0
            ? round(($totalInternational / $totalSubmitted) * 100, 2)
            : 0;

        // Department overall research publications percentage
        $departmentResearchPercentage = $totalResearchTarget > 0
            ? round(($totalResearchSubmitted / $totalResearchTarget) * 100, 2)
            : 0;

        $hodEmployeeId = auth()->user()->employee_id;

        $weights = [
            'weight133' => getRoleWeightage($activeRoleId, 'indicator', 133)['weightage'],
        ];
        $weightedScore133 = ($departmentAvgPercentage * $weights['weight133']) / 100;
        saveIndicatorPercentage($hodEmployeeId, $activeRoleId, $keyPerformanceAreaId, $indicatorCategoryId, 133, $weightedScore133);

        return [
            'department_avg_percentage' => $departmentAvgPercentage,
            'department_international_fraction' => $departmentInternationalFraction,
            'department_quartile_score' => $totalQuartileScore,
            'department_research_percentage' => $departmentResearchPercentage,
        ];

    }
}

if (!function_exists('admissionTargetDepartmentAverage')) {
    function admissionTargetDepartmentAverage($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        $recordsRaw = AdmissionTargetAchieved::with(['faculty', 'department', 'program'])
            ->select(
                'program_id',
                \DB::raw('SUM(admissions_target) as total_target'),
                \DB::raw('SUM(achieved_target) as total_achieved')
            )
            ->where('department_id', $departmentId)
            ->groupBy('program_id')
            ->get();

        $records = [];
        foreach ($recordsRaw as $record) {
            $totalTarget = $record->total_target ?? 0;
            $totalAchieved = $record->total_achieved ?? 0;
            $programPercentage = $totalTarget > 0 ? ($totalAchieved / $totalTarget) * 100 : 0;

            $records[] = [
                'program_name' => $record->program->program_name ?? 'N/A',
                'total_target' => $totalTarget,
                'total_achieved' => $totalAchieved,
                'percentage' => round($programPercentage, 1)
            ];
        }
        $totalTarget = $recordsRaw->sum('total_target');
        $totalAchieved = $recordsRaw->sum('total_achieved');
        $avgFacultyPercentage = $totalTarget > 0 ? ($totalAchieved / $totalTarget) * 100 : 0;
        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 143);
        $weight = $indicatorWeight['weightage'] ?? 0;

        // Weighted score
        $weightedScore = ($avgFacultyPercentage * $weight) / 100;


        saveIndicatorPercentage100Plus(
            $employeeId,
            $activeRoleId,
            3, // Key performance area
            10, // Indicator category
            $indicatorId,
            $weightedScore,
            $avgFacultyPercentage
        );
        // Return data
        return [
            'records' => $records,                  // per program records
            'total_target' => $totalTarget,         // sum of all targets
            'total_achieved' => $totalAchieved,     // sum of all achieved
            'avg_percentage' => round($avgFacultyPercentage, 2), // overall %
            'weighted_score' => round($weightedScore, 2),        // weighted score
        ];


    }
}

if (!function_exists('recoveryTargetDepartmentAveraget')) {
    function recoveryTargetDepartmentAveraget($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get all faculty members in this department who have HOD records for this indicator
        static $facultyMembersMemo = [];
        if (array_key_exists($departmentId, $facultyMembersMemo)) {
            $facultyMembers = $facultyMembersMemo[$departmentId];
        } else {
            $facultyMembers = User::where('department_id', $departmentId)
                ->get(['faculty_id', 'name']);
            $facultyMembersMemo[$departmentId] = $facultyMembers;
        }

        $allData = [];
        $allPercentages = [];

        foreach ($facultyMembers as $faculty) {
            // 2️⃣ Get all targets for this faculty
            $facultyTargets = \DB::table('recoveries')
                ->where('department_id', $departmentId)
                ->where('indicator_id', $indicatorId)
                ->where('form_status', 'HOD')
                ->get();

            $facultyPercentages = [];

            foreach ($facultyTargets as $target) {
                $achieved = $target->achieved_target;
                $admissionsTarget = $target->recovery_target;

                $percentage = ($admissionsTarget > 0) ? round(($achieved / $admissionsTarget) * 100, 2) : 0;
                $facultyPercentages[] = $percentage;
                $allPercentages[] = $percentage;

                // Determine rating
                if ($percentage >= 90) {
                    $rating = 'OS';
                } elseif ($percentage >= 80) {
                    $rating = 'EE';
                } elseif ($percentage >= 70) {
                    $rating = 'ME';
                } elseif ($percentage >= 60) {
                    $rating = 'NI';
                } else {
                    $rating = 'BE';
                }

                $allData[] = [
                    'faculty_id' => $target->faculty_id,
                    'program_id' => $target->program_id,
                    'admissions_campaign' => $target->target_month_year,
                    'admissions_target' => $admissionsTarget,
                    'achieved_target' => $achieved,
                    'percentage' => $percentage,
                    'rating' => $rating,
                ];
            }

            // Save individual faculty weighted score
            $avgFacultyPercentage = count($facultyPercentages)
                ? round(array_sum($facultyPercentages) / count($facultyPercentages), 2)
                : 0;
            $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
            $weightedScore = ($avgFacultyPercentage * $weight) / 100;

            saveIndicatorPercentage90Plus(
                $employeeId,
                $activeRoleId,
                3, // Key performance area
                11, // Indicator category
                $indicatorId,
                $weightedScore,
                $avgFacultyPercentage
            );
        }

        // 3️⃣ Department-level average
        $departmentAverage = count($allPercentages)
            ? round(array_sum($allPercentages) / count($allPercentages), 2)
            : 0;

        return [
            'data' => $allData,
            'department_average' => $departmentAverage,
        ];
    }
}

if (!function_exists('programProfitabilityDepartmentAverage')) {
    function programProfitabilityDepartmentAverage($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get all faculty in this department for this indicator
        $facultyMembers = User::where('department_id', $departmentId)
            ->get(['employee_id', 'faculty_id', 'name']);

        $allData = [];
        $allPercentages = [];

        foreach ($facultyMembers as $faculty) {

            // 2️⃣ Get profitability records for this faculty
            $records = ProgramProfitability::where('department_id', $departmentId)
                ->where('indicator_id', $indicatorId)
                ->where('form_status', 'HOD')
                ->get();

            $facultyPercentages = [];

            foreach ($records as $record) {

                $profitability = (float) $record->profitability;

                $facultyPercentages[] = $profitability;
                $allPercentages[] = $profitability;

                // Rating logic
                if ($profitability >= 90) {
                    $rating = 'OS';
                } elseif ($profitability >= 80) {
                    $rating = 'EE';
                } elseif ($profitability >= 70) {
                    $rating = 'ME';
                } elseif ($profitability >= 60) {
                    $rating = 'NI';
                } else {
                    $rating = 'BE';
                }

                $allData[] = [
                    'faculty_id' => $record->faculty_id,
                    'program_id' => $record->program_id,
                    'program_level' => $record->program_level,
                    'profitability' => $profitability,
                    'rating' => $rating,
                ];
            }

            // 3️⃣ Faculty average
            $avgFacultyPercentage = count($facultyPercentages)
                ? round(array_sum($facultyPercentages) / count($facultyPercentages), 2)
                : 0;
            $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
            $weightedScore = ($avgFacultyPercentage * $weight) / 100;

            saveIndicatorPercentage90Plus(
                $employeeId,
                $activeRoleId,
                3, // Key performance area
                11, // Indicator category
                $indicatorId,
                $weightedScore,
                $avgFacultyPercentage
            );
        }

        // 4️⃣ Department-level average
        $departmentAverage = count($allPercentages)
            ? round(array_sum($allPercentages) / count($allPercentages), 2)
            : 0;

        return [
            'data' => $allData,
            'department_average' => $departmentAverage,
        ];
    }
}

if (!function_exists('goGlobalStreamDepartmentAverage')) {
    function goGlobalStreamDepartmentAverage($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // Get faculty in this department
        $facultyMembers = User::where('department_id', $departmentId)
            ->get(['employee_id', 'faculty_id', 'name']);

        $allData = [];
        $allPercentages = [];

        foreach ($facultyMembers as $faculty) {

            $records = GoGlobalStreamTarget::where('department_id', $departmentId)
                ->where('indicator_id', $indicatorId)
                ->where('form_status', 'HOD')
                ->get();

            $facultyPercentages = [];

            foreach ($records as $record) {

                $target = $record->experience_target;
                $achieved = $record->achieved_target;

                $percentage = ($target > 0)
                    ? round(($achieved / $target) * 100, 2)
                    : 0;

                $facultyPercentages[] = $percentage;
                $allPercentages[] = $percentage;

                // Rating
                if ($percentage >= 90) {
                    $rating = 'OS';
                } elseif ($percentage >= 80) {
                    $rating = 'EE';
                } elseif ($percentage >= 70) {
                    $rating = 'ME';
                } elseif ($percentage >= 60) {
                    $rating = 'NI';
                } else {
                    $rating = 'BE';
                }

                $allData[] = [
                    'faculty_id' => $record->faculty_id,
                    'program_id' => $record->program_id,
                    'experience_target' => $target,
                    'achieved_target' => $achieved,
                    'percentage' => $percentage,
                    'rating' => $rating,
                ];
            }

            // Faculty average
            $avgFacultyPercentage = count($facultyPercentages)
                ? round(array_sum($facultyPercentages) / count($facultyPercentages), 2)
                : 0;

            $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

            $weightedScore = ($avgFacultyPercentage * $weight) / 100;

            saveIndicatorPercentage(
                $employeeId,
                $activeRoleId,
                4,
                12,
                $indicatorId,
                $weightedScore
            );
        }

        // Department average
        $departmentAverage = count($allPercentages)
            ? round(array_sum($allPercentages) / count($allPercentages), 2)
            : 0;

        return [
            'data' => $allData,
            'department_average' => $departmentAverage,
        ];
    }
}

if (!function_exists('goGlobalStreamDepartmentAverage')) {
    function goGlobalStreamDepartmentAverage($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // Get faculty in this department
        $facultyMembers = User::where('department_id', $departmentId)
            ->get(['employee_id', 'faculty_id', 'name']);

        $allData = [];
        $allPercentages = [];

        foreach ($facultyMembers as $faculty) {

            $records = GoGlobalStreamTarget::where('department_id', $departmentId)
                ->where('indicator_id', $indicatorId)
                ->where('form_status', 'HOD')
                ->get();

            $facultyPercentages = [];

            foreach ($records as $record) {

                $target = $record->experience_target;
                $achieved = $record->achieved_target;

                $percentage = ($target > 0)
                    ? round(($achieved / $target) * 100, 2)
                    : 0;

                $facultyPercentages[] = $percentage;
                $allPercentages[] = $percentage;

                // Rating
                if ($percentage >= 90) {
                    $rating = 'OS';
                } elseif ($percentage >= 80) {
                    $rating = 'EE';
                } elseif ($percentage >= 70) {
                    $rating = 'ME';
                } elseif ($percentage >= 60) {
                    $rating = 'NI';
                } else {
                    $rating = 'BE';
                }

                $allData[] = [
                    'faculty_id' => $record->faculty_id,
                    'program_id' => $record->program_id,
                    'experience_target' => $target,
                    'achieved_target' => $achieved,
                    'percentage' => $percentage,
                    'rating' => $rating,
                ];
            }

            // Faculty average
            $avgFacultyPercentage = count($facultyPercentages)
                ? round(array_sum($facultyPercentages) / count($facultyPercentages), 2)
                : 0;

            $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

            $weightedScore = ($avgFacultyPercentage * $weight) / 100;

            saveIndicatorPercentage(
                $employeeId,
                $activeRoleId,
                4,
                12,
                $indicatorId,
                $weightedScore
            );
        }

        // Department average
        $departmentAverage = count($allPercentages)
            ? round(array_sum($allPercentages) / count($allPercentages), 2)
            : 0;

        return [
            'data' => $allData,
            'department_average' => $departmentAverage,
        ];
    }
}

if (!function_exists('NoOfStudentsEnrolledIn1MWithGlobalExperienceOfHOD')) {
    function NoOfStudentsEnrolledIn1MWithGlobalExperienceOfHOD($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // Get faculty in this department
        $facultyMembers = User::where('department_id', $departmentId)
            ->get(['employee_id', 'faculty_id', 'name']);

        $allData = [];
        $allPercentages = [];

        foreach ($facultyMembers as $faculty) {

            $records = StudentsGlobalExperience::where('department_id', $departmentId)
                ->where('indicator_id', $indicatorId)
                ->where('form_status', 'HOD')
                ->get();

            $facultyPercentages = [];

            foreach ($records as $record) {

                $target = $record->experience_target;
                $achieved = $record->achieved_target;

                $percentage = ($target > 0)
                    ? round(($achieved / $target) * 100, 2)
                    : 0;

                $facultyPercentages[] = $percentage;
                $allPercentages[] = $percentage;

                // Rating
                if ($percentage >= 90) {
                    $rating = 'OS';
                } elseif ($percentage >= 80) {
                    $rating = 'EE';
                } elseif ($percentage >= 70) {
                    $rating = 'ME';
                } elseif ($percentage >= 60) {
                    $rating = 'NI';
                } else {
                    $rating = 'BE';
                }

                $allData[] = [
                    'faculty_id' => $record->faculty_id,
                    'program_id' => $record->program_id,
                    'experience_target' => $target,
                    'achieved_target' => $achieved,
                    'percentage' => $percentage,
                    'rating' => $rating,
                ];
            }

            // Faculty average
            $avgFacultyPercentage = count($facultyPercentages)
                ? round(array_sum($facultyPercentages) / count($facultyPercentages), 2)
                : 0;

            $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

            $weightedScore = ($avgFacultyPercentage * $weight) / 100;

            saveIndicatorPercentage(
                $employeeId,
                $activeRoleId,
                4,
                12,
                $indicatorId,
                $weightedScore
            );
        }

        // Department average
        $departmentAverage = count($allPercentages)
            ? round(array_sum($allPercentages) / count($allPercentages), 2)
            : 0;

        return [
            'data' => $allData,
            'department_average' => $departmentAverage,
        ];
    }
}

if (!function_exists('internationalStudentSatisfactionAverage')) {

    function internationalStudentSatisfactionAverage($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = Auth::user()->department_id;

        // 1️⃣ Get all records (needed for grouping + avg)
        $records = SatisfactionOfInternationalStudent::with([
            'faculty',
            'department',
            'program'
        ])
            ->where('indicator_id', $indicatorId)
            ->where('department_id', $departmentId)
            ->where('form_status', 'HOD')
            ->where('status', 2)
            ->get();

        // 2️⃣ Department-wise average (ALL ratings)
        $ratings = $records->pluck('student_rating')->map(fn($r) => (float) $r);

        $avgRating = $ratings->count()
            ? round($ratings->avg() * 20, 2)
            : 0;

        // 3️⃣ Rating Meta
        $meta = getRatingMeta($avgRating);
        $color = $meta->color;
        $rating = $meta->rating;

        // 4️⃣ Weightage
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        $weightedScore = ($avgRating * $weight) / 100;

        // 5️⃣ SAVE (department-wise only once)
        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            4,
            12,
            $indicatorId,
            $weightedScore,
            $avgRating
        );

        // 6️⃣ Group by PROGRAM for modal
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $programRatings = $items->pluck('student_rating')->map(fn($r) => (float) $r);

            $programAvg = $programRatings->count()
                ? round($programRatings->avg() * 20, 2)
                : 0;

            $programMeta = getRatingMeta($programAvg);

            $rows[] = [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => optional($items->first())->program_level,
                'score' => $programAvg,
                'rating' => $programMeta->rating,
                'color' => $programMeta->color,
            ];
        }

        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'average_rating' => $avgRating,
                'weighted_score' => round($weightedScore, 2),
                'color' => $color,
                'rating' => $rating
            ]
        ];
    }
}
if (!function_exists('internationalStudentSatisfactionAverage')) {

    function internationalStudentSatisfactionAverage($employeeId, $activeRoleId, $indicatorId)
    {
        $departmentId = Auth::user()->department_id;

        // 1️⃣ Get all records (needed for grouping + avg)
        $records = SatisfactionOfInternationalStudent::with([
            'faculty',
            'department',
            'program'
        ])
            ->where('indicator_id', $indicatorId)
            ->where('department_id', $departmentId)
            ->where('form_status', 'HOD')
            ->where('status', 2)
            ->get();

        // 2️⃣ Department-wise average (ALL ratings)
        $ratings = $records->pluck('student_rating')->map(fn($r) => (float) $r);

        $avgRating = $ratings->count()
            ? round($ratings->avg() * 20, 2)
            : 0;

        // 3️⃣ Rating Meta
        $meta = getRatingMeta($avgRating);
        $color = $meta->color;
        $rating = $meta->rating;

        // 4️⃣ Weightage
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        $weightedScore = ($avgRating * $weight) / 100;

        // 5️⃣ SAVE (department-wise only once)
        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            4,
            12,
            $indicatorId,
            $weightedScore,
            $avgRating
        );

        // 6️⃣ Group by PROGRAM for modal
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $programRatings = $items->pluck('student_rating')->map(fn($r) => (float) $r);

            $programAvg = $programRatings->count()
                ? round($programRatings->avg() * 20, 2)
                : 0;

            $programMeta = getRatingMeta($programAvg);

            $rows[] = [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => optional($items->first())->program_level,
                'score' => $programAvg,
                'rating' => $programMeta->rating,
                'color' => $programMeta->color,
            ];
        }

        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'average_rating' => $avgRating,
                'weighted_score' => round($weightedScore, 2),
                'color' => $color,
                'rating' => $rating
            ]
        ];
    }
}

if (!function_exists('departmentEmployerSatisfactionOfHOD')) {

    function departmentEmployerSatisfactionOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get ALL records
        $records = Employability::with(['faculty', 'department', 'program'])
            ->where('department_id', $departmentId)
            ->whereNotNull('employer_satisfaction')
            ->get();

        // 2️⃣ Department AVG (SAVE KPI)
        $departmentAvg = $records->count()
            ? round($records->avg('employer_satisfaction') * 20, 2)
            : 0;

        $meta = getRatingMeta($departmentAvg);

        // 3️⃣ Weight
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 20;
        $weightedScore = ($departmentAvg * $weight) / 100;

        // 4️⃣ SAVE
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $departmentAvg
        );

        // 5️⃣ GROUP BY PROGRAM (MODAL)
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $programAvg = $items->count()
                ? round($items->avg('employer_satisfaction') * 20, 2)
                : 0;

            $metaP = getRatingMeta($programAvg);

            $rows[] = [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => $items->first()->program_level,

                'score' => $programAvg,
                'rating' => $metaP->rating,
                'color' => $metaP->color,
            ];
        }

        // 6️⃣ RETURN
        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'average' => $departmentAvg,
                'weighted_score' => round($weightedScore, 2),
                'color' => $meta->color,
                'rating' => $meta->rating
            ]
        ];
    }
}

if (!function_exists('departmentDropoutRateOfHOD')) {

    function departmentDropoutRateOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get FULL records (needed for grouping)
        $records = \App\Models\DropoutRate::with(['faculty', 'department', 'program'])
            ->where('department_id', $departmentId)
            ->where('indicator_id', $indicatorId)
            ->whereNotNull('dropout_rate')
            ->get();

        // 2️⃣ Department average (SAVE KPI)
        $departmentAvg = $records->count()
            ? round($records->avg('dropout_rate'), 2)
            : 0;

        // 3️⃣ Rating meta
        $meta = getRatingMeta($departmentAvg);

        // 4️⃣ Weight
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 20;
        $weightedScore = ($departmentAvg * $weight) / 100;

        // 5️⃣ Save
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $departmentAvg
        );

        // 6️⃣ GROUP BY PROGRAM (MODAL DATA)
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $programAvg = $items->count()
                ? round($items->avg('dropout_rate'), 2)
                : 0;

            $metaP = getRatingMeta($programAvg);

            $rows[] = [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => $items->first()->program_level,

                'score' => $programAvg,
                'rating' => $metaP->rating,
                'color' => $metaP->color,
            ];
        }

        // 7️⃣ RETURN
        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'average' => $departmentAvg,
                'weighted_score' => round($weightedScore, 2),
                'color' => $meta->color,
                'rating' => $meta->rating
            ]
        ];
    }
}

if (!function_exists('departmentPromotersPercentageOfHOD')) {

    function departmentPromotersPercentageOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get FULL records (for grouping)
        $records = \App\Models\FacultyNetPromoterScore::with(['faculty', 'department', 'program'])
            ->where('department_id', $departmentId)
            ->where('indicator_id', $indicatorId)
            ->whereNotNull('promoters_percentage')
            ->get();

        // 2️⃣ Department average (SAVE KPI)
        $departmentAvg = $records->count()
            ? round($records->avg('promoters_percentage'), 2)
            : 0;

        // 3️⃣ Rating meta
        $meta = getRatingMeta($departmentAvg);

        // 4️⃣ Weight
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 20;
        $weightedScore = ($departmentAvg * $weight) / 100;

        // 5️⃣ Save
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $departmentAvg
        );

        // 6️⃣ GROUP BY PROGRAM (MODAL)
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $programAvg = $items->count()
                ? round($items->avg('promoters_percentage'), 2)
                : 0;

            $metaP = getRatingMeta($programAvg);

            $rows[] = [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => $items->first()->program_level,

                'score' => $programAvg,
                'rating' => $metaP->rating,
                'color' => $metaP->color,
            ];
        }

        // 7️⃣ RETURN (STANDARD FORMAT)
        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'average' => $departmentAvg,
                'weighted_score' => round($weightedScore, 2),
                'color' => $meta->color,
                'rating' => $meta->rating
            ]
        ];
    }
}

if (!function_exists('departmentAlumniSatisfactionRateOfHOD')) {

    function departmentAlumniSatisfactionRateOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get full records (IMPORTANT for grouping)
        $records = \App\Models\AlumniSatisfactionRate::with(['faculty', 'department', 'program'])
            ->where('department_id', $departmentId)
            ->where('indicator_id', $indicatorId)
            ->whereNotNull('satisfaction_rate')
            ->get();

        // 2️⃣ Department Average (SAVE ONLY THIS)
        $departmentAvg = $records->count()
            ? round($records->avg('satisfaction_rate'), 2)
            : 0;

        // 3️⃣ Rating
        $meta = getRatingMeta($departmentAvg);

        // 4️⃣ Weight
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 20;
        $weightedScore = ($departmentAvg * $weight) / 100;

        // 5️⃣ Save KPI (ONLY departmentAvg indirectly via weightedScore)
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore
        );

        // 6️⃣ GROUP BY PROGRAM (FOR MODAL)
        $grouped = $records->groupBy('program_id');

        $rows = [];

        foreach ($grouped as $programId => $items) {

            $programAvg = $items->count()
                ? round($items->avg('satisfaction_rate'), 2)
                : 0;

            $metaP = getRatingMeta($programAvg);

            $rows[] = [
                'faculty' => optional($items->first()->faculty)->name,
                'department' => optional($items->first()->department)->name,
                'program' => optional($items->first()->program)->program_name,
                'program_level' => $items->first()->program_level ?? '-', // safe

                'score' => $programAvg,
                'rating' => $metaP->rating,
                'color' => $metaP->color,
            ];
        }

        // 7️⃣ RETURN
        return (object) [
            'rows' => $rows,

            'summary' => (object) [
                'average' => $departmentAvg,
                'weighted_score' => round($weightedScore, 2),
                'rating' => $meta->rating,
                'color' => $meta->color,
            ]
        ];
    }
}

if (!function_exists('departmentEventFeedbackAverage')) {
    /**
     * Calculate department-level average rating for Line Manager Event Feedback
     *
     * @param int $activeRoleId
     * @param int $KpaId
     * @param int $categoryId
     * @param int $indicatorId
     * @return array
     */
    function departmentEventFeedbackAverage($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get employee_ids of users in the same department
        $employeeIds = User::where('department_id', $departmentId)
            ->pluck('employee_id')
            ->filter() // remove nulls if any
            ->toArray();

        if (empty($employeeIds)) {
            return [
                'department_average' => 0,
                'weighted_score' => 0
            ];
        }

        // 2️⃣ Fetch all feedback records for those employees
        $feedbacks = LineManagerEventFeedback::whereIn('employee_id', $employeeIds)
            ->whereNotNull('rating')
            ->get('rating');

        // 3️⃣ Calculate department average
        $departmentAvg = $feedbacks->count()
            ? round($feedbacks->avg('rating'), 2)
            : 0;

        // 4️⃣ Weighted score (example weight 20% if not stored elsewhere)
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 20;
        $weightedScore = ($departmentAvg * $weight) / 100;

        // 5️⃣ Save or update to prevent duplicate insertion
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore
        );

        return [
            'department_average' => $departmentAvg,
            'weighted_score' => $weightedScore
        ];
    }
}

if (!function_exists('calculateLineManagerFeedbackAverage')) {
    /**
     * Calculate department-level feedback average for Line Manager Feedback
     *
     * @param \App\Models\User $authUser
     * @param int $indicatorId
     * @return array
     */
    function calculateLineManagerFeedbackAverage($authUser, $activeRoleId, $indicatorId)
    {
        // Determine which employees to include
        if ($indicatorId == 177) {
            // Dean's Feedback Score: upward (manager)
            $employeeIds = $authUser->manager ? [$authUser->manager->employee_id] : [];
        } elseif ($indicatorId == 178) {
            // PLs / Faculty Satisfaction Score: downward (subordinates)
            $employeeIds = $authUser->subordinates
                ? collect($authUser->subordinates)->pluck('employee_id')->filter()->toArray()
                : [];
        } else {
            // Default: include user himself/herself
            $employeeIds = [$authUser->employee_id];
        }

        if (empty($employeeIds)) {
            return [
                'department_average' => 0,
                'weighted_score' => 0
            ];
        }

        // Fetch all relevant feedback records
        $feedbacks = LineManagerFeedback::whereIn('created_by', $employeeIds)
            ->get([
                'responsibility_accountability_1',
                'responsibility_accountability_2',
                'empathy_compassion_1',
                'empathy_compassion_2',
                'humility_service_1',
                'humility_service_2',
                'honesty_integrity_1',
                'honesty_integrity_2',
                'inspirational_leadership_1',
                'inspirational_leadership_2'
            ]);

        if ($feedbacks->isEmpty()) {
            return [
                'department_average' => 0,
                'weighted_score' => 0
            ];
        }

        // Calculate average for each record
        $allAverages = $feedbacks->map(function ($record) {
            $scores = [
                $record->responsibility_accountability_1,
                $record->responsibility_accountability_2,
                $record->empathy_compassion_1,
                $record->empathy_compassion_2,
                $record->humility_service_1,
                $record->humility_service_2,
                $record->honesty_integrity_1,
                $record->honesty_integrity_2,
                $record->inspirational_leadership_1,
                $record->inspirational_leadership_2,
            ];

            // Remove nulls
            $scores = array_filter($scores, fn($val) => !is_null($val));

            return $scores ? array_sum($scores) / count($scores) : 0;
        });

        // Department-level average
        $departmentAvg = round($allAverages->avg(), 2);
        $weight165 = getRoleWeightage($activeRoleId, 'indicator', 165)['weightage'] ?? 0;
        $weight166 = getRoleWeightage($activeRoleId, 'indicator', 166)['weightage'] ?? 0;
        $weight180 = getRoleWeightage($activeRoleId, 'indicator', 180)['weightage'] ?? 0;
        $weightedScore165 = round(($departmentAvg * $weight165) / 100, 2);
        $weightedScore166 = round(($departmentAvg * $weight166) / 100, 2);
        $weightedScore180 = round(($departmentAvg * $weight180) / 100, 2);
        // Weighted score example (20% weight)
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        $weightedScore = round(($departmentAvg * $weight) / 100, 2);

        saveIndicatorPercentage(
            $authUser->employee_id,
            $activeRoleId,
            7,
            16,
            $indicatorId,
            $weightedScore
        );
        saveIndicatorPercentage($authUser->employee_id, $activeRoleId, 7, 16, 165, $weightedScore165);
        saveIndicatorPercentage($authUser->employee_id, $activeRoleId, 7, 16, 166, $weightedScore166);
        saveIndicatorPercentage($authUser->employee_id, $activeRoleId, 7, 16, 180, $weightedScore180);

        return [
            'department_average' => $departmentAvg,
            'weighted_score' => $weightedScore
        ];
    }
}

if (!function_exists('lineManagerReviewRatingOnTasks169')) {
    function lineManagerReviewRatingOnTasks169($employeeId, $activeRoleId)
    {
        $departmentId = auth()->user()->department_id;

        // 1️⃣ Get all employee_ids in the department
        $employeeIds = User::where('department_id', $departmentId)
            ->pluck('employee_id')
            ->filter() // remove nulls
            ->toArray();

        if (empty($employeeIds)) {
            return ['average_score' => 0, 'ratings' => []];
        }

        $managerRatings = [];
        $totalScore = 0;
        $taskCount = 0;

        // 2️⃣ Fetch all reviews for these employees
        $reviews = LineManagerReviewRating::with('tasks')
            ->whereIn('employee_id', $employeeIds)
            ->get();

        foreach ($reviews as $review) {
            foreach ($review->tasks as $task) {
                $score = $task->linemanager_rating * 20;
                $totalScore += $score;
                $taskCount++;

                if ($score >= 90) {
                    $label = 'OS';
                    $color = 'bg-primary';
                } elseif ($score >= 80) {
                    $label = 'EE';
                    $color = 'bg-success';
                } elseif ($score >= 70) {
                    $label = 'ME';
                    $color = 'bg-warning';
                } elseif ($score >= 60) {
                    $label = 'NI';
                    $color = 'bg-info';
                } else {
                    $label = 'BE';
                    $color = 'bg-danger';
                }

                $managerRatings[] = (object) [
                    'task' => $task->task,
                    'rating_data' => [
                        'percentage' => $score,
                        'label' => $label,
                        'color' => $color
                    ]
                ];
            }
        }

        // 3️⃣ Department-level average
        $averageScore = $taskCount > 0 ? round($totalScore / $taskCount, 2) : 0;

        // 4️⃣ Weighted score
        $weights = [
            'course_169' => getRoleWeightage($activeRoleId, 'indicator', 169)['weightage'] ?? 0,
        ];
        $weightedScore169 = ($averageScore * $weights['course_169']) / 100;

        if ($employeeId) {
            saveIndicatorPercentage(
                $employeeId,      // must be integer!
                $activeRoleId,
                7,                   // KPA ID
                17,                  // Category ID
                169,                 // Indicator ID
                $weightedScore169
            );
        }

        return ['average_score' => $averageScore, 'ratings' => $managerRatings];
    }
}

if (!function_exists('ActiveInternationalResearchPartnerOfHOD')) {

    function ActiveInternationalResearchPartnerOfHOD($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {
        // 1️⃣ Get ALL rows for modal
        $rows = ActiveInternationalResearchPartner::where('created_by', $employeeId)
            ->where('indicator_id', $indicatorId)
            ->where('status', 2)
            ->get();

        // 2️⃣ Calculate totals
        $totalTarget = $rows->sum('target');
        $totalAchieved = $rows->sum('achieved_target');

        // 3️⃣ Overall percentage
        $departmentAvg = ($totalTarget > 0)
            ? ($totalAchieved / $totalTarget) * 100
            : 0;

        $departmentAvg = round($departmentAvg, 2);

        // 4️⃣ Rating Logic (for overall)
        if ($departmentAvg >= 90) {
            $color = '#6EA8FE';
            $rating = 'OS';
        } elseif ($departmentAvg >= 80) {
            $color = '#96e2b4';
            $rating = 'EE';
        } elseif ($departmentAvg >= 70) {
            $color = '#ffcb9a';
            $rating = 'ME';
        } elseif ($departmentAvg >= 60) {
            $color = '#fd7e13';
            $rating = 'NI';
        } else {
            $color = '#ff4c51';
            $rating = 'BE';
        }

        // 5️⃣ Weight
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        // 6️⃣ Weighted Score
        $weightedScore = ($departmentAvg * $weight) / 100;

        // 7️⃣ Save overall only
        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $departmentAvg
        );

        // 8️⃣ Return BOTH rows + summary
        return (object) [
            'rows' => $rows,
            'summary' => (object) [
                'target' => $totalTarget,
                'achieved' => $totalAchieved,
                'percentage' => $departmentAvg,
                'weighted_score' => round($weightedScore, 2),
                'color' => $color,
                'rating' => $rating
            ]
        ];
    }
}

if (!function_exists('calculateDeanPercentagesFast')) {

    function calculateDeanPercentagesFast($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        // Get average score of all employees under this dean
        $avgScore = IndicatorsPercentage::join('users', 'indicators_percentages.employee_id', '=', 'users.employee_id')
            ->where('users.manager_id', $employeeId)
            ->where('indicators_percentages.role_id', 22)
            ->where('indicators_percentages.indicator_id', $indicatorId)
            ->avg('indicators_percentages.score');

        // Prevent null values
        $avgScore = $avgScore ?? 0;
        // dd($indicatorId);
        // Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $avgScore
        );

        return round($avgScore, 2);
    }

}

if (!function_exists('calculateDeanPercentagesFastDiffFromHOD')) {

    function calculateDeanPercentagesFastDiffFromHOD($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        // Get average score of all employees under this dean
        $avgScore = IndicatorsPercentage::join('users', 'indicators_percentages.employee_id', '=', 'users.employee_id')
            ->where('users.manager_id', $employeeId)
            ->where('indicators_percentages.role_id', 22)
            ->where('indicators_percentages.indicator_id', $indicatorId)
            ->avg('indicators_percentages.with_out_weight_score');

        // Prevent null values
        $avgScore = $avgScore ?? 0;
        // 4️⃣ Get indicator weight
        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        // 5️⃣ Calculate weighted score
        $weightedScore = ($avgScore * $weight) / 100;
        // Save result
        if ($indicatorId == 146 || $indicatorId == 147 || $indicatorId == 148 || $indicatorId == 176) {
            saveIndicatorPercentage90Plus(
                $employeeId,
                $activeRoleId,
                $kpaId,
                $categoryId,
                $indicatorId,
                $weightedScore
            );
        } elseif ($indicatorId == 143) {
            saveIndicatorPercentage100Plus(
                $employeeId,
                $activeRoleId,
                $kpaId,
                $categoryId,
                $indicatorId,
                $weightedScore
            );
        } else {
            saveIndicatorPercentage(
                $employeeId,
                $activeRoleId,
                $kpaId,
                $categoryId,
                $indicatorId,
                $weightedScore
            );
        }


        return round($avgScore, 2);
    }

}

//------------------------------------------- Program Leader -------------------------------------------------

if (!function_exists('calculateStudentEngagementRateFromPL')) {

    function calculateStudentEngagementRateFromPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('student_engagement_rate')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG((number_of_students_participated / participation_target) * 100) as avg_participation,
        AVG(employer_satisfaction) as student_satisfaction_rate
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        $weight124 = getRoleWeightage($activeRoleId, 'indicator', 124)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->avg_participation * $weight123) / 100, 2);
        $weightedScore124 = round((($stats->student_satisfaction_rate * $weight124) / 100) * 20, 2);
        // Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );

        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            124,
            $weightedScore124
        );
    }
}

function EmployabilityOfPL($employeeId)
{
    $programIds = Program::where('leader_id', $employeeId)
        ->pluck('id');

    $records = Employability::whereIn('program_id', $programIds)
        ->get();

    $totalStudents = $records->count();

    if ($totalStudents == 0) {
        return collect();
    }

    $results = collect();

    // Role & Employee
    $activeRoleId = getRoleIdByName(activeRole());
    $employeeId = auth()->id();

    /*
    |--------------------------------------------------------------------------
    | 1️⃣ Student Employability (103)
    |--------------------------------------------------------------------------
    */

    $employed = $records->whereNotNull('date_of_appointment')->count();
    $employabilityPercentage = round(($employed / $totalStudents) * 100, 2);
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', 103)['weightage'],
        'course_104' => getRoleWeightage($activeRoleId, 'indicator', 104)['weightage'],
        'course_105' => getRoleWeightage($activeRoleId, 'indicator', 105)['weightage'],
        'course_106' => getRoleWeightage($activeRoleId, 'indicator', 106)['weightage'],
        'course_107' => getRoleWeightage($activeRoleId, 'indicator', 107)['weightage'],
        'course_157' => getRoleWeightage($activeRoleId, 'indicator', 157)['weightage'],
    ];
    $weightedScore = ($employabilityPercentage * $weights['course_load']) / 100;
    saveIndicatorPercentage90Plus(
        $employeeId,
        $activeRoleId,
        1, // KPA ID (adjust if dynamic)
        1, // Category ID (adjust if dynamic)
        103,
        $weightedScore
    );

    $results->push(makeIndicatorRow('Student Employability', 103, $employabilityPercentage));


    /*
    |--------------------------------------------------------------------------
    | 2️⃣ Market Competitive Salary (106)
    |--------------------------------------------------------------------------
    */

    $salaryScore = 0;
    foreach ($records as $r) {
        $salaryScore += match ($r->market_competitive_salary) {
            'Low' => 33,
            'At Par' => 66,
            'Above' => 100,
            default => 0
        };
    }

    $marketSalaryPercentage = round($salaryScore / $totalStudents, 2);
    $weightedScore106 = ($marketSalaryPercentage * $weights['course_106']) / 100;
    saveIndicatorPercentage($employeeId, $activeRoleId, 1, 1, 106, $weightedScore106);

    $results->push(makeIndicatorRow('Market Competitive Salary', 106, $weightedScore106));


    /*
    |--------------------------------------------------------------------------
    | 3️⃣ Job Relevancy (105)
    |--------------------------------------------------------------------------
    */

    $relevant = $records->where('job_relevancy', 'yes')->count();
    $jobRelevancyPercentage = round(($relevant / $totalStudents) * 100, 2);
    $weightedScore105 = ($jobRelevancyPercentage * $weights['course_105']) / 100;
    saveIndicatorPercentage90Plus($employeeId, $activeRoleId, 1, 1, 105, $weightedScore105);

    $results->push(makeIndicatorRow('Job Relevancy', 105, $weightedScore105));


    /*
    |--------------------------------------------------------------------------
    | 4️⃣ Employer Satisfaction (104)
    |--------------------------------------------------------------------------
    */

    $score = 0;
    foreach ($records as $r) {
        if (!is_null($r->employer_satisfaction)) {
            $score += $r->employer_satisfaction * 20;
        }
    }

    $employerSatisfactionPercentage = round($score / $totalStudents, 2);
    $weightedScore104 = ($employerSatisfactionPercentage * $weights['course_104']) / 100;
    $weightedScore157 = ($employerSatisfactionPercentage * $weights['course_157']) / 100;
    saveIndicatorPercentage($employeeId, $activeRoleId, 1, 1, 104, $weightedScore104);
    saveIndicatorPercentage($employeeId, $activeRoleId, 6, 14, 157, $weightedScore157);

    $results->push(makeIndicatorRow('Employer Satisfaction', 104, $weightedScore104));


    /*
    |--------------------------------------------------------------------------
    | 5️⃣ Graduate Satisfaction (107)
    |--------------------------------------------------------------------------
    */

    $score = 0;
    foreach ($records as $r) {
        if (!is_null($r->graduate_satisfaction)) {
            $score += $r->graduate_satisfaction * 20;
        }
    }

    $graduateSatisfactionPercentage = round($score / $totalStudents, 2);
    $weightedScore107 = ($graduateSatisfactionPercentage * $weights['course_107']) / 100;
    saveIndicatorPercentage($employeeId, $activeRoleId, 1, 1, 107, $weightedScore107);

    $results->push(makeIndicatorRow('Graduate Satisfaction', 107, $weightedScore107));

    return $results;
}

function QECAuditRatingOfPL($employeeId, $activeRoleId)
{
    $programIds = Program::where('leader_id', $employeeId)->pluck('id');

    $records = QecAuditRating::with([
        'details' => function ($q) use ($programIds) {
            $q->whereIn('program_id', $programIds)
                ->where('total_score', '>', 0)
                ->with(['faculty', 'department', 'program']);
        }
    ])
        ->whereHas('details', function ($q) use ($programIds) {
            $q->whereIn('program_id', $programIds)
                ->where('total_score', '>', 0);
        })
        ->get();

    $data = [];

    foreach ($records as $record) {
        foreach ($record->details as $detail) {
            $percentage = ($detail->obtained_score / $detail->total_score) * 100;

            $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', 110);
            $weight = $indicatorWeight['weightage'] ?? 0;
            $weightedScore = ($percentage * $weight) / 100;

            saveIndicatorPercentage($employeeId, $activeRoleId, 1, 3, 110, $weightedScore, $percentage);

            $data[] = (object) [
                'audit_term' => $detail->audit_term,
                'faculty' => $detail->faculty->name ?? '',
                'department' => $detail->department->name ?? '',
                'program' => $detail->program->program_name ?? '',
                'career' => $detail->program_level ?? '',
                'total_score' => $detail->total_score,
                'obtained_score' => $detail->obtained_score,
                'percentage' => round($percentage, 1),
            ];
        }
    }

    return collect($data);
}

if (!function_exists('lineManagerReviewRatingOnTasksOfPL')) {
    function lineManagerReviewRatingOnTasksOfPL($facultyId, $activeRoleId)
    {
        $managerRatings = [];
        $totalScore = 0;
        $taskCount = 0;

        $reviews = LineManagerReviewRating::with('tasks')
            ->where('employee_id', $facultyId)
            ->get();

        foreach ($reviews as $review) {
            foreach ($review->tasks as $task) {

                $score = $task->linemanager_rating * 20;
                $totalScore += $score;
                $taskCount++;

                if ($score >= 90) {
                    $label = 'OS';
                    $color = 'bg-primary';
                } elseif ($score >= 80) {
                    $label = 'EE';
                    $color = 'bg-success';
                } elseif ($score >= 70) {
                    $label = 'ME';
                    $color = 'bg-warning';
                } elseif ($score >= 60) {
                    $label = 'NI';
                    $color = 'bg-info';
                } else {
                    $label = 'BE';
                    $color = 'bg-danger';
                }

                $managerRatings[] = (object) [
                    'task' => $task->task,
                    'rating_data' => [
                        'percentage' => $score,
                        'label' => $label,
                        'color' => $color
                    ]
                ];
            }
        }
        $averageScore = $taskCount > 0 ? round($totalScore / $taskCount, 2) : 0;
        $weights = [
            'course_188' => getRoleWeightage($activeRoleId, 'indicator', 188)['weightage'],
        ];
        $weightedScore188 = ($averageScore * $weights['course_188']) / 100;
        saveIndicatorPercentage($facultyId, $activeRoleId, 13, 27, 188, $weightedScore188, $averageScore);
        return $managerRatings;
    }
}

if (!function_exists('admissionTargetAverageForPL')) {

    function admissionTargetAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('admission_target_achieveds')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG((achieved_target / admissions_target) * 100) as admission_target
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->admission_target * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage100Plus(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}

if (!function_exists('recoveryTargetAverageForPL')) {

    function recoveryTargetAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('recoveries')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG((achieved_target / recovery_target) * 100) as target_achieved
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->target_achieved * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}

if (!function_exists('programProfitabilityAverageForPL')) {

    function programProfitabilityAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('program_profitabilities')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG(profitability) as profit
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->profit * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}


function professionalMembershipTargetPL($employeeId, $activeRoleId, $indicatorId)
{
    $commercial = FacultyTarget::with([
        'professionalMembershipTarget' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicatorId);
        }
    ])
        ->where('user_id', $employeeId)
        ->where('form_status', 'OTHER')
        ->where('indicator_id', $indicatorId)
        ->get();
    $percentages = []; // For calculating overall average

    foreach ($commercial as $target) {

        $rows = $target->professionalMembershipTarget;
        $achieved = $rows->count();
        $required = (int) $target->target;

        // Prevent divide by zero
        $percentage = ($required > 0) ? ($achieved / $required) * 100 : 0;

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
        } else {
            $rating = 'BE';
            $color = '#ff4c51';
        }

        // Save percentage for avg calculation
        $percentages[] = $percentage;

        // Add values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;
    $weights = [
        'course_load' => getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'],
    ];
    $weightedScore = ($avgPercentage * $weights['course_load']) / 100;
    // ✅ Save globally
    saveIndicatorPercentage(
        $employeeId,
        $role_id = $activeRoleId,
        $keyPerformanceAreaId = 6,
        $indicatorCategoryId = 14,
        $indicatorId,
        $weightedScore
    );

    return $commercial;
}

if (!function_exists('targetIndicatorsAnalysisOfPL')) {

    function targetIndicatorsAnalysisOfPL($employeeId, $activeRoleId, $KpaId, $categoryId, $indicatorId)
    {

        // 1️⃣ Get programs where this user is Program Leader
        $programIds = Program::where('leader_id', $employeeId)->pluck('id');

        if ($programIds->isEmpty()) {
            return null;
        }

        // Indicator configuration
        $indicators = [

            135 => [
                'model' => \App\Models\NoOfGrantsSubmitAndWon::class,
                'filter' => ['grant_status' => 'Submitted']
            ],

            202 => [
                'model' => \App\Models\NoOfGrantsSubmitAndWon::class,
                'filter' => ['grant_status' => 'Won']
            ],

            136 => [
                'model' => \App\Models\NoAchievementOfMultidisciplinaryProjectsTarget::class
            ],

            197 => [
                'model' => \App\Models\IndustrialVisit::class
            ],

            198 => [
                'model' => \App\Models\IndustrialProjects::class
            ],

            139 => [
                'model' => \App\Models\SpinOff::class
            ],

            199 => [
                'model' => \App\Models\ProductsDeliveredToIndustry::class
            ],

            137 => [
                'model' => \App\Models\CommercialGainsCounsultancyResearchIncome::class
            ],

            138 => [
                'model' => \App\Models\IntellectualProperty::class
            ],

            194 => [
                'model' => \App\Models\NumberOfKnowledgeProduct::class
            ],

            154 => [
                'model' => \App\Models\ProgramAccreditation::class
            ],

            155 => [
                'model' => \App\Models\ProfessionalMembership::class
            ],

        ];

        if (!isset($indicators[$indicatorId])) {
            return null;
        }

        $modelClass = $indicators[$indicatorId]['model'];
        $filter = $indicators[$indicatorId]['filter'] ?? [];

        // 2️⃣ Get employee_ids (created_by) from indicator tables for leader's programs
        $employeeIds = $modelClass::whereIn('program_id', $programIds)
            ->where('indicator_id', $indicatorId)
            ->when(!empty($filter), function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, $value);
                }
            })
            ->distinct()
            ->pluck('created_by');

        if ($employeeIds->isEmpty()) {
            $employeeIds = collect([]);
        }

        // 3️⃣ Convert employee_ids → user_ids
        $userIds = User::whereIn('employee_id', $employeeIds)
            ->pluck('id');

        // 4️⃣ Calculate total submitted records
        $totalSubmitted = $modelClass::whereIn('created_by', $employeeIds)
            ->where('indicator_id', $indicatorId)
            ->when(!empty($filter), function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, $value);
                }
            })
            ->count();

        // 5️⃣ Get total targets
        $totalTarget = FacultyTarget::whereIn('user_id', $userIds)
            ->where('indicator_id', $indicatorId)
            ->sum('target');

        // 6️⃣ Calculate percentage
        $percentage = $totalTarget > 0
            ? round(($totalSubmitted / $totalTarget) * 100, 2)
            : 0;

        // 7️⃣ Get indicator weight
        $indicatorWeight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId);
        $weight = $indicatorWeight['weightage'] ?? 0;

        // 8️⃣ Calculate weighted score
        $weightedScore = ($percentage * $weight) / 100;

        // 9️⃣ Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $KpaId,
            $categoryId,
            $indicatorId,
            $weightedScore,
            $percentage
        );

        return [
            'percentage' => $percentage,
            'weighted_score' => $weightedScore,
            'total_target' => $totalTarget,
            'total_submitted' => $totalSubmitted
        ];
    }
}

if (!function_exists('dropOutRateAverageForPL')) {

    function dropOutRateAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('dropout_rates')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG(dropout_rate) as dropout
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->dropout * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}
if (!function_exists('alumniSatisfactionRateAverageForPL')) {

    function alumniSatisfactionRateAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('alumni_satisfaction_rates')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG(satisfaction_rate) as satisfaction
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->satisfaction * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}

if (!function_exists('alumniSatisfactionRateAverageForPL')) {

    function alumniSatisfactionRateAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('alumni_satisfaction_rates')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG(satisfaction_rate) as satisfaction
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->satisfaction * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}
if (!function_exists('scholarsSatisfactionAverageForPL')) {

    function scholarsSatisfactionAverageForPL($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $programIds = Program::where('leader_id', $employeeId)
            ->pluck('id');
        $stats = DB::table('scholars_satisfaction_in_thesis_stages')
            ->whereIn('program_id', $programIds)
            ->selectRaw('
        AVG(satisfaction_score) as satisfaction
    ')->first();

        $weight123 = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;
        // 5️⃣ Calculate weighted score
        $weightedScore123 = round(($stats->satisfaction * $weight123) / 100, 2);
        // Save result
        saveIndicatorPercentage(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore123
        );
    }
}

if (!function_exists('lineManagerRatingOnEventsForPL')) {
    function lineManagerRatingOnEventsForPL($facultyId, $activeRoleId)
    {
        $feedbacks = LineManagerEventFeedback::where('employee_id', $facultyId)->get();

        foreach ($feedbacks as $item) {

            // Ensure rating is numeric
            $percentage = (float) $item->rating;

            // Assign rating data for frontend display
            if ($percentage >= 90) {
                $label = 'OS';
                $color = 'bg-label-primary';
            } elseif ($percentage >= 80) {
                $label = 'EE';
                $color = 'bg-label-success';
            } elseif ($percentage >= 70) {
                $label = 'ME';
                $color = 'bg-label-warning';
            } elseif ($percentage >= 60) {
                $label = 'NI';
                $color = 'bg-label-orange';
            } else {
                $label = 'BE';
                $color = 'bg-label-danger';
            }

            $item->rating_data = [
                'percentage' => $percentage,
                'label' => $label,
                'color' => $color
            ];

            // Save to indicators_percentages table automatically
            $weights = [
                'course_load' => getRoleWeightage($activeRoleId, 'indicator', 187)['weightage'],
            ];
            $weightedScore = ($percentage * $weights['course_load']) / 100;

            saveIndicatorPercentage(
                $faculty_id = $facultyId,
                $role_id = $activeRoleId,
                $keyPerformanceAreaId = 2,   // set appropriate KPA ID
                $indicatorCategoryId = 26,    // set appropriate category ID
                $indicatorId = 187,
                $weightedScore,
                $percentage
            );
        }

        return $feedbacks;
    }
}

if (!function_exists('retentionRateofFaculty')) {

    function retentionRateofFaculty($employeeId, $activeRoleId, $kpaId, $categoryId, $indicatorId)
    {
        $facultyId = auth()->user()->faculty;

        $stats = DB::table('faculty_retentions_remarks')
            ->where('faculty_id', $facultyId)
            ->selectRaw('AVG(no_retention_rate) as satisfaction')
            ->first();

        $avg = $stats->satisfaction ?? 0;

        $weight = getRoleWeightage($activeRoleId, 'indicator', $indicatorId)['weightage'] ?? 0;

        $weightedScore = round(($avg * $weight) / 100, 2);

        saveIndicatorPercentage90Plus(
            $employeeId,
            $activeRoleId,
            $kpaId,
            $categoryId,
            $indicatorId,
            $weightedScore
        );

        $meta = getRatingMeta($avg);

        return (object) [
            'average_rating' => $avg,
            'faculty_id' => $facultyId, // ✅ FIXED HERE
            'weighted_score' => $weightedScore,
            'color' => $meta->color,
            'rating' => $meta->rating
        ];
    }
}

if (!function_exists('saveIndicatorPercentage100Plus')) {
    function saveIndicatorPercentage100Plus($employeeId, $role_id, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId, $score, $withOutWeightScore = null)
    {
        if ($score == 100) {
            $color = 'primary';
            $rating = 'OS';
        } elseif ($score >= 90 && $score <= 99) {
            $color = 'success';
            $rating = 'EE';
        } elseif ($score >= 80 && $score <= 89) {
            $color = 'warning';
            $rating = 'ME';
        } elseif ($score >= 70 && $score <= 79) {
            $color = 'orange';
            $rating = 'NI';
        } else { // <= 69
            $color = 'danger';
            $rating = 'BE';
        }

        IndicatorsPercentage::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'role_id' => $role_id,
                'key_performance_area_id' => $keyPerformanceAreaId,
                'indicator_category_id' => $indicatorCategoryId,
                'indicator_id' => $indicatorId,
            ],
            [
                'score' => number_format($score, 2),
                'color' => $color,
                'rating' => $rating,
            ]
        );
    }
}

function kpaAvgScoreForReport($kpa_id, $emp_id)
{
    // Get employee role
    $roleId = getRoleIdByName(activeRole());

    // Get KPA target weightage
    $target = RoleKpaAssignment::where('role_id', $roleId)
        ->where('key_performance_area_id', $kpa_id)
        ->value('kpa_weightage');

    $target = $target ?? 0;

    // Fetch scores and cap each at 100
    $avgs = IndicatorsPercentage::where('employee_id', $emp_id)
        ->where('role_id', $roleId)
        ->where('key_performance_area_id', $kpa_id)
        ->where('is_score', 1)
        ->get()
        ->pluck('score')
        ->map(fn($score) => min($score, 100))
        ->avg();
    $avg = ($avgs / $target) * 100;
    $avg = $avg ? round($avg, 2) : 0.00;
    // Rating logic
    if ($avg >= 90) {
        $color = '#6EA8FE';
        $rating = 'OS';
    } elseif ($avg >= 80) {
        $color = '#96e2b4';
        $rating = 'EE';
    } elseif ($avg >= 70) {
        $color = '#ffcb9a';
        $rating = 'ME';
    } elseif ($avg >= 60) {
        $color = '#fd7e13';
        $rating = 'NI';
    } else {
        $color = '#ff4c51';
        $rating = 'BE';
    }

    return [
        'target' => $target,
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}
