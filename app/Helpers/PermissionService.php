<?php

namespace App\Helpers;

use App\Models\User;

class PermissionService
{
    public function syncPermission(User $user, array $permissions): void
    {
        $user->permissions()->sync($permissions);
    }
}
