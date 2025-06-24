<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected string $baseUrl;
     public function __construct()
    {
        $this->baseUrl = config('services.pms.base_url');
    }
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
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
            return view('profile.index', compact('employee'));
        }
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
