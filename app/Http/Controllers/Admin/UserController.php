<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:superadmin,admin,creator',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make(Str::random(16)), // Random secure password
        ]);

        // Send a password reset link to the new user acting as an invitation
        $token = Password::broker()->createToken($user);
        $user->sendPasswordResetNotification($token);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan dan email undangan (reset password) telah dikirim.');
    }

    public function update(Request $request, User $user)
    {
        // Don't allow changing your own role to prevent lockout
        if ($user->id === auth()->id() && $request->role !== $user->role) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,admin,creator',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Move articles to another user or let them be deleted (depends on app logic, here we just delete user)
        // Usually we might want to soft-delete or reassign, but for now we just delete.
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
