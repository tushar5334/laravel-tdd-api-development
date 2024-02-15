<?php

namespace App\Http\Controllers;

use App\Http\Requests\LableRequest;
use App\Http\Resources\LableResource;
use App\Models\Lable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LableController extends Controller
{
    public function index()
    {
        $lable = auth()->user()->lables;
        //return $lable;
        return LableResource::collection($lable);
    }
    public function store(LableRequest $request)
    {

        $lable = auth()->user()->lables()->create($request->validated());
        //return $lable;
        return new LableResource($lable);
    }

    public function destroy(Lable $lable)
    {
        $lable->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(LableRequest $request, Lable $lable)
    {
        //return $lable->update($request->validated());
        $lable->update($request->validated());
        return new LableResource($lable);
    }
}
