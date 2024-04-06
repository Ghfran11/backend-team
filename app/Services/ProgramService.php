<?php

namespace App\Services;

use App\Http\Traits\Files;
use App\Models\Category;
use App\Models\Program;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramService
{

    public function index($request)
    {

        $lowerCaseType = strtolower($request->type);
        $program = Program::with('category')
            ->whereHas('category', function ($query) use ($lowerCaseType, $request) {
                $query->where('type', $lowerCaseType)
                    ->where('id', $request->categoryId);
            })
            ->get()
            ->toArray();
        return $program;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {

        $path = Files::saveFile($request);
        $image = Files::saveImage($request);
        $program = Program::query()->create(
            [
                'user_id' => Auth::id(),
                'name' => $request->name,
                'file' => $path,
                'imageUrl' => $image,
                'type' => $request->type,
                'categoryId' => $request->categoryId,
            ]
        );

        if ($request->player_id && $request->days && $request->type != 'general') {
            $players = $request->player_id;
            foreach ($players as $item) {
                $attach = [
                    'user_id' => Auth::id(),
                    'startDate' => Carbon::now(),
                    'player_id' => $item,
                    'days' => $request->days,
                    'created_at' => Carbon::now(),
                ];
                $program->coachs()->syncWithoutDetaching([$attach]);

            }
        }
        return $program;

    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {

        $result = $program->get();
        return $result;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, $program)
    {
        if(Auth::id()!= $program->user_id)
        {
            return 'you can not update this program , you don not have permission';
        }

        $program->update([
            'name' => $request->name,
            'type' => $request->type,
            'categoryId' => $request->categoryId,
        ]);
        if($request->has('imageUrl'))
        {
            $image = Files::saveImage($request);
            $program->update(
                [
                    'imageUrl'=>$image
                ]
                );
        }

        if($request->has('file'))
        {
            Files::deleteFile($program->file);
        $path = Files::saveFile($request);
        $program->update(
            [
                'file'=>$path
            ]
            );
        }
        return 'program updated successfuly';

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($program)
    {

        Files::deleteFile($program);
        $program->delete();

        return 'user deleted successfully';
    }

    public function downloadFile($program)
    {

        $filepath = $program->file;
        $filename = $program->name;

        return response()->download($filepath, $filename);

    }

    public function showMyPrograms($request)
    {
        $user = User::find(Auth::id());

        if ($user->role == 'player') {
            $result = $user->playerPrograms()
                ->whereHas('category', function ($query) use ($request) {
                    $query->where('type', $request->type)
                        ->where('id', $request->categoryId);
                })
                ->get()
                ->toArray();
            return $result;
        } else {
            if ($user->role == 'coach') {

                $result = $user->program()->where('type', $request->programType)
                    ->whereHas('category', function ($query) use ($request) {
                        $query->where('type', $request->type)
                            ->where('id', $request->categoryId);
                    })
                    ->get()
                    ->toArray();
                return $result;
            }
        }
    }

    public function assignProgram($program, $request)
    {

        // $user = User::findOrFail('id', $request->player_id)->first();
        // dd( $user);
        // if ($user->role == 'coach') {
        //     return ResponseHelper::error('');

        $startDate = Carbon::parse($request->startDate)
            ->addDays($request->days)
            ->toDateString();
        $players = $request->player_id;
        foreach ($players as $item) {
            $attach = [
                'user_id' => Auth::id(),
                'startDate' => Carbon::now(),
                'player_id' => $item,
                'days' => $request->days,
                'created_at' => Carbon::now(),
            ];
            $program->coachs()->syncWithoutDetaching([$attach]);
        }
        return 'success';
    }

    public function search($request)
    {

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
            return $programs;
        }
        $programs = Program::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->get();
        return $programs;

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

        $user = User::find(Auth::id());
        $numberOfDays = $user->playerPrograms()->value('days');

        $startDate = $user->playerPrograms()->value('startDate');
        $carbonStartDate = Carbon::createFromFormat('Y-m-d', $startDate);
        $endDate = $carbonStartDate->addDays($numberOfDays);
        $userRange = $user->time()->whereBetween('startTime', [$startDate, $endDate])->count();
        $result = ($userRange / $numberOfDays) * 100;
        return $result;

    }

    public function getPrograms(Request $request)
    {

        $result = Category::query()
            ->where('id', $request->categoryId)
            ->where('type', $request->type)
            ->with([
                'program' => function ($query) use ($request) {
                    $query->where('type', $request->programType);
                },
            ])
            ->get()
            ->toArray();
        return $result;

    }
    public function selectProgram(Request $request)
    {
        $userinfo_id = UserInfo::where('userId', Auth::id())->value('id');
        $userinfo = UserInfo::find($userinfo_id);
        $program = Program::findOrFail($request->program_id);
        $programType = $program->category()->value('type');
        $existprogram = $userinfo->program()->whereHas('category', function ($query) use ($programType) {
            $query->where('type', $programType);
        })->value('program_id');
        if ($existprogram) {
            DB::table('program_userInfos')->where('program_id', $existprogram)->where('userInfo_id', $userinfo_id)->delete();
        }
        $result = DB::table('program_userInfos')->insert([
            'program_id' => $request->program_id,
            'userInfo_id' => $userinfo_id,
        ]);

        return 'set successfully';
    }
    public function unselectProgram(Request $request)
    {
        $userinfo_id = UserInfo::where('userId', Auth::id())->value('id');
        $userinfo = UserInfo::find($userinfo_id);
        $result = DB::table('program_userinfos')->where('program_id', $request->program_id)->where('userInfo_id', $userinfo_id)->delete();
        return $result;

    }
    public function recomendedProgram()
    {

        $user = User::find(Auth::id());
        $foodprogram = $user->playerPrograms()->where('type', 'general')->whereHas('category', function ($query) {
            $query->where('type', 'food');
        })
            ->get()
            ->toArray();
        if (!$foodprogram) {
            $foodprogram = Program::query()->where('type', 'recommended')->whereHas('category', function ($query) {
                $query->where('type', 'food');
            })
                ->get()
                ->toArray();
        }
        $sportprogram = $user->playerPrograms()->where('type', 'general')->whereHas('category', function ($query) {
            $query->where('type', 'sport');
        })
            ->get()
            ->toArray();

        if (!$sportprogram) {

            $sportprogram = Program::query()->where('type', 'recommended')->whereHas('category', function ($query) {
                $query->where('type', 'sport');
            })
                ->get()
                ->toArray();

        }
        $result = [
            'foodProgram' => $foodprogram,
            'sportProgram' => $sportprogram,
        ];

        return $result;
    }
    public function programDetails($program)
        {
            $type=$program->type;
            $categoryName=$program->category()->value('name');
            $categoryType=$program->category()->value('type');
            $programName=$program->name;
            $programFile=$program->file;
            $players=$program->players()->with('image')->get();
            $programDay=$program->players()->first();
            $days=$programDay->pivot->days;
            $cover=$program->imageUrl;

$result=[
    'type'=>$type,
    'categoryName'=>$categoryName,
    'categoryType'=>$categoryType,
    'programName'=>$programName,
    'programFile'=>$programFile,
    'cover'=>$cover,
    'days'=>$days,
    'players'=>$players



];
return $result;

        }


}
