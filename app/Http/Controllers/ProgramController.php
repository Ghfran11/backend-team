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

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $result=$category->program()->get()->toArray();
        return ResponseHelper::success($result);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogramRequest $request)
    {
        $user=User::find(Auth::id());
        $path = Files::saveFile($request);
        $result=$user->coachprogrames()->create(
            [
                'name'=>$request->name,
                'file'=>$path,
                'type'=>$request->type,
                'categoryId'=>$request->categoryId

            ]
            );

            return ResponseHelper::success($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $result=$program->get();
        return ResponseHelper::success($result);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogramRequest $request, Program $program)
    {
        {
                    Files::deleteFile($program->file);
                    $path = Files::saveFile($request);
                   $result= $program->update([
                        'name'=>$request->name,
                        'file' => $path,
                        'categoryId'=>$request->categoryId,
                    ]);
                    return ResponseHelper::success(
                        [
                            'message'=>'program updated successfuly',
                            'data'=>$result,
                        ]
                     );

                }

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

    public function downloadFile(Request $request,Program $program)
    {
        $filepath=$program->path;
        $filename=$program->name;
        return response()->download($filepath,$filename);
    }

    public function showMyPrograme()
    {
        $user=User::find(Auth::id());
        if( $user->type = 'coach')
        {
        $result=$user->coachprogrames()->get()->toArray();
        }
        else if( $user->type = 'player')
        {
            $result=$user->playerprogrames()->get()->toArray();
        }
        return ResponseHelper::success($result);

    }
    public function assignProgram(Program $program,Request $request)
    {
       $result=$program->players()->syncWithoutDetaching(['playerId'=>$request->userId]);
       return ResponseHelper::success($result);

    }

}
