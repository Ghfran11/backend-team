<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $report=Report::query()
        ->with('user.image')
        ->get()->toArray();

        return ResponseHelper::success($report);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $reports=Report::query()->create(
            [
                'userId'=>Auth::id(),
                'text'=>$request->text,
                'title'=>$request->title,
            ]
            );
            return ResponseHelper::success($reports);


    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
       $reports =$report->get();
       return ResponseHelper::success($reports);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return ResponseHelper::success(
            [
                'message'=>'deleted successfuly'
            ]
        );

    }
    public function showMyReport()
    {
        $user=User::find(Auth::id());
        $result=$user->report()->get();
        return  ResponseHelper::success($result);
    }
}
