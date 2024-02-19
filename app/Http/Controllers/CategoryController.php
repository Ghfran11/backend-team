<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Traits\Files;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = Category::query()
        ->where('type', $request->type)

        ->get()->toArray();

        return ResponseHelper::success($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $image=Files::saveImage($request);
        $result = Category::query()->create([
            'name'=> $request->name,
            'description'=>$request->description,
            'type'=>$request->type,
            'imageUrl'=>$image,
        ]);
        return ResponseHelper::success($result);
    }

    /**) the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
