<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Helpers\ResponseHelper;
use App\Services\ImageService;
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

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lowerCaseType = strtolower($request->type);
            $program = Program::with('category')
                ->whereHas('category', function ($query) use ($lowerCaseType, $request) {
                    $query->where('type', $lowerCaseType)
                        ->where('id', $request->categoryId);
                })
                ->get()
                ->toArray();
            return ResponseHelper::success($program);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogramRequest $request)
    {
        try {
            $path = Files::saveFile($request);
            $image = Files::saveImage($request);
            $result = Program::query()->create(
                [
                    'user_id' => Auth::id(),
                    'name' => $request->name,
                    'file' => $path,
                    'imageUrl' => $image,
                    'type' => $request->type,
                    'categoryId' => $request->categoryId
                ]
            );
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
            $result = $program->get();
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
            Files::deleteFile($program->file);
            $path = Files::saveFile($request);
            $program->update([
                'name' => $request->name,
                'file' => $path,
                'categoryId' => $request->categoryId,
            ]);
            return ResponseHelper::success('program updated successfuly');
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
            Files::deleteFile($program);
            $program->delete();
            return ResponseHelper::success(
                [
                    'message' => 'user deleted successfully'
                ]
            );
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function downloadFile(Program $program)
    {
        try {
            $filepath = $program->path;
            $filename = $program->name;
            return response()->download($filepath, $filename);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function showMyPrograms(Request $request)
    {
        try {
            $user = User::find(Auth::id());
            if ($user->role == 'player') {
                $result = $user->playerPrograms()
                    ->whereHas('category', function ($query) use ($request) {
                        $query->where('type', $request->type)
                            ->where('id', $request->categoryId);
                    })
                    ->get()
                    ->toArray();
                return ResponseHelper::success($result);
            } else {
                if ($user->role == 'coach') {
                    $result = $user->program()->where('type', $request->programType)
                        ->whereHas('category', function ($query) use ($request) {
                            $query->where('type', $request->type)
                                ->where('id', $request->categoryId);
                        })
                        ->get()
                        ->toArray();
                    return ResponseHelper::success($result);
                }
            }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function assignProgram(Program $program, Request $request)
    {
        try {
            $user = User::findOrFail('id', $request->player_id)->first();
            if ($user->role == 'coach') {
                return ResponseHelper::error('');
            }
            $startDate = Carbon::parse($request->startDate)
                ->addDays($request->days)
                ->toDateString();
            $players = $request->player_id;
            foreach ($players as $item) {
                $attach = [
                    'user_id' => Auth::id(),
                    'startDate' => $startDate,
                    'player_id' => $item,
                    'days' => $request->days,
                    'created_at' => Carbon::now()
                ];
                $program->coachs()->syncWithoutDetaching([$attach]);
            }
            return ResponseHelper::success([], null, 'success', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function search(Request $request)
    {
        try {
            $search = $request->search_text;
            if ($request->categoryId && $request->programType) {
                $programs = Program::query()
                    ->where('categoryId', intval($request->categoryId))
                    ->where('type', $request->programType)
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('type', 'LIKE', "%{$search}%");
                    })
                    ->get();
                return ResponseHelper::success($programs);
            }
            $programs = Program::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('type', 'LIKE', "%{$search}%")
                ->get();
            return ResponseHelper::success($programs);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getCategory()
    {
        try {
            $result = Category::query()->get()->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function programCommitment()
    {
        try {
            $user = User::find(Auth::id());
            $numberOfDays = $user->playerPrograms()->value('days');

            $startDate = $user->playerPrograms()->value('startDate');
            $carbonStartDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = $carbonStartDate->addDays($numberOfDays);
            $userRange = $user->time()->whereBetween('startTime', [$startDate, $endDate])->count();
            $result = ($userRange / $numberOfDays) * 100;
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getPrograms(Request $request)
    {
        try {
            $result = Category::query()
                ->where('id', $request->categoryId)
                ->where('type', $request->type)
                ->with([
                    'program' => function ($query) use ($request) {
                        $query->where('type', $request->programType);
                    }
                ])
                ->get()
                ->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    public function selectProgram(Request $request)
    {
        $userinfo_id = UserInfo::where('userId', Auth::id())->value('id');
        $userinfo = UserInfo::find($userinfo_id);

        $result = $userinfo->program()->syncWithoutDetaching([
            'program_id' => $request->program_id,
            'userInfo_id' => $userinfo_id
        ]);


        return ResponseHelper::success('set successfully');
    }
    public function unselectProgram(Request $request)
    {
        $userinfo_id = UserInfo::where('userId', Auth::id())->value('id');
        $userinfo = UserInfo::find($userinfo_id);
        $result = DB::table('program_userinfos')->where('program_id', $request->program_id)->where('userInfo_id', $userinfo_id)->delete();
        return ResponseHelper::success($result);

    }

}
