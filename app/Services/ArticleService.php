<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function index()
    {
        $user = User::find(Auth::id());
        $articles = Article::query()->get();
        foreach ($articles as $article) {
            $isFav = $article->users()->where('user_id', Auth::id())->value('isFavourite');

            if ($isFav == true) {
                $isFavourite = true;
            } else {
                $isFavourite = false;
            }

            $results[] =
                [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'isFavourite' => $isFavourite,
            ];

        }
        return $results;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {

        //  $validated = $request->validated();
        $user = User::findOrFail(Auth::id());
        $article = $user->coachArticle()->create(
            [
                'title' => $request->title,
                'content' => $request->content,
            ]
        );
        return $article;
    }

    public function update($request, $id)
    {

        $user = User::findOrFail(Auth::id());
        $user->coachArticle()->where('article_id', $id)
            ->update(
                [
                    'title' => $request->title,
                    'content' => $request->content,
                ]
            );
        return 'updated';

    }

    public function destroy($article)
    {

        $delete = $article->delete();
        return $delete;

    }

    public function makeFavourite(Article $article)
    {

        $favorite = DB::table('article_user')
            ->where('article_id', $article->id)->first();
        if ($favorite) {
            if ($favorite->isFavourite == true) {
                DB::table('article_user')
                    ->where('article_id', $article->id)
                    ->update(['isFavourite' => false]);
                return 'isFavourite : false';
            } elseif ($favorite->isFavourite == false) {
                DB::table('article_user')->where('article_id', $article->id)
                    ->update(['isFavourite' => true]);
                return 'isFavourite :true';
            }
        }
        DB::table('article_user')->insert([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'coach_id' => null,
            'isFavourite' => true,
        ]);
        return 'isFavourite :true';

    }

    public function getCoachArticle(User $user)
    {
        $articles = $user->coachArticle()->get();
        if(!empty($articles->toArray()))
       {
        foreach ($articles as $article) {
            $isFav = DB::table('article_user')
                ->where('article_id', $article->id)->where('user_id', Auth::id())->value('isFavourite');

            if ($user->favorites->contains('id', $article->id) && $isFav == true) {
                $isFavourite = true;
            } else {
                $isFavourite = false;
            }

            $results[] =
                [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'isFavourite' => $isFavourite,
            ];
        }
        return $results;
    }

    else
    {
    return null;
}
    }

    public function getMyArticle()
    {
        $user = User::find(Auth::id());
        $result = $user->coachArticle()->get()->toArray();
        return $result;

    }

}
