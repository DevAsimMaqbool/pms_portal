<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\UserCategoryScore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;

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
        $token = session('access_token');
        $userId = session('user_id');
        $baseUrl = config('services.pms.base_url');
        $response = Http::withToken($token)->get("{$this->baseUrl}/get-employee-info", [
            'user_id' => $userId,
        ]);
        if ($response->successful()) {
            $employee = $response->json();

            // ✅ Pass employee data to a Blade view
            return view('admin.dashbord', compact('employee'));
        }
    }
}