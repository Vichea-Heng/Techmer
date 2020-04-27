<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\Users\PermissionRequest;
use App\Http\Resources\Users\PermissionResource;

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

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : PermissionResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Permission::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : PermissionResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(PermissionRequest $request)
    {

        // $this->authorize("create", Permission::class);

        $data = $request->validated();

        $data = Permission::create($data);

        $data = new PermissionResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(Permission $permission)
    {

        // $this->authorize("view", Permission::class);

        $data = new PermissionResource($permission);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {

        // $this->authorize("update", Permission::class);

        $data = $request->validated();

        $permission->update($data);

        $data = new PermissionResource($permission);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(Permission $permission)
    {

        // $this->authorize("delete", Permission::class);

        $permission->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Permission::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Permission::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
