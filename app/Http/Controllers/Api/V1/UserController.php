<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = User::with('roles');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate($request->input('per_page', 15));

        return \App\Http\Resources\UserResource::collection($users);
    }

    public function show(User $user): \App\Http\Resources\UserResource
    {
        $user->load('roles');
        return new \App\Http\Resources\UserResource($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['exists:roles,slug'],
        ]);

        $user->update(collect($validated)->only(['name', 'email'])->toArray());

        if (isset($validated['roles'])) {
            $roleIds = Role::whereIn('slug', $validated['roles'])->pluck('id');
            $user->roles()->sync($roleIds);
        }

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user->fresh(['roles']),
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'You cannot delete your own account.'], 400);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
