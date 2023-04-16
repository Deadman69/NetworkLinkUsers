<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::get('/', function () {
        return redirect(route('login'));
    })->name('root');

    Route::view('/', 'pages.login')->name("login");
    Route::post('/', 'UserController@login')->name("login.post");
    Route::get('/logout', 'UserController@logout')->name("logout");

    Route::post('/createPerson', 'PersonController@create')->name('person.create');
    Route::post('/createRelation', 'PersonController@createRelation')->name('relation.create');
    Route::post('/loadDetails', 'PersonController@load')->name('person.load');
    Route::post('/updatePerson', 'PersonController@update')->name('person.update');

    Route::get('/display', 'DisplayController@display')->name("display");
});
