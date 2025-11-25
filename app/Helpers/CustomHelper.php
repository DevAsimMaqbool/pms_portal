<?php

//namespace App\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\RoleKpaAssignment;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Models\FacultyMemberClass;

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

function getRoleAssignments(string $roleName, ?int $kapcid = null)
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