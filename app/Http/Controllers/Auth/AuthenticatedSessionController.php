<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): JsonResponse|RedirectResponse
    // {
    //     $baseUrl = config('services.pms.base_url');
    //     $response = Http::post("{$baseUrl}/employee-login", [
    //         'username' => $request->email,
    //         'password' => $request->password,
    //     ]);

    //     if ($response->successful()) {


    //         $userData = $response->json();

    //         $responseUserData = Http::withToken($userData['access_token'])
    //             ->get("{$baseUrl}/get-employee-info", [
    //                 'user_id' => $userData['user_id'],
    //             ])->json();

    //         // Store user details and token in session
    //         session([
    //             'access_token' => $userData['access_token'],
    //             'token_type' => $userData['token_type'],
    //             'employee_id' => $responseUserData['employee_id'],
    //             'user_id' => $userData['user_id'],
    //             'username' => $userData['username'],
    //             'user_type' => $userData['user_type'],
    //         ]);
    //         // Redirect based on user_type
    //         // if ($userData['user_type'] === 'admin') {
    //         //     return redirect()->intended(route('admin.dashboard'));
    //         // }

    //         return redirect()->intended(route('rector-dashboard.index'));
    //     }
    //     return back()->withErrors([
    //         'email' => 'Invalid credentials or login failed.',
    //     ]);
    // }
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

         $user = Auth::user();
         indicatorsPercentageStatus($user);

        try {
            $userStatus = decrypt($request->input('user_status'));
            session()->flash('login_success', true);
            return match ($userStatus) {
                'student' => redirect()->route('student.dashboard'),
                'survey' => redirect()->route('survey_dashboard.report'),
                'teacher' => redirect()->route('teacher_dashboard'),
                default => redirect()->route('teacher_dashboard'),
            };

        } catch (DecryptException $e) {
            // Prevent tampering: log, alert, or handle error as needed
            abort(403, 'Invalid or tampered user status.');
        }
    }
    /**
     * Destroy an authenticated session.
     */
    // public function destroy(Request $request): RedirectResponse|JsonResponse
    // {
    //     // Clear all session data
    //     $request->session()->flush();

    //     return redirect()->route('login'); // or redirect('/')

    // }
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
