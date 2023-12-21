<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     if($user)
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('welcome-message', function ($user) {
    return $user->role != 'admin';
});
Broadcast::channel('message', function ($message) {
    return $message->reciver_id == Auth::id();
});


// Broadcast::channel('user-withCoach', function ($user) {
//     return $user->role == Auth::id(); //TODO to the coach
// });

Broadcast::channel('subscription-expiration', function ($user) {
    return $user->id == Auth::id(); //TODO to the player
});
