<?php

namespace App\Enums;


enum UserRole:string
{
    //
    case User = 'user';
    case Admin = 'admin';
}



// While multi factor authentication enum is used enum is olny for valid user authentication
// $user->role = UserRole::Admin; // Safe
// Instead of repeating strings 'admin','user' time and again like:
// if($user->role=='admin')
// {

// }
// use
// if($user->role==UserRole::Admin)
// {

// }
// It reducres typos and make more maintanable.
