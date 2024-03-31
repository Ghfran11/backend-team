<?php

namespace App\Services;

use App\Models\Category;
use App\Services\ImageService;

class CategoryService
{

    protected $imageService;

    public function index($request)
    {

        $result = Category::query()
            ->where('type', $request->type)

            ->get()->toArray();
        return $result;

    }

/**
 * Store a newly created resource in storage.
 */
    public function store($request)
    {

        $image = $this->imageService->storeImage($request);
        $result = Category::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'imageUrl' => $image,
        ]);
        return $result;

    }
}
