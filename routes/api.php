<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/sportsmen','API\MatchController@getSporstsmen');
Route::get('/commonMatch','API\MatchController@commonMatch');
Route::get('/getAllChamps','API\MatchController@getAllChamps');
Route::get('/getLastUpdateDate','API\MatchController@getLastUpdateDate');