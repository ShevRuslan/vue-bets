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

//Получение спортсмена по мере ввода в селект
Route::get('/sportsmen', 'API\MatchController@getSporstsmen');
//Получение совместных матчей между двумя игроками
Route::get('/commonMatch', 'API\MatchController@commonMatch');
//Получение всех чемпионатов
Route::get('/getAllChamps', 'API\MatchController@getAllChamps');
//Получение даты последнего обновления результатов (через крон обновление)
Route::get('/getLastUpdateDate', 'API\MatchController@getLastUpdateDate');
//Получение линии
Route::get('/line', 'API\LineMatchController@line');
//Получение всех чемпионатов с линии
Route::get('/getLineChamps', 'API\LineMatchController@getLineChamps');
//Получение данных для таблицы ставок 
Route::get('/getBetsMatch', 'API\LineMatchController@getBetsMatch');
//Получение общих соперников и матчей с ними
Route::get('/getCommonRivals', 'API\MatchController@getCommonRivals');

Route::get('/getUKPlayers', 'API\PlayerController@getUKPlayers');
Route::get('/readFile', 'API\PlayerController@readFile');
Route::get('/parseSite', 'API\PlayerController@parseSite');


Route::get('/matchingPlayers', 'API\PlayerController@matchingPlayers');

Route::get("/update", 'API\MatchController@update');
