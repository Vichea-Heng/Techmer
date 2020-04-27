<?php

namespace App\Policies\Users;

use App\Models\Users\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\User;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can("ViewAny Permission");
    }

    public function viewAnyWithTrash(User $user)
    {
        return $user->can("ViewAnyWithTrash Permission");
    }

    public function view(User $user, Permission $permission)
    {
        return $user->can("ViewOwn Permission");
    }
    
    public function viewWithTrashed(User $user, Permission $permission)
    {
        return $user->can("ViewWithTrashed Permission");
    }

    public function create(User $user)
    {
        return $user->can("Create Permission");
    }

    public function update(User $user, Permission $permission)
    {
        return $user->can("Update Permission");
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->can("Delete Permission");
    }

    public function restore(User $user, Permission $permission)
    {
        return $user->can("Restore Permission");
    }

    public function forceDelete(User $user, Permission $permission)
    {
        return $user->can("ForceDelete Permission");
    }
}
