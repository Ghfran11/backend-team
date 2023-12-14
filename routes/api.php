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
    Route::post('storeUserImage',[ImageController::class,'storeUserImage']);
    Route::post('storeExercise',[ExerciseController::class,'store']);
    Route::get('showExercise',[ExerciseController::class,'show']);
    Route::post('storeExerciseImage',[ImageController::class,'storeExerciseImage']);
    Route::post('storeTime',[TimeController::class,'store']);
    Route::get('showCoachTime',[TimeController::class,'showCoachTime']);
    Route::get('showPlayerTime',[TimeController::class,'showPlayerTime']);
    Route::get('showCoach',[UserController::class,'showCoach']);
    Route::get('showPlayer',[UserController::class,'showPlayer']);
    Route::get('showCoachInfo',[UserController::class,'showCoachInfo']);

    Route::get('showDays',[DaysController::class,'index']);

    Route::get('playerInfo',[UserController::class,'playerInfo']);



});
