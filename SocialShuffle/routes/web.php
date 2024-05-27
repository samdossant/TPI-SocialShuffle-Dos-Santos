<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

// root
Route::get('/', function () {
    return redirect()->route('team.index');
});

// Team (Additional routes to a resource controller must be defined before calling the resource route)

Route::get('groupForm/{team}', [TeamController::class, 'groupForm'])
    ->name('team.groupForm');

Route::post('createGroups/{team}', [TeamController::class, 'generateGroups'])
    ->name('team.createGroups');

// resources
Route::resource('team', TeamController::class);
Route::resource('team.members', MemberController::class);

// Authentication
Route::get('login', [AuthController::class, 'login'])
    ->name('auth.login');

Route::post('login', [AuthController::class, 'applyLogin'])  
    ->name('auth.applyLogin');

Route::get('logout', [AuthController::class, 'logout'])
    ->name('auth.logout');

// About page
Route::get('about', function(){
    return view('about');
})->name('about');
