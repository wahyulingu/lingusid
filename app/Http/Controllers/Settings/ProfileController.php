<?php

namespace App\Http\Controllers\Settings;

use App\Actions\User\DeleteUserAction;
use App\Actions\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $updateUserAction->handle(['user' => $request->user()] + $request->validated());

        return to_route('profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request, DeleteUserAction $deleteUserAction): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $deleteUserAction->handle(['user' => $user]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
