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

Route::get('/','App\Http\Controllers\HomeController@index')->name('home');
Route::post('/signinUser','UserController@signinUser')->name('signinUser');
Route::post('/createUser','UserController@createUser')->name('createUser');
Route::post('/forgetPassword','UserController@forgetPassword')->name('forgetPassword');
Route::post('/resetPassword','UserController@resetPassword')->name('resetPassword');
Route::post('/updatePassword','UserController@updatePassword')->name('updatePassword');
Route::post('/usersQuestionnaires','Questionnaires@usersQuestionnaires')->name('usersQuestionnaires');
Route::post('/viewableQuestionnaires','Questionnaires@viewableQuestionnaires')->name('viewableQuestionnaires');
Route::post('/addQuestionnaires','Questionnaires@addQuestionnaires')->name('addQuestionnaires');
Route::post('/updateQuestionnaires','Questionnaires@updateQuestionnaires')->name('updateQuestionnaires');
Route::post('/submitQuestionnaires','Questionnaires@submitQuestionnaires')->name('submitQuestionnaires');
