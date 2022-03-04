<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'CalorificController@index');
Route::get('/search', 'CalorificController@search');
Route::get('/edit/{id}', 'CalorificController@edit');
Route::post('/add','CalorificController@add');
Route::post('/storeData','CalorificController@parseAllFromCsv');
Route::post('/saveData/{id}','CalorificController@saveData');
Route::get('/distroy/{id}','CalorificController@distroy');


// Route::delete('/distroy/{id}','CalorificController@distroy');