<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount('users')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('admin.roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:roles,slug'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): View
    {
        return view('admin.roles.edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Cannot delete role with assigned users.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
