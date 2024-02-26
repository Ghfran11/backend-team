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
        try {
            $report = Report::query()
                ->with('user.image')
                ->get()->toArray();
            return ResponseHelper::success($report);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        try {
            $reports = Report::query()->create(
                [
                    'userId' => Auth::id(),
                    'text' => $request->text,
                    'title' => $request->title,
                ]
            );
            return ResponseHelper::success($reports);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        try {
            $reports = $report->get();
            return ResponseHelper::success($reports);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        try {
            $report->delete();
            return ResponseHelper::success(
                [
                    'message' => 'deleted successfully'
                ]
            );
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    public function showMyReport()
    {
        try {
            $user = User::find(Auth::id());
            $result = $user->report()->get();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
