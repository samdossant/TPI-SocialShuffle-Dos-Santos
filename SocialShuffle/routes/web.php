<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

// root
Route::get('/', function () {
    return redirect()->route('team.index');
});

// resources
Route::resource('team', TeamController::class);
Route::resource('team.members', MemberController::class);
Route::resource('group', GroupController::class);

// Authentication
Route::get('login', [AuthController::class, 'login'])       
    ->name('auth.login');

Route::get('login', [AuthController::class, 'applyLogin'])  
    ->name('auth.applyLogin');

// About page
Route::get('about', function(){
    return view('about');
})->name('about');
