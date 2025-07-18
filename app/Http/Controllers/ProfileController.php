<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form with user management for admins.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $users = collect(); // Default empty collection
        $roles = collect(); // Default empty collection

        // If user is admin, load all users and roles for management
        if ($user->hasRole('Admin')) {
            $users = User::with('roles')->get();
            $roles = Role::all();
        }

        return view('profile.edit', [
            'user' => $user,
            'users' => $users,
            'roles' => $roles,
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
     * Create a new user (Admin only).
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('profile.edit')->with('status', 'user-created');
    }

    /**
     * Update another user's information (Admin only).
     */
    public function updateUser(Request $request, User $targetUser): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$targetUser->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required'
        ]);

        $targetUser->name = $request->name;
        $targetUser->email = $request->email;
        if ($request->filled('password')) {
            $targetUser->password = Hash::make($request->password);
        }
        $targetUser->save();

        $targetUser->syncRoles($request->role);

        return redirect()->route('profile.edit')->with('status', 'user-updated');
    }

    /**
     * Delete another user's account (Admin only, cannot delete self).
     */
    public function destroyUser(User $targetUser): RedirectResponse
    {

        // Don't allow admin to delete themselves
        if (Auth::id() == $targetUser->id) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        }

        $targetUser->delete();

        return redirect()->route('profile.edit')->with('status', 'user-deleted');
    }

    /**
     * Delete the user's account (only self-deletion allowed for non-admins).
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
