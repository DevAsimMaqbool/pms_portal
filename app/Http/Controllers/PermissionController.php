<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleKpaAssignment;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    protected string $baseUrl;
    public function __construct()
    {
        $this->baseUrl = config('services.pms.base_url');
    }
    /**
     * Display the user's profile form.
     */
    public function dashboard(Request $request)
    {
        // $token = session('access_token');
        // $userId = session('user_id');
        // $baseUrl = config('services.pms.base_url');
        // $response = Http::withToken($token)->get("{$this->baseUrl}/get-employee-info", [
        //     'user_id' => $userId,
        // ]);
        // if ($response->successful()) {
        //     $employee = $response->json();

        //     // ✅ Pass employee data to a Blade view
        //     return view('admin.dashbord', compact('employee'));
        // }
        $user = Auth::user();
        $role = $user->roles->first();

        $assignments = RoleKpaAssignment::with(['kpa', 'category', 'indicator'])
            ->where('role_id', $role->id)
            ->get();

        // Group data
        $grouped = $assignments->filter(fn($a) => $a->kpa && $a->category && $a->indicator)
            ->groupBy(fn($a) => $a->kpa->id)
            ->map(function ($kpaGroup) {
                $kpa = $kpaGroup->first()->kpa;

                return [
                    'kpa_id' => $kpa->id,
                    'kpa_name' => $kpa->performance_area,
                    'kpa_weight' => $kpa->weight ?? 'N/A', // assuming weight column exists
                    'categories' => $kpaGroup->groupBy(fn($a) => $a->category->id)
                        ->map(function ($catGroup) {
                            $category = $catGroup->first()->category;

                            return [
                                'category_id' => $category->id,
                                'category_name' => $category->indicator_category,
                                'indicators' => $catGroup->map(function ($item) {
                                    return [
                                        'indicator_id' => $item->indicator->id,
                                        'indicator_name' => $item->indicator->indicator,
                                        'indicator_score' => $item->indicator->score ?? null, // optional
                                    ];
                                })->values()
                            ];
                        })->values()
                ];
            })->values();
        // dd($grouped);
        // Fetch the user from the database
        $employee = User::find($user->id);

        if (!$employee) {
            abort(404, 'User not found');
        }
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
        $data = [100, 40, 50, 60, 70, 80, 90, 85];

        // Pass the user data to the view
        if ($role->name == 'Rector') {
            return redirect()->route('rector-dashboard.index');
        }
        if ($role->name == 'Teacher' || $role->name == 'Assistant Professor') {
            return view('admin.teacher_dashbord', compact('employee'));
        } elseif ($role->name == 'Survey') {
            return view('admin.survey_dashbord', compact('employee'));
        } elseif ($role->name == 'Rector') {
            return view('admin.rector_dashboard', compact('employee'));
        } elseif ($role->name == 'HOD') {
            return view('admin.hod_dashboard', compact('employee'));
        } elseif ($role->name == 'Dean') {
            return view('admin.dean_dashboard', compact('employee'));
        } elseif ($role->name == 'ORIC') {
            return view('admin.oric_dashboard', compact('employee'));
        } else {
            return view('admin.teacher_dashbord', compact('employee'));
        }

    }
    public function dashboardV1(Request $request)
    {
        // $token = session('access_token');
        // $userId = session('user_id');
        // $baseUrl = config('services.pms.base_url');
        // $response = Http::withToken($token)->get("{$this->baseUrl}/get-employee-info", [
        //     'user_id' => $userId,
        // ]);
        // if ($response->successful()) {
        //     $employee = $response->json();

        //     // ✅ Pass employee data to a Blade view
        //     return view('admin.dashbord', compact('employee'));
        // }
        $user = Auth::user();
        $role = $user->roles->first();

        $assignments = RoleKpaAssignment::with(['kpa', 'category', 'indicator'])
            ->where('role_id', $role->id)
            ->get();

        // Group data
        $grouped = $assignments->filter(fn($a) => $a->kpa && $a->category && $a->indicator)
            ->groupBy(fn($a) => $a->kpa->id)
            ->map(function ($kpaGroup) {
                $kpa = $kpaGroup->first()->kpa;

                return [
                    'kpa_id' => $kpa->id,
                    'kpa_name' => $kpa->performance_area,
                    'kpa_weight' => $kpa->weight ?? 'N/A', // assuming weight column exists
                    'categories' => $kpaGroup->groupBy(fn($a) => $a->category->id)
                        ->map(function ($catGroup) {
                            $category = $catGroup->first()->category;

                            return [
                                'category_id' => $category->id,
                                'category_name' => $category->indicator_category,
                                'indicators' => $catGroup->map(function ($item) {
                                    return [
                                        'indicator_id' => $item->indicator->id,
                                        'indicator_name' => $item->indicator->indicator,
                                        'indicator_score' => $item->indicator->score ?? null, // optional
                                    ];
                                })->values()
                            ];
                        })->values()
                ];
            })->values();
        // dd($grouped);
        // Fetch the user from the database
        $employee = User::find($user->id);

        if (!$employee) {
            abort(404, 'User not found');
        }
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
        $data = [100, 40, 50, 60, 70, 80, 90, 85];

       
        if ($role->name == 'Teacher' || $role->name == 'Assistant Professor') {
            return view('admin.teacher_dashbord_bk', compact('employee'));
        } else {
            return view('admin.teacher_dashbord', compact('employee'));
        }

    }
}