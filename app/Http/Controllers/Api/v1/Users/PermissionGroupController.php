<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use App\Models\Users\PermissionGroup;
use App\Http\Requests\Users\PermissionGroupRequest;
use App\Http\Resources\Users\PermissionGroupResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionGroupController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", PermissionGroup::class);

        $datas = PermissionGroup::get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(PermissionGroupResource::collection($datas));
    }

    // public function indexOnlyTrashed()
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = PermissionGroup::onlyTrashed()->get();

    //     $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : PermissionGroupResource::collection($datas));

    //     return response()->json($datas, Response::HTTP_OK);
    // }

    public function store(PermissionGroupRequest $request)
    {

        // $this->authorize("create", PermissionGroup::class);

        $data = $request->validated();

        $data = PermissionGroup::create($data);

        return dataResponse(new PermissionGroupResource($data));
    }

    public function show(PermissionGroup $permission_group)
    {

        // $this->authorize("view", PermissionGroup::class);

        return dataResponse(new PermissionGroupResource($permission_group));
    }

    public function update(PermissionGroupRequest $request, PermissionGroup $permission_group)
    {

        // $this->authorize("update", PermissionGroup::class);

        $data = $request->validated();

        $permission_group->update($data);

        return dataResponse(new PermissionGroupResource($permission_group));
    }

    public function destroy(PermissionGroup $permission_group)
    {

        // $this->authorize("delete", PermissionGroup::class);

        Permission::where("group_id", $permission_group->id)->each(fn ($query) => $query->delete());

        $permission_group->delete();

        return destoryResponse();
    }

    // public function restore($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = PermissionGroup::onlyTrashed()->findOrFail($id);

    //     $data->restore();

    //     $data = ["message" => "Data Restore successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }

    // public function forceDestroy($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = PermissionGroup::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     $data = ['message' => "Data Force Delete Successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }
}
