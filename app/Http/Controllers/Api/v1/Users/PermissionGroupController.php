<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use App\Models\Users\PermissionGroup;
use App\Http\Requests\Users\PermissionGroupRequest;
use App\Http\Resources\Users\PermissionGroupResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
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

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : PermissionGroupResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = PermissionGroup::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : PermissionGroupResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(PermissionGroupRequest $request)
    {

        // $this->authorize("create", PermissionGroup::class);

        $data = $request->validated();

        $data = PermissionGroup::create($data);

        $data = new PermissionGroupResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(PermissionGroup $permission_group)
    {

        // $this->authorize("view", PermissionGroup::class);

        $data = new PermissionGroupResource($permission_group);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(PermissionGroupRequest $request, PermissionGroup $permission_group)
    {

        // $this->authorize("update", PermissionGroup::class);

        $data = $request->validated();

        $permission_group->update($data);

        $data = new PermissionGroupResource($permission_group);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(PermissionGroup $permission_group)
    {

        // $this->authorize("delete", PermissionGroup::class);

        $permission_group->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = PermissionGroup::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = PermissionGroup::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
