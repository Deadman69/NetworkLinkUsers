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

    Route::view('/login', 'pages.login')->name("login");
    Route::post('/login', 'UserController@login')->name("login.post");
    Route::view('/register', 'pages.register')->name("register");
    Route::post('/register', 'UserController@register')->name("register.post");

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', 'UserController@logout')->name("logout");
        Route::post('/createPerson', 'PersonController@create')->name('person.create');
        Route::post('/createRelation', 'PersonController@createRelation')->name('relation.create');
        Route::post('/loadDetails', 'PersonController@load')->name('person.load');
        Route::post('/updatePerson', 'PersonController@update')->name('person.update');

        Route::get('/display', 'DisplayController@display')->name("display");

        Route::get('/users', 'UserController@listUsers')->name('users');
        Route::get('/usersToggle/{userID?}', 'UserController@toggleUser')->name('users.toggle');
        Route::get('/usersDelete/{userID?}', 'UserController@userDelete')->name('users.delete');
        Route::get('/usersAdmin/{userID?}', 'UserController@toggleAdmin')->name('users.admin');

        Route::view('/chiffrement', 'pages.chiffrement')->name("chiffrement");
    });

});
