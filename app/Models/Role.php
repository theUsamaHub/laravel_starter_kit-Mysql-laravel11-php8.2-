<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use \App\Traits\LogsActivity;

    protected $fillable = ['name', 'slug', 'description', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function hasUser(User $user): bool
    {
        return $this->users()->where('users.id', $user->id)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }

    public function givePermission(string $permission): void
    {
        $perms = $this->permissions ?? [];
        if (!in_array($permission, $perms)) {
            $perms[] = $permission;
            $this->update(['permissions' => $perms]);
        }
    }

    public function revokePermission(string $permission): void
    {
        $perms = array_filter($this->permissions ?? [], fn($p) => $p !== $permission);
        $this->update(['permissions' => array_values($perms)]);
    }
}
