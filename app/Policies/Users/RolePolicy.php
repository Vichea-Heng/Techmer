<?php

namespace App\Policies\Users;

use App\Models\Users\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\User;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can("ViewAny Role");
    }

    public function viewAnyWithTrash(User $user)
    {
        return $user->can("ViewAnyWithTrash Role");
    }

    public function view(User $user, Role $role)
    {
        return $user->can("ViewOwn Role");
    }
    
    public function viewWithTrashed(User $user, Role $role)
    {
        return $user->can("ViewWithTrashed Role");
    }

    public function create(User $user)
    {
        return $user->can("Create Role");
    }

    public function update(User $user, Role $role)
    {
        return $user->can("Update Role");
    }

    public function delete(User $user, Role $role)
    {
        return $user->can("Delete Role");
    }

    public function restore(User $user, Role $role)
    {
        return $user->can("Restore Role");
    }

    public function forceDelete(User $user, Role $role)
    {
        return $user->can("ForceDelete Role");
    }
}
