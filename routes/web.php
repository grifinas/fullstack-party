<?php

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

Route::get('/login', 'LoginController@getIndex');
Route::get('/callback', 'LoginController@getSuccess');
Route::get('/logout', 'LoginController@getLogout');

Route::middleware(['access'])->group(function () {
    Route::get('/', 'IssueController@getIndex');
    Route::get('/issues/{user}/{name}/{number}', [
        'as' => 'issue',
        'uses' => 'IssueController@getIssue'
    ]);
});
