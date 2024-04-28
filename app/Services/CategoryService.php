<?php

namespace App\Services;

use App\Http\Traits\Files;
use App\Models\Category;
use App\Services\ImageService;

class CategoryService
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


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
        $image = $this->imageService->storeImage($request, null, null, $request->type);
        //dd($image[0]->image);
        $result = Category::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'imageUrl' =>$image[0]->image,
        ]);
        return $result;
    }
}
