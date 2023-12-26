<?php

use App\Http\Controllers\DaysController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Programe;


Route::controller(AuthController::class)->group(function () {

    Route::middleware('AdminMiddleware')->group(function () {
        Route::post('register', 'register');
    });

    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::middleware('auth:api')->group(function () {






    Route::post('storeUserImage',[ImageController::class,'storeUserImage']);


    //exercise
    Route::post('storeExercise',[ExerciseController::class,'store']);
    Route::get('showExercise/{exercise}',[ExerciseController::class,'show']);
    Route::get('indexExercise',[ExerciseController::class,'index']);
    Route::post('storeExerciseImage',[ImageController::class,'storeExerciseImage']);
    //time
    Route::post('storeTime',[TimeController::class,'store']);
    Route::post('storeCoachTime',[TimeController::class,'storeCoachTime']);
    Route::post('storeUserTime',[TimeController::class,'storeUserTime']);
    Route::post('endCounter',[TimeController::class,'endCounter']);
    Route::get('showMyTime',[TimeController::class,'show']);




    Route::get('showUserTime/{user}',[TimeController::class,'showUserTime']);
    //Route::get('showPlayerTime',[TimeController::class,'showPlayerTime']);

//user
    Route::get('showCoach',[UserController::class,'showCoach']);
    Route::get('showPlayer',[UserController::class,'showPlayer']);
    Route::get('showCoachInfo/{id}',[UserController::class,'showCoachInfo']);
    Route::get('showDays',[DaysController::class,'index']);
    Route::get('playerInfo/{id}',[UserController::class,'playerInfo']);
    Route::delete('delete/{user}',[UserController::class,'deleteUser']);
    Route::post('update/{user}',[UserController::class,'updateUser']);
    Route::post('rate/{user}',[UserController::class,'rateCoach']);


    //program
    Route::get('index/{category}',[ProgramController::class,'index']);
    Route::get('myprogram',[ProgramController::class,'showMyPrograme']);
    Route::post('store',[ProgramController::class,'store']);
    Route::post('updateprogram/{program}',[ProgramController::class,'update']);
    Route::post('asignprogram/{program}',[ProgramController::class,'assignProgram']);

    //chat
    Route::get('listChat',[MessageController::class,'index']);
    Route::get('showChat',[MessageController::class,'show']);

    //message
    Route::post('sendMessage',[MessageController::class,'store']);
    Route::delete('deleteMessage/{message}',[MessageController::class,'destroy']);

    //notification
    Route::get('listNotification',[NotificationController::class,'index']);



    //report
    Route::get('/indexreport',[ReportController::class ,'index']);
    Route::post('/report',[ReportController::class ,'store']);
    Route::delete('/deletereport/{report}',[ReportController::class ,'destroy']);
    Route::get('/myreport',[ReportController::class ,'showMyReport']);


    //rate
    Route::post('setRate',[RatingController::class,'setRate']);
    Route::delete('deleteRate',[RatingController::class,'deleteRate']);



    //subscribe
    Route::post('subscribe',[SubscriptionController::class,'subscribe']);


    //charts
    Route::get('showPercentage',[UserController::class,'showPercentage']);
    Route::get('mvpCoach',[UserController::class,'mvpCoach']);



});
