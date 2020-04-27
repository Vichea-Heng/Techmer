<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use App\Http\Requests\Users\RoleRequest;
use App\Http\Resources\Users\RoleResource;

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

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : RoleResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Role::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : RoleResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(RoleRequest $request)
    {

        // $this->authorize("create", Role::class);

        $data = $request->validated();

        $data = Role::create($data);

        $data = new RoleResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(Role $role)
    {

        // $this->authorize("view", Role::class);

        $data = new RoleResource($role);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(RoleRequest $request, Role $role)
    {

        // $this->authorize("update", Role::class);

        $data = $request->validated();

        $role->update($data);

        $data = new RoleResource($role);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(Role $role)
    {

        // $this->authorize("delete", Role::class);

        $role->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Role::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Role::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
