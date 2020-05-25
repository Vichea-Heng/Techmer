<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\Users\PermissionRequest;
use App\Http\Resources\Users\PermissionResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Permission::class);

        $datas = Permission::get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(PermissionResource::collection($datas));
    }

    // public function indexOnlyTrashed()
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = Permission::onlyTrashed()->get();

    //     if (count($datas) == 0)
    //         throw new ModelNotFoundException;

    //     return dataResponse(PermissionResource::collection($datas));
    // }

    public function store(PermissionRequest $request)
    {

        // $this->authorize("create", Permission::class);

        $data = $request->validated();

        $data = Permission::create($data);

        return dataResponse(new PermissionResource($data));
    }

    public function show(Permission $permission)
    {

        // $this->authorize("view", Permission::class);

        return dataResponse(new PermissionResource($permission));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {

        // $this->authorize("update", Permission::class);

        $data = $request->validated();

        $permission->update($data);

        return dataResponse(new PermissionResource($permission));
    }

    public function destroy(Permission $permission)
    {

        // $this->authorize("delete", Permission::class);

        $permission->delete();

        return destoryResponse();
    }

    // public function restore($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = Permission::onlyTrashed()->findOrFail($id);

    //     $data->restore();

    //     return restoreResponse();
    // }

    // public function forceDestroy($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = Permission::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     return forceDestoryResponse();
    // }
}
