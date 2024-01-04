<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Http\Requests\StoreInfoRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Helpers\ResponseHelper;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInfoRequest $request)
    {
        $result=Info::query()->create(
            [
                'finance'=> $request->finance
                         ]
            );
            return ResponseHelper::success($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Info $info)
    {
        $result=$info->get()->toArray();

        return ResponseHelper::success($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInfoRequest $request, Info $info)
    {
        $result= $info->update([
            'finance'=>$request->finance
        ]

        );
        return ResponseHelper::success('updated succesfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Info $info)
    {
        //
    }
}
