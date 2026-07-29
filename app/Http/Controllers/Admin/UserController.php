<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with('roles');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->whereHas('roles', fn($q) => $q->where('slug', $role));
        }

        $users = $query->latest()->paginate(15);

        $userCounts = User::selectRaw("count(*) as total")
            ->selectRaw("count(case when exists (select 1 from role_user inner join roles on roles.id = role_user.role_id where role_user.user_id = users.id and roles.slug = 'admin') then 1 end) as admins")
            ->selectRaw("count(case when email_verified_at is not null then 1 end) as verified")
            ->first();



        $stats = [
            'total' => (int) $userCounts->total,
            'admins' => (int) $userCounts->admins,
            'verified' => (int) $userCounts->verified,
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function show(User $user): View
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load('roles');
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,slug'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        $roleIds = Role::whereIn('slug', $validated['roles'])->pluck('id');
        $user->roles()->sync($roleIds);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
