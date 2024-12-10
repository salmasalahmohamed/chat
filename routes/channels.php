<?php

use Illuminate\Support\Facades\Broadcast;

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('status',function ($user){
    return ['id' => $user->id, 'name' => $user->name];
});
Broadcast::channel('send-message',function ($user){
    return $user
        ;}
);

Broadcast::channel('message-deleted',function ($user){
    return $user
        ;});


    Broadcast::channel('update-message',function ($user){
        return $user
            ;}
);
