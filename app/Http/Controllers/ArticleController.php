<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\User;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;

    }
    public function index()
    {
        try {
            $result = $this->articleService->index();
            return ResponseHelper::success($result);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponseHelper::error($e->validator->errors()->first(), 400);
        } catch (\Illuminate\Database\QueryException $e) {
            return ResponseHelper::error('Query Exception', 400);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        try {
            $result = $this->articleService->store($request);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $result = $this->articleService->update($request, $id);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy(Article $article)
    {
        try {
            $results = $this->articleService->destroy($article);
            return ResponseHelper::success($results);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }

    public function makeFavourite(Article $article)
    {
        try {
            $result = $this->articleService->makeFavourite($article);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getCoachArticle(User $user)
    {
        try {

            $result = $this->articleService->getCoachArticle($user);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getMyArticle()
    {
        try {
            $result = $this->articleService->getMyArticle();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

}
