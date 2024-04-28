<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\User;
use App\Services\ArticleService;
use Auth;
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
        $result = $this->articleService->index();
        return ResponseHelper::success($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $result = $this->articleService->store($request);
        return ResponseHelper::success($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->articleService->update($request, $id);
        return ResponseHelper::success($result);

    }

    public function destroy(Article $article)
    {
        $results = $this->articleService->destroy($article);
        return ResponseHelper::success($results);
    }

    public function makeFavourite(Article $article)
    {
        $user_id = Auth::user()->id;
        $result = $this->articleService->makeFavourite($article, $user_id);
        return ResponseHelper::success($result);
    }

    public function getCoachArticle(User $user)
    {
        $result = $this->articleService->getCoachArticle($user);
        return ResponseHelper::success($result);
    }

    public function getMyArticle()
    {
        $result = $this->articleService->getMyArticle();
        return ResponseHelper::success($result);

    }

}
