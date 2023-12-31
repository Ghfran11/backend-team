<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Traits\Files;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Requests\StoreprogramRequest;
use App\Http\Requests\UpdateprogramRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $result = $category->program()->get()->toArray();
        return ResponseHelper::success($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogramRequest $request)
    {

        $path = Files::saveFile($request);
        $result = Program::query()->create(
            [
                'name' => $request->name,
                'file' => $path,
                'type' => $request->type,
                'categoryId' => $request->categoryId
            ]
        );

        return ResponseHelper::success($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $result = $program->get();
        return ResponseHelper::success($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogramRequest $request, Program $program)
    {
        Files::deleteFile($program->file);
        $path = Files::saveFile($request);
        $result = $program->update([
            'name' => $request->name,
            'file' => $path,
            'categoryId' => $request->categoryId,
        ]);
        return ResponseHelper::success(
            [
                'message' => 'program updated successfuly',
                'data' => $result,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(program $program)
    {
        Files::deleteFile($program);
        $program->delete();
        return ResponseHelper::success(
            [
                'message' => 'user deleted successfully'
            ]
        );
    }

    public function downloadFile(Request $request, Program $program)
    {
        $filepath = $program->path;
        $filename = $program->name;
        return response()->download($filepath, $filename);
    }

    public function showMyPrograme()
    {
        $user = User::find(Auth::id());
        $result = $user->playerprogrames()->get()->toArray();
        return ResponseHelper::success($result);
    }
    public function assignProgram(Program $program, Request $request)
    {
        $startDate = Carbon::parse($request->startDate)
        ->addDays($request->days)
        ->toDateString();
        $attach = [
            'user_id' => Auth::id(),
            'player_id' => $request->player_id,
            'startDate' => $startDate,
            'days' => $request->days,
            'created_at' => Carbon::now()
        ];

        $result = $program
            ->coachs()
            ->syncWithoutDetaching([$attach]);


       return ResponseHelper::success([],null,'success',200);
    }

    public function search(Request $request)
    {
        $search = $request->input('search_text');
        $programs = Program::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->get();
        return ResponseHelper::success($programs);
    }
}
