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
use App\Models\LineManagerFeedback;
use App\Models\LineManagerEventFeedback;
use App\Models\IndicatorsPercentage;

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
    $classes = FacultyMemberClass::with([
        'attendances' => function ($query) {
            $query->orderBy('class_date', 'desc'); // latest attendance first
        }
    ])
        ->where('faculty_id', $facultyId)
        ->select('class_id', 'class_name', 'code', 'term', 'career_code')
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
        $keyPerformanceAreaId = 1,
        $indicatorCategoryId = 3,
        $indicatorId = 122,
        $score
    );
    return $classes;
}

function myClassesAttendanceRecord($facultyId)
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

            // Color & rating logic
            if ($class->held_percentage >= 90) {
                $class->color = '#6EA8FE';
                $class->rating = 'OS';
            } elseif ($class->held_percentage >= 80) {
                $class->color = '#96e2b4';
                $class->rating = 'EE';
            } elseif ($class->held_percentage >= 70) {
                $class->color = '#ffcb9a';
                $class->rating = 'ME';
            } elseif ($class->held_percentage >= 60) {
                $class->color = '#fd7e13';
                $class->rating = 'NI';
            } elseif ($class->held_percentage >= 50) {
                $class->color = '#ff4c51';
                $class->rating = 'BE';
            } else {
                $class->color = '#d3d3d3';
                $class->rating = 'NA';
            }

            return $class;
        });

    // ✅ Save overall percentage
    saveOverallAttendancePercentage($facultyId = getUserID($facultyId), $classes, $keyPerformanceAreaId = 1, $indicatorCategoryId = 3, $indicatorId = 117);

    return $classes;
}
function saveOverallAttendancePercentage($facultyId, $classes, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId)
{
    if ($classes->count() == 0) {
        $overallPercentage = 0;
    } else {
        $overallPercentage = round($classes->avg('held_percentage'), 2);
    }

    // Color & rating logic (same as above)
    if ($overallPercentage >= 90) {
        $color = 'primary';
        $rating = 'OS';
    } elseif ($overallPercentage >= 80) {
        $color = 'success';
        $rating = 'EE';
    } elseif ($overallPercentage >= 70) {
        $color = 'warning';
        $rating = 'ME';
    } elseif ($overallPercentage >= 60) {
        $color = 'secondary';
        $rating = 'NI';
    } elseif ($overallPercentage >= 50) {
        $color = 'danger';
        $rating = 'BE';
    } else {
        $color = 'dark';
        $rating = 'NA';
    }

    // Save to database
    IndicatorsPercentage::updateOrCreate(
        [
            'employee_id' => $facultyId,
            'key_performance_area_id' => $keyPerformanceAreaId,
            'indicator_category_id' => $indicatorCategoryId,
            'indicator_id' => $indicatorId,
        ],
        [
            'score' => $overallPercentage,
            'rating' => $rating,
            'color' => $color,
        ]
    );

    return $overallPercentage;
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
    function ScopusPublications($facultyId, $indicatorId, $keyPerformanceAreaId = 2, $indicatorCategoryId = 5)
    {
        $facultyTargets = FacultyTarget::with([
            'researchPublicationTargets' => function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
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
            'NA' => '#000000',
        ];

        $totalTarget = 0;
        $totalSubmitted = 0;

        foreach ($facultyTargets as $facultyTarget) {
            $targetCount = $facultyTarget->target ?? 0;
            $submissionCount = $facultyTarget->researchPublicationTargets->count();

            $totalTarget += $targetCount;
            $totalSubmitted += $submissionCount;

            if ($facultyTarget->researchPublicationTargets->isEmpty())
                continue;

            $grouped = $facultyTarget->researchPublicationTargets
                ->groupBy(fn($t) => strtoupper($t->journal_clasification));

            foreach ($grouped as $classification => $targets) {
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

                $rating = match (true) {
                    $percentage >= 90 => 'OS',
                    $percentage >= 80 => 'EE',
                    $percentage >= 70 => 'ME',
                    $percentage >= 60 => 'NI',
                    $percentage > 0 => 'BE',
                    default => 'NA',
                };

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

        // ✅ Correct overall percentage: total submitted / total target
        $avgPercentage = ($totalTarget > 0) ? round(($totalSubmitted / $totalTarget) * 100, 2) : 0;

        // ✅ Save globally
        saveIndicatorPercentage(
            $facultyId,
            $keyPerformanceAreaId = 2,
            $indicatorCategoryId = 5,
            $indicatorId = 128,
            $avgPercentage
        );

        return $data;
    }
}


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
            'NA' => '#000000',
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
                elseif ($percentage > 0)
                    $rating = 'BE';
                else
                    $rating = 'NA';

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
    $facultyTargets = FacultyTarget::with([
        'intellectualPropertyTargets' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
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
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51';
        } else {
            $rating = 'NA';
            $color = '#000000';
        }

        // Add calculated values into object
        $target->achieved_count = $achieved;
        $target->percentage = round($percentage, 2);
        $target->rating = $rating;
        $target->color = $color;
    }

    // ✅ Calculate overall average percentage
    $avgPercentage = count($percentages) ? round(array_sum($percentages) / count($percentages), 2) : 0;

    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $avgPercentage
    );

    return $facultyTargets;
}

function CommercialGainsCounsultancyResearchIncome($facultyId, $indicator_id)
{
    $commercial = FacultyTarget::with([
        'commercialGainsCounsultancyTargets' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
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
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51';
        } else {
            $rating = 'NA';
            $color = '#000000';
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

    // ✅ Save globally
    saveIndicatorPercentage(
        $facultyId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicator_id,
        $avgPercentage
    );

    return $commercial;
}
function MultidisciplinaryProjects($facultyId, $indicatorId)
{
    $facultyTargets = FacultyTarget::with([
        'achievementOfMultidisciplinaryProjectsTarget' => function ($query) use ($indicatorId) {
            $query->where('form_status', 'RESEARCHER')
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
        } elseif ($percentage > 0) {
            $rating = 'BE';
            $color = '#ff4c51';
        } else {
            $rating = 'NA';
            $color = '#000000';
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
    saveIndicatorPercentage(
        $facultyId,
        $keyPerformanceAreaId = 2,
        $indicatorCategoryId = 8,
        $indicatorId = 136,
        $avgPercentage
    );

    return $facultyTargets;
}

function noofGrantsWon($facultyId, $indicator_id)
{
    $facultyTargets = FacultyTarget::with([
        'noofGrantsWonTarget' => function ($query) use ($indicator_id) {
            $query->where('form_status', 'RESEARCHER')
                ->where('indicator_id', $indicator_id);
        }
    ])
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
    $CompletionOfCourseFolder = CompletionOfCourseFolder::with(['facultyMember', 'facultyClass'])
        ->where('faculty_member_id', $facultyId)
        ->where('form_status', 'HOD')
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
        } elseif ($target->completion_of_Course_folder == 25) {
            $rating = 'BE';
            $color = '#ff4c51';
            $status = 'Not Completed';
        } else {
            $rating = 'NI';
            $color = '#000000';
            $status = 'NA';
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

    // Save to IndicatorsPercentage table
    saveIndicatorPercentage(
        $facultyId,
        $keyPerformanceAreaId = 1,
        $indicatorCategoryId = 3,
        $indicator_id,
        $avgPercentage
    );

    return $CompletionOfCourseFolder;
}

function ComplianceandUsageofLMS($facultyId, $indicator_id)
{
    $CompletionOfCourseFolder = CompletionOfCourseFolder::with(['facultyMember', 'facultyClass'])
        ->where('faculty_member_id', $facultyId)
        ->where('form_status', 'HOD')
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
        } elseif ($target->compliance_and_usage_of_lms == 25) {
            $rating = 'BE';
            $color = '#ff4c51';
            $status = 'Not Completed';
        } else {
            $rating = 'NI';
            $color = '#000000';
            $status = 'NA';
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

    // ✅ Save globally (corrected)
    saveIndicatorPercentage(
        $facultyId,
        $keyPerformanceAreaId = 1,
        $indicatorCategoryId = 3,
        $indicator_id,
        $avgPercentage
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
        if ($avg > 0)
            return ['percentage' => $avg, 'rating' => 'BE', 'color' => 'bg-label-danger'];

        return ['percentage' => 0, 'rating' => 'NA', 'color' => 'bg-label-dark'];
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
    function lineManagerRatingOnTasks($facultyId)
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

        // Save overall average to database
        saveIndicatorPercentage(
            $faculty_id = $facultyId,
            $keyPerformanceAreaId = 13,  // set appropriate KPA ID
            $indicatorCategoryId = 27,   // set appropriate category ID
            $indicatorId = 188,         // set appropriate indicator ID
            $overallAvg
        );

        return $feedbacks;
    }
}

if (!function_exists('saveIndicatorPercentage')) {
    function saveIndicatorPercentage($employeeId, $keyPerformanceAreaId, $indicatorCategoryId, $indicatorId, $score)
    {
        // Determine color and rating based on score
        if ($score >= 90 && $score <= 100) {
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
        } elseif ($score >= 50) {
            $color = 'danger';
            $rating = 'BE';
        } else {
            $color = 'secondary';
            $rating = 'NA';
        }

        IndicatorsPercentage::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'key_performance_area_id' => $keyPerformanceAreaId,
                'indicator_category_id' => $indicatorCategoryId,
                'indicator_id' => $indicatorId,
            ],
            [
                'score' => round($score, 2),
                'color' => $color,
                'rating' => $rating,
            ]
        );
    }
}


if (!function_exists('lineManagerRatingOnEvents')) {
    function lineManagerRatingOnEvents($facultyId)
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
            } elseif ($percentage > 0) {
                $label = 'BE';
                $color = 'bg-label-danger';
            } else {
                $label = 'NA';
                $color = 'bg-label-dark';
            }

            $item->rating_data = [
                'percentage' => $percentage,
                'label' => $label,
                'color' => $color
            ];

            // Save to indicators_percentages table automatically
            saveIndicatorPercentage(
                $faculty_id = $facultyId,
                $keyPerformanceAreaId = 13,   // set appropriate KPA ID
                $indicatorCategoryId = 28,    // set appropriate category ID
                $indicatorId = 189,           // set appropriate indicator ID
                $percentage
            );
        }

        return $feedbacks;
    }
}

function avgKpaScore($employeeId, $kpaId)
{
    $avg = IndicatorsPercentage::where('employee_id', $employeeId)
        ->where('key_performance_area_id', $kpaId)
        ->avg('score'); // Eloquent will run SQL AVG()

    return round($avg ?? 0, 2);
}
if (!function_exists('ResearchProductivityofPGStudents')) {
    function ResearchProductivityofPGStudents($facultyId, $indicatorId)
    {
        $facultyTargets = FacultyTarget::with([
            'researchPublicationTargets' => function ($query) use ($indicatorId) {
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
            ->whereHas('researchPublicationTargets', function ($query) use ($indicatorId) {
                $query->where('form_status', 'RESEARCHER')
                    ->where('indicator_id', $indicatorId)
                    ->whereNotNull('journal_clasification')
                    ->whereHas('coAuthors', function ($q) {
                        $q->where('your_role', 'Student');
                    });
            })
            ->get();

        $data = [];
        $percentages = []; // Initialize to avoid count() on null

        $ratingColors = [
            'OS' => '#6EA8FE',
            'EE' => '#96e2b4',
            'ME' => '#ffcb9a',
            'NI' => '#fd7e13',
            'BE' => '#ff4c51',
            'NA' => '#000000',
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
                elseif ($percentage > 0)
                    $rating = 'BE';
                else
                    $rating = 'NA';

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

        saveIndicatorPercentage(
            $facultyId,
            $keyPerformanceAreaId = 2,
            $indicatorCategoryId = 6,
            $indicatorId = 133,
            $avgPercentage
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
    if ($avg >= 90 && $avg <= 100) {
        $color = 'bg-label-primary';
        $rating = 'OS';
    } elseif ($avg >= 80) {
        $color = 'bg-label-success';
        $rating = 'EE';
    } elseif ($avg >= 70) {
        $color = 'bg-label-warning';
        $rating = 'ME';
    } elseif ($avg >= 60) {
        $color = 'bg-label-orange';
        $rating = 'NI';
    } elseif ($avg >= 50) {
        $color = 'bg-label-danger';
        $rating = 'BE';
    } else {
        $color = 'secondary';
        $rating = 'NA';
    }

    return [
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}

function kpaAvgScore($kpa_id, $emp_id)
{
    $avg = IndicatorsPercentage::where('employee_id', $emp_id)
        ->where('key_performance_area_id', $kpa_id)
        ->avg('score');

    $avg = $avg ? round($avg, 2) : 0.00;

    // Determine rating & color dynamically
    if ($avg >= 90 && $avg <= 100) {
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
    } elseif ($avg >= 50) {
        $color = 'danger';
        $rating = 'BE';
    } else {
        $color = 'secondary';
        $rating = 'NA';
    }

    return [
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}

function indicatorAvgScore($indicator_id, $emp_id)
{
    $avg = IndicatorsPercentage::where('employee_id', $emp_id)
        ->where('indicator_id', $indicator_id)
        ->avg('score');

    $avg = $avg ? round($avg, 2) : 0.00;

    if ($avg >= 90 && $avg <= 100) {
        $color = 'primary';
        $rating = 'OS';
    } elseif ($avg >= 80) {
        $color = 'success';
        $rating = 'EE';
    } elseif ($avg >= 70) {
        $color = 'warning';
        $rating = 'ME';
    } elseif ($avg >= 60) {
        $color = 'warning';
        $rating = 'NI';
    } elseif ($avg >= 50) {
        $color = 'danger';
        $rating = 'BE';
    } else {
        $color = 'secondary';
        $rating = 'NA';
    }

    return [
        'avg' => $avg,
        'rating' => $rating,
        'color' => $color,
    ];
}







