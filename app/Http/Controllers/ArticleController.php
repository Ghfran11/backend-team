<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;


use function PHPUnit\Framework\isEmpty;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::find(Auth::id());
            $articles = Article::query()->get();
            foreach ($articles as $article) {
                if ($user->favorites->contains('id', $article->id)) {
                    $isFavourite = true;
                } else {
                    $isFavourite = false;
                }
                $results[] =
                    [
                        'id' => $article->id,
                        'title' => $article->title,
                        'content' => $article->content,
                        'isFavourite' => $isFavourite
                    ];
            }
            return ResponseHelper::success($results);
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
            $user = User::findOrFail(Auth::id());
            $article = $user->coachArticle()->create(
                [
                    'title' => $request->title,
                    'content' => $request->content
                ]
            );
            return ResponseHelper::success($article);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    public function destroy(Article $article)
    {
        try {
            $delete = $article->delete();
            return ResponseHelper::success($delete);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }
    public function makeFavourite(Article $article)
    {
        try {
            $favorite = DB::table('article_user')
                ->where('article_id', $article->id)->value('isFavourite');
            if ($favorite == true) {
                $result = DB::table('article_user')
                    ->where('article_id', $article->id)
                    ->update(['user_id' => Auth::id(), 'isFavourite' => false]);
            } else
                if ($favorite == false) {
                    $result = DB::table('article_user')->where('article_id', $article->id)->update(['user_id' => Auth::id(), 'isFavourite' => true]);
                    return ResponseHelper::success($result);
                }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getCoachArticle(User $user)
    {
        try {
            $result = $user->coachArticle()->get()->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    public function getMyArticle()
    {
        try {
            $user = User::find(Auth::id());
            $result = $user->coachArticle()->get()->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


}
