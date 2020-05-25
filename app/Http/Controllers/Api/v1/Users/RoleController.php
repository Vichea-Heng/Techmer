<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use App\Http\Requests\Users\RoleRequest;
use App\Http\Resources\Users\RoleResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Role::class);

        $datas = Role::get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(RoleResource::collection($datas));
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Role::onlyTrashed()->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(RoleResource::collection($datas));
    }

    public function store(RoleRequest $request)
    {

        // $this->authorize("create", Role::class);

        $data = $request->validated();

        $data = Role::create($data);

        return dataResponse(new RoleResource($data));
    }

    public function show(Role $role)
    {

        // $this->authorize("view", Role::class);

        return dataResponse(new RoleResource($role));
    }

    public function update(RoleRequest $request, Role $role)
    {

        // $this->authorize("update", Role::class);

        $data = $request->validated();

        $role->update($data);

        return dataResponse(new RoleResource($role));
    }

    public function destroy(Role $role)
    {

        // $this->authorize("delete", Role::class);

        $role->delete();

        return destoryResponse();
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Role::onlyTrashed()->findOrFail($id);

        $data->restore();

        return restoreResponse();
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Role::withTrashed()->findOrFail($id);

        $data->forceDelete();

        return forceDestoryResponse();
    }
}
