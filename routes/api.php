<?php

use App\Http\Controllers\DaysController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\InfoController;
use App\Models\Category;


Route::controller(AuthController::class)->group(function () {

    Route::middleware('AdminMiddleware')->group(function () {
        Route::post('register', 'register');
    });

    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('auth:api')->group(function () {
    Route::post('storeUserImage', [ImageController::class, 'storeUserImage']);
    //exercise
    Route::post('storeExercise', [ExerciseController::class, 'store']);
    Route::get('showExercise/{exercise}', [ExerciseController::class, 'show']);
    Route::get('indexExercise', [ExerciseController::class, 'index']);
    Route::post('storeExerciseImage', [ImageController::class, 'storeExerciseImage']);

    //time
    Route::post('storeTime', [TimeController::class, 'storeCoachTime']);//coach
    Route::post('storeCoachTime', [TimeController::class, 'storeCoachTime']);
    Route::post('storeUserTime', [TimeController::class, 'storeUserTime']);
    Route::post('endCounter', [TimeController::class, 'endCounter']);
    Route::get('showMyTime', [TimeController::class, 'show']);
    Route::get('monthly', [TimeController::class, 'monthlyProgress']);
    Route::get('weekly', [TimeController::class, 'weeklyProgress']);
    Route::get('showUserTime/{user}', [TimeController::class, 'showUserTime']);
    Route::get('showCoachTime/{user}', [TimeController::class, 'showCoachTime']);

    //user
    Route::get('showCoach', [UserController::class, 'showCoach']);
    Route::get('showPlayer', [UserController::class, 'showPlayer']);
    Route::get('showCoachInfo/{id}', [UserController::class, 'showCoachInfo']);
    Route::get('showDays', [DaysController::class, 'index']);
    Route::get('playerInfo/{id}', [UserController::class, 'playerInfo']);
    Route::delete('delete/{user}', [UserController::class, 'deleteUser']);
    Route::post('updateUser/{user}', [UserController::class, 'updateUser']);
    Route::post('rate/{user}', [UserController::class, 'rateCoach']);
    //program
    Route::get('showProgram', [ProgramController::class, 'index']);
    Route::get('myprogram', [ProgramController::class, 'showMyPrograme']);
    Route::post('store', [ProgramController::class, 'store']);//Program
    Route::get('getCategory', [ProgramController::class, 'getCategory']);
    Route::post('updateprogram/{program}', [ProgramController::class, 'update']);
    Route::post('asignprogram/{program}', [ProgramController::class, 'assignProgram']);
    Route::post('programCommitment', [ProgramController::class, 'programCommitment']);
    //chat
    Route::get('listChat', [MessageController::class, 'index']);
    Route::get('showChat/{user}', [MessageController::class, 'show']);
    //message
    Route::post('sendMessage', [MessageController::class, 'store']);
    Route::delete('deleteMessage/{message}', [MessageController::class, 'destroy']);
    //notification
    Route::get('listNotification', [NotificationController::class, 'index']);
    //report
    Route::get('indexreport', [ReportController::class, 'index']);
    Route::post('report', [ReportController::class, 'store']);
    Route::delete('deletereport/{report}', [ReportController::class, 'destroy']);
    Route::get('myreport', [ReportController::class, 'showMyReport']);
    //rate
    Route::post('setRate', [RatingController::class, 'setRate']);
    Route::delete('deleteRate', [RatingController::class, 'deleteRate']);


    //subscribe
    //  Route::post('subscribe',[SubscriptionController::class,'subscribe']);

    //charts

    //
    Route::get('subscription', [UserController::class, 'subscription']);
    Route::post('updateSubscription/{user}', [UserController::class, 'updateSubscription']);
    Route::get('countActivePlayers', [TimeController::class, 'activePlayersCounter']);
    Route::get('activePlayers', [TimeController::class, 'activePlayers']);
    Route::get('mvpCoach', [UserController::class, 'mvpCoach']);
    Route::get('showPercentage', [UserController::class, 'showCountPercentage']);
    Route::get('financeMonth', [UserController::class, 'financeMonth']);


    //Search
    Route::post('programSearch', [ProgramController::class, 'search']);
    Route::post('userSearch', [UserController::class, 'search']);
    Route::get('statistics', [UserController::class, 'statistics']);


    Route::get('status', [UserController::class, 'info']);
});


Route::post('addOrder', [OrderController::class, 'store']);
Route::post('updateOrrder/{order}', [OrderController::class, 'update']);
Route::get('getMyOrder', [OrderController::class, 'getMyOrder']);
Route::post('acceptOrder/{order}', [OrderController::class, 'acceptOrder']);
Route::delete('deleteOrder', [OrderController::class, 'destroy']);
Route::post('showOrder/{order}', [OrderController::class, 'show']);
Route::get('showAnnual', [UserController::class, 'showAnnual']);

Route::post('requestPrograme', [OrderController::class, 'requestPrograme']);
Route::get('Premum', [OrderController::class, 'getPremum']);
Route::get('myPlayer', [OrderController::class, 'showMyPlayer']);
Route::get('myActivePlayer', [OrderController::class, 'MyActivePlayer']);
Route::post('cancle/{order}', [OrderController::class, 'cancleOrder']);
Route::get('unAssign/{order}', [OrderController::class, 'unAssign']);
Route::post('myPlayer', [OrderController::class, 'showMyPlayer']);

//user info
Route::post('addInfo', [UserInfoController::class, 'store']);
Route::post('updateInfo', [UserInfoController::class, 'update']);
Route::get('showInfo/{user}', [UserInfoController::class, 'show']);

//monthly Subscribtion Avg
Route::get('monSubsAvg', [SubscriptionController::class, 'monthlySubscriptionAvg']);

//finance
Route::post('storeFinance', [InfoController::class, 'store']);
Route::post('updateFinance/{info}', [InfoController::class, 'update']);
Route::get('showFinance/{info}', [InfoController::class, 'show']);
Route::get('subscriptions', [SubscriptionController::class, 'index']);
Route::get('category', [Category::class, 'index']);

//Article
Route::post('addArticle', [ArticleController::class, 'store']);
Route::get('allArticle', [ArticleController::class, 'index']);
Route::get('myArticle', [ArticleController::class, 'getMyArticle']);
Route::get('coachArticle/{user}', [ArticleController::class, 'getCoachArticle']);
Route::post('makeFavouritre/{article}', [ArticleController::class, 'makeFavourite']);


//category

Route::get('getCategories', [CategoryController::class, 'index']);
Route::post('AddCategory', [CategoryController::class, 'store']);
Route::get('getimage/{user}', [ImageController::class, 'getImages']);
