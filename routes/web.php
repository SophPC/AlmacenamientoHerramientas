<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () { return view('welcome'); });

Auth::routes(['verify' => true]);

Route::middleware('verified')->group(function(){

    Route::middleware('admin')->group(function(){
        Route::get('/event/create', 'EventController@create');
        Route::post('/event/add', 'EventController@store');
        Route::get('/event/{event}/edit', 'EventController@edit');
        Route::patch('/event/{event}', 'EventController@update');
        Route::delete('/event/{event}', 'EventController@destroy');

        Route::get('/incidence/create', 'IncidenceController@create');
        Route::post('/incidence/add', 'IncidenceController@store');
        Route::get('/incidence/{incidence}/edit', 'IncidenceController@edit');
        Route::patch('/incidence/{incidence}', 'IncidenceController@update');
        Route::delete('/incidence/{incidence}', 'IncidenceController@destroy');

        Route::get('/users', 'UserController@showAll')->name('users.showAll');
        Route::get('/user/{user}', 'UserController@show');
        Route::delete('/user/{user}', 'UserController@destroy');
    });

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/dashboard/mailUpdate', 'DashboardController@mailUpdate')->name('mailUpdate');
    Route::post('/dashboard/adminReq', 'DashboardController@adminReq')->name('adminReq');
    Route::get('/logout', 'Auth\LoginController@logout');
    
    // === SHOW ===
    Route::get('/incidence/{incidence}', 'IncidenceController@show');

    // === SHOW ALL ===
    Route::get('/incidences', 'IncidenceController@showAll')->name('incidences.showAll');

    // === CREATE ===
    Route::get('/employee/create', 'EmployeeController@create');
    Route::get('/tool/create', 'ToolController@create');
    Route::get('/place/create', 'PlaceController@create');

    // === STORE ===
    Route::post('/employee/add', 'EmployeeController@store');
    Route::post('/tool/add', 'ToolController@store');
    Route::post('/place/add', 'PlaceController@store');

    // === EDIT ===
    Route::get('/employee/{employee}/edit', 'EmployeeController@edit');
    Route::get('/tool/{tool}/edit', 'ToolController@edit');
    Route::get('/place/{place}/edit', 'PlaceController@edit');

    // === UPDATE ===
    Route::patch('/employee/{employee}', 'EmployeeController@update');
    Route::patch('/tool/{tool}', 'ToolController@update');
    Route::patch('/place/{place}', 'PlaceController@update');

    // === DESTROY ===
    Route::delete('/employee/{employee}', 'EmployeeController@destroy');
    Route::delete('/tool/{tool}', 'ToolController@destroy');
    Route::delete('/place/{place}', 'PlaceController@destroy');
});

Route::get('/home', 'HomeController@index')->name('home');

// === MICROCONTROLLER ===
Route::post('/micro', 'MicroController@lectura');
Route::post('/micro/loading', 'MicroController@loading')->name('loading');

// === SHOW ===
Route::get('/event/{event}', 'EventController@show');
Route::get('/employee/{employee}', 'EmployeeController@show');
Route::get('/tool/{tool}', 'ToolController@show');
Route::get('/place/{place}', 'PlaceController@show');

// === SHOW ALL ===
Route::get('/events', 'EventController@showAll')->name('events.showAll');
Route::get('/employees', 'EmployeeController@showAll')->name('employees.showAll');
Route::get('/tools', 'ToolController@showAll')->name('tools.showAll');
Route::get('/places', 'PlaceController@showAll')->name('places.showAll');
