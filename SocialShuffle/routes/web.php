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

// Team algorithm (Additional routes to a resource controller must be defined before calling the resource route)

// CSV import
Route::post('import-csv/{team}', [TeamController::class, 'importCSV'])
    ->name('team.importCSV');

// Create groups
Route::get('groupForm/{team}', [TeamController::class, 'groupForm'])
    ->name('team.groupForm');

Route::post('createGroups/{team}', [TeamController::class, 'generateGroups'])
    ->name('team.createGroups');

// Show a specific activity
Route::get('showActivity/{team}/{generation}', [TeamController::class, 'showActivity'])
    ->name('team.showActivity');

// Download CSV example
Route::get('csv-example',[TeamController::class, 'csvDownload'])
    ->name('team.csvDownload');

// Delete a pecific group
Route::delete('group/destroy/{group}',[GroupController::class, 'deleteGroup'])
    ->name('group.destroy');
    

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
