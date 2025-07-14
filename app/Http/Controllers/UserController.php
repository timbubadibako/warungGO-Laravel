<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role; // Import Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash
use Illuminate\Support\Facades\Auth; // Import Auth

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
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

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        // Jangan biarkan user menghapus dirinya sendiri
        if (Auth::id() == $user->id) {
            return back();
        }
        $user->delete();
        return redirect()->route('users.index');
    }
}
