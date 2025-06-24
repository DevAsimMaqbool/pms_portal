<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
    public function store(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $baseUrl = config('services.pms.base_url');
        $response = Http::post("{$baseUrl}/employee-login", [
        'username' => $request->email,
        'password' => $request->password,
        ]);

        if ($response->successful()) {
            $userData = $response->json();
            // Store user details and token in session
            session([
                'access_token' => $userData['access_token'],
                'token_type' => $userData['token_type'],
                'user_id' => $userData['user_id'],
                'username' => $userData['username'],
                'user_type' => $userData['user_type'],
            ]);
            // Redirect based on user_type
            // if ($userData['user_type'] === 'admin') {
            //     return redirect()->intended(route('admin.dashboard'));
            // }

            return redirect()->intended(route('dashboard'));
        }
         return back()->withErrors([
                'email' => 'Invalid credentials or login failed.',
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse|JsonResponse
    {
        // Clear all session data
        $request->session()->flush();

        return redirect()->route('login'); // or redirect('/')

    }
}
