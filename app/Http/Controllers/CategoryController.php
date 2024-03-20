<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Helpers\ResponseHelper;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
            $result = Category::query()
                ->where('type', $request->type)

                
                ->get()->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $image = $this->imageService->storeImage($request);
            $result = Category::query()->create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'imageUrl' => $image,
            ]);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
