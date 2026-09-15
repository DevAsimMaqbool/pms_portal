<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

        public function UserupdatePassword(Request $request): RedirectResponse
        {
            $validated = $request->validateWithBag('updatePassword', [
                'employee_id' => ['required', 'exists:users,employee_id'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            $user = User::where('employee_id', $validated['employee_id'])->firstOrFail();

            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            // Logout current user
            Auth::logout();

            // Invalidate current session
            $request->session()->invalidate();

            // Regenerate CSRF token
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

}
