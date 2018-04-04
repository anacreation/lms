<?php
/**
 * Author: Xavier Au
 * Date: 1/3/2018
 * Time: 7:23 PM
 */

Route::get("home", "HomeController@index")
     ->name("home")->middleware();
Route::get("login",
    "Auth\LoginController@showLoginForm")
     ->name("login")->middleware("guest");
Route::post("login",
    "Auth\LoginController@login")
     ->middleware("guest");
Route::post("logout",
    "Auth\LoginController@logout")
     ->name("logout");
Route::post("password/email",
    "Auth\ForgotPasswordController@sendResetLinkEmail")
     ->name("password.email")->middleware("guest");
Route::get("password/reset",
    "Auth\ForgotPasswordController@showLinkRequestForm")
     ->name("password.request")->middleware("guest");
Route::post("password/reset",
    "Auth\ResetPasswordController@reset")
     ->middleware("guest");
Route::get("password/reset/{token}",
    "Auth\ResetPasswordController@showResetForm")
     ->name("password.reset")->middleware("guest");
Route::get("register",
    "Auth\RegisterController@showRegistrationForm")
     ->name("register")->middleware("guest");
Route::post("register",
    "Auth\RegisterController@register")
     ->middleware("guest");