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

    public function __construct(ImageService $imageService, ProgramService $programService)
    {
        $this->imageService = $imageService;
        $this->programService = $programService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = $this->programService->index($request);
        return ResponseHelper::success($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->programService->store($request);
        return ResponseHelper::success($result);
    }


    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $result = $this->programService->show($program);
        return ResponseHelper::success($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogramRequest $request, Program $program)
    {
        $result = $this->programService->update($request, $program);
        return ResponseHelper::success($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(program $program)
    {
        $result = $this->programService->destroy($program);
        return ResponseHelper::success($result);
    }

    public function downloadFile(Program $program)
    {
        $result = $this->programService->downloadFile($program);

    }

    public function showMyPrograms(Request $request)
    {
        $result = $this->programService->showMyPrograms($request);
        return ResponseHelper::success($result);
    }

    public function assignProgram(Program $program, Request $request)
    {
        $result = $this->programService->assignProgram($program, $request);
        return ResponseHelper::success([], null, $result, 200);
    }

    public function search(Request $request)
    {
        $result = $this->programService->search($request);
        return ResponseHelper::success($result);
    }

    public function programCommitment()
    {
        $result = $this->programService->programCommitment();
        return ResponseHelper::success($result);
    }

    public function getPrograms(Request $request)
    {
        $result = $this->programService->getPrograms($request);
        return ResponseHelper::success($result);
    }

    public function selectProgram(Request $request)
    {
        $result = $this->programService->selectProgram($request);
        return ResponseHelper::success($result);
    }

    public function unselectProgram(Request $request)
    {
        $result = $this->programService->unselectProgram($request);
        return ResponseHelper::success($result);
    }

    public function recomendedProgram()
    {
        $result = $this->programService->recomendedProgram();
        return responseHelper::success($result);
    }

    public function programDetails(Program $program)
    {
        $result = $this->programService->programDetails($program);
        return responseHelper::success($result);
    }

}
