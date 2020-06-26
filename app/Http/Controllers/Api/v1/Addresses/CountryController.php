<?php

namespace App\Http\Controllers\Api\v1\Addresses;

use App\Http\Controllers\Controller;

use App\Models\Addresses\Country;
// use App\Http\Requests\Payments\CountryRequest;
use App\Http\Resources\Addresses\CountryResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountryController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Country::class);

        $datas = Country::get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(CountryResource::collection($datas));
    }

    // public function indexOnlyTrashed()
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = Country::onlyTrashed()->get();

    //     if (count($datas) == 0)
    //         throw new ModelNotFoundException;

    //     return dataResponse(CountryResource::collection($datas));
    // }

    // public function store(CountryRequest $request)
    // {

    //     // $this->authorize("create", Country::class);

    //     $data = $request->validated();

    //     $data = Country::create($data);

    //     return dataResponse(new CountryResource($data));
    // }

    // public function show(Country $Country)
    // {

    //     // $this->authorize("view", Country::class);

    //     return dataResponse(new CountryResource($Country));
    // }

    // public function update(CountryRequest $request, Country $Country)
    // {

    //     // $this->authorize("update", Country::class);

    //     $data = $request->validated();

    //     $Country->update($data);

    //     return dataResponse(new CountryResource($Country));
    // }

    // public function destroy(Country $Country)
    // {

    //     // $this->authorize("delete", Country::class);

    //     $Country->delete();

    //     return destoryResponse();
    // }

    // public function restore($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = Country::onlyTrashed()->findOrFail($id);

    //     $data->restore();

    //     return restoreResponse();
    // }

    // public function forceDestroy($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = Country::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     return forceDestoryResponse();
    // }
}
