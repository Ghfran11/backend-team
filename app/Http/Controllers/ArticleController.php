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
        $user=User::find(Auth::id());
        $articles=Article::query()->get();
        foreach($articles as $article)
        {

     if($user->favorites->contains('id', $article->id))
{
         $isFavourite=true;
}
else
{

      $isFavourite=false;

}
     $results[]=$result=
     [
        'id'=>$article->id,
        'title'=>$article->title,
        'content'=>$article->content,
        'isFavourite'=>$isFavourite
     ];
    }

        return ResponseHelper::success($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $user=User::find(Auth::id());
      $article= $user->coachArticle()->create(
        [
            'title'=>$request->title,
            'content'=>$request->content
        ]
        );
        return ResponseHelper::success($article);
      }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $delete=$article->delete();

        return ResponseHelper::success($delete);
    }
    public function makeFavourite(Article $article)
    {
        $favorite=DB::table('article_user')->where('article_id',$article->id)->value('isFavourite');

        if($favorite == true)
        {
            $result=DB::table('article_user')->where('article_id',$article->id)->update(['user_id'=>Auth::id(),'isFavourite'=>false]);
        }
        else
if($favorite == false)
{

      $result=DB::table('article_user')->where('article_id',$article->id)->update(['user_id'=>Auth::id(),'isFavourite'=>true]);


      return ResponseHelper::success($result);
    }
}

    public function getCoachArticle(User $user)
    {
       $result= $user->coachArticle()->get()->toArray();
        return ResponseHelper::success($result);

    }
    public function getMyArticle()

    {
        $user=User::find(Auth::id());
        
       $result= $user->coachArticle()->get()->toArray();
        return ResponseHelper::success($result);

    }


}
