<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Requests\StoreprogramRequest;
use App\Http\Requests\UpdateprogramRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Traits\Files;
use Carbon\Carbon;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category=Category::where('type',$request->type)
        ->where('categoryId',$request->categoryId);
        $program=Program::with('category')
        ->get()
        ->where('category.type',$request->type)->toArray();
       // $result = $category->with('program')->get()->toArray();
        return ResponseHelper::success($program);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogramRequest $request)
    {

        $path = Files::saveFile($request);
        $image=Files::saveImage($request);
        $result = Program::query()->create(
            [
                'name' => $request->name,
                'file' => $path,
                'imageUrl'=> $image,
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

    public function showMyPrograme(Request $request)
    {
        $categoryId=Category::where('type',$request->type)->value('id');

      //  $result = $category->with('program')->where('categoryId', $categoryId)->get()->toArray();
        $user = User::find(Auth::id());
        $result = $user->playerprogrames()->get()
        ->where('category.type',$request->type)
        ->toArray();


        return ResponseHelper::success($result);
    }
    public function assignProgram(Program $program, Request $request)
    {
        $startDate = Carbon::parse($request->startDate)
        ->addDays($request->days)
        ->toDateString();
        $players=$request->player_id;
        foreach($players as $item)
        {
        $attach = [
            'user_id' => Auth::id(),
            'startDate' => $startDate,
            'player_id'=>$item,
            'days' => $request->days,
            'created_at' => Carbon::now()
        ];

        $result = $program->coachs()->syncWithoutDetaching([$attach]);
    }

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
    public function getCategory()
    {
        $result=Category::query()->get()->toArray();
        return ResponseHelper::success($result);
    }
}
