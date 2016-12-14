<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route to welcome page
Route::get('/', function () {
    return view('welcome');
});

//default Authentication Routes
Route::auth();

//route to Home page after login
Route::get('/home', 'HomeController@index');

//route to follow/unfollow route using ajax
Route::post('/doFollowShip','HomeController@doFollowShip');
