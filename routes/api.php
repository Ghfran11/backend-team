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


Route::controller(AuthController::class)->group(function () {

    Route::middleware('AdminMiddleware')->group(function () {
        Route::post('register', 'register');
    });

    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::middleware('auth:api')->group(function () {
    Route::controller(ImageController::class)->group(function () {
    Route::post('storeUserImage', 'storeUserImage');
    Route::delete('deleteUserImage/{image}','deleteOneImage');
    Route::delete('deleteAll/{user}','deleteAllUserImage');
    Route::get('getimage/{user}', 'getImages');
    });

    //exercise
    Route::controller(ExerciseController::class)->group(function () {
    Route::post('storeExercise', 'store');
    Route::get('showExercise/{exercise}', 'show');
    Route::get('indexExercise', 'index');
    Route::post('storeExerciseImage', 'storeExerciseImage');
    });

    //time
    Route::controller(TimeController::class)->group(function () {
    Route::post('storeTime', 'storeCoachTime');//coach
    Route::post('storeCoachTime', 'storeCoachTime');
    Route::post('storeUserTime', 'storeUserTime');
    Route::post('endCounter', 'endCounter');
    Route::get('showMyTime', 'show');
    Route::get('monthly','monthlyProgress');
    Route::get('weekly','weeklyProgress');
    Route::get('showUserTime/{user}', 'showUserTime');
    Route::get('showCoachTime/{user}', 'showCoachTime');
    Route::get('countActivePlayers', 'activePlayersCounter');
    Route::get('activePlayers','activePlayers');
    Route::get('exite','Exite');
    });

    //user
    Route::controller(UserController::class)->group(function () {
    Route::get('showCoach',  'showCoach');
    Route::get('showPlayer', 'showPlayer');
    Route::get('showCoachInfo/{id}', 'showCoachInfo');
    Route::get('showDays',  'index');
    Route::get('playerInfo/{id}', 'playerInfo');
    Route::delete('delete/{user}',  'deleteUser');
    Route::post('updateUser/{user}', 'updateUser');

    Route::post('rate/{user}','rateCoach');
    Route::get('subscription', 'subscription');
    Route::post('updateSubscription/{user}', 'updateSubscription');
    Route::get('showPercentage', 'showCountPercentage');
    Route::get('financeMonth', 'financeMonth');
    Route::get('mvpCoach', 'mvpCoach');
    Route::get('status','info');
    Route::post('userSearch', 'search');
    Route::get('statistics',  'statistics');
    });
    //program
    Route::controller(ProgramController::class)->group(function () {
    Route::get('showProgram', 'index');
    Route::get('allProgramByType',  'indexByType');
    Route::get('myprogram','showMyPrograms');
    Route::post('store','store');//Program
    Route::get('getCategory',  'getCategory');
    Route::post('updateprogram/{program}','update');
    Route::get('deleteProgram/{program}','destroy');
    Route::post('asignprogram/{program}', 'assignProgram');
    Route::post('programCommitment',  'programCommitment');
    Route::get('downloadFile/{program}', 'downloadFile');
    Route::get('getPrograms','getPrograms');
    Route::post('selectProgram','selectProgram');
    Route::post('unselectProgram',  'unselectProgram');
    Route::get('recommendedProgram', 'recomendedProgram');
    Route::get('programDetails/{program}', 'programDetails');
    Route::post('programSearch', 'search');
    });
    //chat
    Route::controller(MessageController::class)->group(function () {
    Route::get('contactList', 'contactList');//for chat
    Route::get('listChat', 'index');
    Route::get('showChat/{user}','show');
    //message
    Route::post('sendMessage','store');
    Route::delete('deleteMessage/{message}', 'destroy');
    });
    //notification
    Route::controller(NotificationController::class)->group(function () {
    Route::get('listNotification',  'index');
    });
    //report
    Route::controller(ReportController::class)->group(function () {
    Route::get('indexreport','index');
    Route::post('report', 'store');
    Route::delete('deletereport/{report}', 'destroy');
    Route::get('myreport', 'showMyReport');
    //rate
    Route::post('setRate','setRate');
    Route::delete('deleteRate', 'deleteRate');
    });

    //subscribe
    //  Route::post('subscribe',[SubscriptionController::class,'subscribe']);

    Route::controller(OrderController::class)->group(function () {
    Route::post('addOrder' ,'store');
    Route::post('updateOrrder/{order}','update');
    Route::get('getMyOrder',  'getMyOrder');
    Route::post('acceptOrder/{order}', 'acceptOrder');
    Route::delete('deleteOrder' ,'destroy');
    Route::post('showOrder/{order}', 'show');
    Route::get('showAnnual', 'showAnnual');

    Route::post('requestPrograme','requestProgram');
    Route::get('Premum',  'getPremium');
    Route::get('myPlayer',  'showMyPlayer');
    Route::get('myActivePlayer', 'myActivePlayer');
    Route::post('cancle/{order}', 'cancelOrder');
    Route::get('unAssign/{user}', 'unAssign');
    Route::get('deletePlayer/{user}',  'deletePlayer');
    Route::post('myPlayer', 'showMyPlayer');
    });
//user info
Route::controller(UserInfoController::class)->group(function () {
    Route::post('addInfo', 'store');
    Route::post('updateInfo', 'update');
    Route::get('showInfo/{user}', 'show');
    Route::post('storeFinance','store');
    Route::post('updateFinance/{info}', 'update');
    Route::get('showFinance/{info}', 'show');
    Route::post('updateUserInfo', 'updateInfo');
});
//monthly Subscription Avg
Route::controller(SubscriptionController::class)->group(function () {
    Route::get('monSubsAvg','monthlySubscriptionAvg');
    Route::get('subscriptions', 'index');
});
//Article
Route::controller(ArticleController::class)->group(function () {
    Route::post('addArticle',  'store');
    Route::get('allArticle', 'index');
    Route::delete('deleteArticle/{article}','destroy');
    Route::post('updateArticle/{id}', 'update');
    Route::get('myArticle', 'getMyArticle');
    Route::get('coachArticle/{user}', 'getCoachArticle');
    Route::post('makeFavourite/{article}', 'makeFavourite');
});

//category
Route::controller(CategoryController::class)->group(function () {
    Route::get('getCategories', 'index');
    Route::post('AddCategory', 'store');

});
});

