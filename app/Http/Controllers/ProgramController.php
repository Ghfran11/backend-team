<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Helpers\ResponseHelper;
use App\Services\ImageService;
use App\Services\ProgramService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreprogramRequest;
use App\Http\Requests\UpdateprogramRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use App\Http\Traits\Files;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    protected $imageService;
    protected $programService;

    public function __construct(ImageService $imageService , ProgramService $programService)
    {
        $this->imageService = $imageService;
        $this->programService=$programService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $result=$this->programService->index($request);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        $result=$this->programService->store($request);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        try {
            $result=$this->programService->show($program);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogramRequest $request, Program $program)
    {
        try {
            $result=$this->programService->update($request ,$program);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(program $program)
    {
        try {
            $result=$this->programService->destroy($program);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function downloadFile(Program $program)
    {
        try {
            $result=$this->programService->downloadFile($program);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }



    public function showMyPrograms(Request $request)
    {
        try {
            $result=$this->programService->showMyPrograms($request);
                    return ResponseHelper::success($result);


        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function assignProgram(Program $program, Request $request)
    {
        try {
            $result=$this->programService->assignProgram($program,$request);
            return ResponseHelper::success([], null, $result, 200);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function search(Request $request)
    {
        try {
            $result=$this->programService->search($request);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    // public function getCategory()
    // {
    //     try {
    //         $result = Category::query()->get()->toArray();
    //         return ResponseHelper::success($result);
    //     } catch (\Exception $e) {
    //         return ResponseHelper::error($e->getMessage(), $e->getCode());
    //     }
    // }

    public function programCommitment()
    {
        try {
            $result=$this->programService->programCommitment();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getPrograms(Request $request)
    {
        try {
            $result=$this->programService->getPrograms($request);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    public function selectProgram(Request $request)
    {
        try{
        $result=$this->programService->selectProgram($request);

        return ResponseHelper::success($result);
    } catch (\Exception $e) {
        return ResponseHelper::error($e->getMessage(), $e->getCode());
    }
    }
    public function unselectProgram(Request $request)
    {
        try{
            $result=$this->programService->unselectProgram($request);
        return ResponseHelper::success($result);
    } catch (\Exception $e) {
        return ResponseHelper::error($e->getMessage(), $e->getCode());
    }
    }
    public function recomendedProgram()
    {
        try {
            $result=$this->programService->recomendedProgram();

    return responseHelper::success($result);
} catch (\Exception $e) {
    return ResponseHelper::error($e->getMessage(), $e->getCode());
}
}

public function programDetails(Program $program)
{
    try {
        $result=$this->programService->programDetails($program);

return responseHelper::success($result);
} catch (\Exception $e) {
return ResponseHelper::error($e->getMessage(), $e->getCode());
}
}

}
