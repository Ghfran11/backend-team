<?php

use App\Http\Controllers\DaysController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
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
    Route::get('showUserTime/{user}',[TimeController::class,'showUserTime']);
    //Route::get('showPlayerTime',[TimeController::class,'showPlayerTime']);


    Route::get('showCoach',[UserController::class,'showCoach']);
    Route::get('showPlayer',[UserController::class,'showPlayer']);
    Route::get('showCoachInfo',[UserController::class,'showCoachInfo']);
    Route::get('showDays',[DaysController::class,'index']);
    Route::get('playerInfo/{user}',[UserController::class,'playerInfo']);



});
